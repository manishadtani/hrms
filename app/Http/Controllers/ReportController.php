<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Department;
use App\Models\LeaveType;
use App\Models\Holiday;
use App\Exports\EmployeeExport;
use App\Exports\AttendanceExport;
use App\Exports\LeaveExport;
use App\Exports\HolidayExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * Admin Reports Controller
 * Generates Employee, Attendance, Leave, and Holiday reports
 */
class ReportController extends Controller
{
    /**
     * Reports Dashboard — Links to all report types
     */
    public function index()
    {
        return view('admin.reports.index');
    }

    /**
     * Employee Directory Report
     */
    public function employees(Request $request)
    {
        $query = Employee::with(['user', 'department', 'designation', 'manager']);

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->filled('status')) {
            $query->where('employment_status', $request->status);
        }

        $employees = $query->orderBy('first_name')->get();
        $departments = Department::all();

        return view('admin.reports.employees', compact('employees', 'departments'));
    }

    /**
     * Attendance Report — Monthly summary for all employees
     */
    public function attendance(Request $request)
    {
        $month = $request->filled('month') ? $request->month : Carbon::now()->month;
        $year = $request->filled('year') ? $request->year : Carbon::now()->year;

        $employees = Employee::with('department')
            ->where('employment_status', 'active')
            ->orderBy('first_name')
            ->get();

        // Calculate working days in month (exclude weekends)
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $workingDays = 0;
        $tempDate = $startDate->copy();
        while ($tempDate->lte($endDate)) {
            if (!$tempDate->isWeekend()) $workingDays++;
            $tempDate->addDay();
        }

        // Bulk query: attendance counts per employee (1 query instead of N)
        $attendanceCounts = Attendance::selectRaw('employee_id, COUNT(*) as total')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->groupBy('employee_id')
            ->pluck('total', 'employee_id');

        // Bulk query: leave totals per employee (1 query instead of N)
        $leaveTotals = LeaveRequest::selectRaw('employee_id, SUM(total_days) as total')
            ->where('status', 'approved')
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate]);
            })
            ->groupBy('employee_id')
            ->pluck('total', 'employee_id');

        // Build report data (no extra queries!)
        $attendanceData = [];
        foreach ($employees as $employee) {
            $present = $attendanceCounts[$employee->id] ?? 0;
            $leavesTaken = $leaveTotals[$employee->id] ?? 0;

            $attendanceData[] = [
                'employee' => $employee,
                'present' => $present,
                'absent' => max(0, $workingDays - $present - $leavesTaken),
                'leaves' => $leavesTaken,
                'percentage' => $workingDays > 0 ? round(($present / $workingDays) * 100, 1) : 0,
            ];
        }

        $monthName = Carbon::create($year, $month, 1)->format('F Y');

        return view('admin.reports.attendance', compact(
            'attendanceData', 'month', 'year', 'workingDays', 'monthName'
        ));
    }

    /**
     * Leave Report — Leave usage summary
     */
    public function leaves(Request $request)
    {
        $year = $request->filled('year') ? $request->year : Carbon::now()->year;

        $leaveTypes = LeaveType::all();
        $employees = Employee::with('department')
            ->where('employment_status', 'active')
            ->orderBy('first_name')
            ->get();

        // Bulk query: all leave usage in 1 query (instead of N × M queries)
        $leaveUsage = LeaveRequest::selectRaw('employee_id, leave_type_id, SUM(total_days) as total')
            ->where('status', 'approved')
            ->whereYear('start_date', $year)
            ->groupBy('employee_id', 'leave_type_id')
            ->get()
            ->groupBy('employee_id');

        $leaveData = [];
        foreach ($employees as $employee) {
            $row = ['employee' => $employee, 'types' => []];
            $empLeaves = $leaveUsage[$employee->id] ?? collect();

            foreach ($leaveTypes as $type) {
                $used = $empLeaves->where('leave_type_id', $type->id)->first()->total ?? 0;
                $row['types'][$type->code] = [
                    'total' => $type->days_per_year,
                    'used' => $used,
                    'remaining' => $type->days_per_year - $used,
                ];
            }
            $leaveData[] = $row;
        }

        return view('admin.reports.leaves', compact('leaveData', 'leaveTypes', 'year'));
    }

    /**
     * Holiday Report
     */
    public function holidays(Request $request)
    {
        $year = $request->filled('year') ? $request->year : Carbon::now()->year;
        $holidays = Holiday::whereYear('date', $year)->orderBy('date')->get();

        $summary = [
            'total' => $holidays->count(),
            'national' => $holidays->where('type', 'national')->count(),
            'regional' => $holidays->where('type', 'regional')->count(),
            'company' => $holidays->where('type', 'company')->count(),
            'optional' => $holidays->where('type', 'optional')->count(),
        ];

        return view('admin.reports.holidays', compact('holidays', 'year', 'summary'));
    }

    // ========================================
    // EXPORT METHODS — Excel & PDF
    // ========================================

    /**
     * Export Employee Report
     */
    public function exportEmployees(Request $request)
    {
        $format = $request->get('format', 'excel');
        $filename = 'Employee_Report_' . date('Y-m-d');

        if ($format === 'pdf') {
            $employees = Employee::with(['user', 'department', 'designation', 'manager'])->get();
            $pdf = Pdf::loadView('admin.reports.pdf.employees', compact('employees'))
                ->setPaper('a4', 'landscape');
            return $pdf->download($filename . '.pdf');
        }

        return Excel::download(
            new EmployeeExport($request->department_id, $request->status),
            $filename . '.xlsx'
        );
    }

    /**
     * Export Attendance Report
     */
    public function exportAttendance(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);
        $format = $request->get('format', 'excel');
        $filename = 'Attendance_Report_' . Carbon::create($year, $month, 1)->format('F_Y');

        if ($format === 'pdf') {
            // Reuse the attendance() method logic
            $data = $this->getAttendanceData($month, $year);
            $pdf = Pdf::loadView('admin.reports.pdf.attendance', $data)
                ->setPaper('a4', 'landscape');
            return $pdf->download($filename . '.pdf');
        }

        return Excel::download(new AttendanceExport($month, $year), $filename . '.xlsx');
    }

    /**
     * Export Leave Report
     */
    public function exportLeaves(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $format = $request->get('format', 'excel');
        $filename = 'Leave_Report_' . $year;

        if ($format === 'pdf') {
            $leaveTypes = LeaveType::all();
            $employees = Employee::with('department')->where('employment_status', 'active')->get();
            $leaveUsage = LeaveRequest::selectRaw('employee_id, leave_type_id, SUM(total_days) as total')
                ->where('status', 'approved')->whereYear('start_date', $year)
                ->groupBy('employee_id', 'leave_type_id')->get()->groupBy('employee_id');

            $pdf = Pdf::loadView('admin.reports.pdf.leaves', compact('employees', 'leaveTypes', 'leaveUsage', 'year'))
                ->setPaper('a4', 'landscape');
            return $pdf->download($filename . '.pdf');
        }

        return Excel::download(new LeaveExport($year), $filename . '.xlsx');
    }

    /**
     * Export Holiday Report
     */
    public function exportHolidays(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $format = $request->get('format', 'excel');
        $filename = 'Holiday_Report_' . $year;

        if ($format === 'pdf') {
            $holidays = Holiday::whereYear('date', $year)->orderBy('date')->get();
            $pdf = Pdf::loadView('admin.reports.pdf.holidays', compact('holidays', 'year'))
                ->setPaper('a4', 'portrait');
            return $pdf->download($filename . '.pdf');
        }

        return Excel::download(new HolidayExport($year), $filename . '.xlsx');
    }

    /**
     * Helper: Get attendance data for PDF export
     */
    private function getAttendanceData($month, $year)
    {
        $employees = Employee::with('department')->where('employment_status', 'active')->orderBy('first_name')->get();
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $workingDays = 0;
        $tempDate = $startDate->copy();
        while ($tempDate->lte($endDate)) {
            if (!$tempDate->isWeekend()) $workingDays++;
            $tempDate->addDay();
        }

        $attendanceCounts = Attendance::selectRaw('employee_id, COUNT(*) as total')
            ->whereMonth('date', $month)->whereYear('date', $year)
            ->groupBy('employee_id')->pluck('total', 'employee_id');

        $leaveTotals = LeaveRequest::selectRaw('employee_id, SUM(total_days) as total')
            ->where('status', 'approved')
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate]);
            })->groupBy('employee_id')->pluck('total', 'employee_id');

        $attendanceData = [];
        foreach ($employees as $employee) {
            $present = $attendanceCounts[$employee->id] ?? 0;
            $leavesTaken = $leaveTotals[$employee->id] ?? 0;
            $attendanceData[] = [
                'employee' => $employee,
                'present' => $present,
                'absent' => max(0, $workingDays - $present - $leavesTaken),
                'leaves' => $leavesTaken,
                'percentage' => $workingDays > 0 ? round(($present / $workingDays) * 100, 1) : 0,
            ];
        }

        $monthName = Carbon::create($year, $month, 1)->format('F Y');
        return compact('attendanceData', 'month', 'year', 'workingDays', 'monthName');
    }
}
