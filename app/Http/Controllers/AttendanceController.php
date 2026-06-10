<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * AttendanceController — Admin Attendance Management
 * 
 * Admin can:
 * - View all attendance records
 * - Manual attendance entry
 * - Attendance corrections
 * - Daily/Monthly reports
 */
class AttendanceController extends Controller
{
    /**
     * View all attendance — with date filter & employee search
     */
    public function index(Request $request)
    {
        $query = Attendance::with(['employee.user', 'employee.department']);

        // Filter by date (default: today)
        $date = $request->filled('date') ? $request->date : Carbon::today()->toDateString();
        $query->where('date', $date);

        // Search by employee name or code
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('employee_code', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->latest()->paginate(15)->withQueryString();
        $employees = Employee::where('employment_status', 'active')->get();

        // Summary counts — single query instead of 4 separate COUNTs
        $totalActive = Employee::where('employment_status', 'active')->count();
        $statusCounts = Attendance::where('date', $date)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $summary = [
            'total' => $totalActive,
            'present' => $statusCounts->get('present', 0),
            'absent' => $statusCounts->get('absent', 0),
            'half_day' => $statusCounts->get('half_day', 0),
            'on_leave' => $statusCounts->get('leave', 0),
        ];

        return view('admin.attendance.index', compact('attendances', 'employees', 'date', 'summary'));
    }

    /**
     * Show manual attendance entry form
     */
    public function create()
    {
        $employees = Employee::where('employment_status', 'active')
            ->with('user')
            ->get();

        return view('admin.attendance.create', compact('employees'));
    }

    /**
     * Store manual attendance entry
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'clock_in' => 'nullable|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i|after:clock_in',
            'status' => 'required|in:present,absent,half_day,leave,holiday',
            'remarks' => 'nullable|string',
        ]);

        // Check if attendance already exists for this employee on this date
        $existing = Attendance::where('employee_id', $request->employee_id)
            ->where('date', $request->date)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Attendance already exists for this employee on this date!')
                ->withInput();
        }

        $attendance = new Attendance();
        $attendance->employee_id = $request->employee_id;
        $attendance->date = $request->date;
        $attendance->clock_in = $request->clock_in;
        $attendance->clock_out = $request->clock_out;
        $attendance->status = $request->status;
        $attendance->remarks = $request->remarks;
        $attendance->calculateWorkingHours();
        $attendance->save();

        return redirect()->route('admin.attendance.index', ['date' => $request->date])
            ->with('success', 'Attendance recorded successfully!');
    }

    /**
     * Show edit form for attendance correction
     */
    public function edit(Attendance $attendance)
    {
        $attendance->load('employee.user');
        return view('admin.attendance.edit', compact('attendance'));
    }

    /**
     * Update attendance (correction)
     */
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'clock_in' => 'nullable|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i|after:clock_in',
            'status' => 'required|in:present,absent,half_day,leave,holiday',
            'remarks' => 'nullable|string',
        ]);

        $attendance->clock_in = $request->clock_in;
        $attendance->clock_out = $request->clock_out;
        $attendance->status = $request->status;
        $attendance->remarks = $request->remarks;
        $attendance->calculateWorkingHours();
        $attendance->save();

        return redirect()->route('admin.attendance.index', ['date' => $attendance->date->toDateString()])
            ->with('success', 'Attendance updated successfully!');
    }

    /**
     * Monthly attendance report
     */
    public function monthlyReport(Request $request)
    {
        $month = $request->filled('month') ? $request->month : Carbon::now()->format('Y-m');
        $startDate = Carbon::parse($month)->startOfMonth();
        $endDate = Carbon::parse($month)->endOfMonth();
        $daysInMonth = $startDate->daysInMonth;

        $employees = Employee::where('employment_status', 'active')
            ->with(['attendances' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('date', [$startDate, $endDate]);
            }, 'department'])
            ->get();

        // Calculate summary for each employee
        $report = $employees->map(function ($employee) use ($daysInMonth) {
            $attendances = $employee->attendances;
            return [
                'employee' => $employee,
                'present' => $attendances->where('status', 'present')->count(),
                'absent' => $attendances->where('status', 'absent')->count(),
                'half_day' => $attendances->where('status', 'half_day')->count(),
                'leave' => $attendances->where('status', 'leave')->count(),
                'holiday' => $attendances->where('status', 'holiday')->count(),
                'total_hours' => $attendances->sum('working_hours'),
                'total_days' => $daysInMonth,
            ];
        });

        return view('admin.attendance.monthly-report', compact('report', 'month', 'daysInMonth'));
    }
}
