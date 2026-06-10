<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * View team attendance — only employees reporting to this manager
     */
    public function index(Request $request)
    {
        $managerId = auth()->id();

        // Get team members (employees whose manager_id = current user)
        $teamIds = Employee::where('manager_id', $managerId)
            ->pluck('id');

        $date = $request->filled('date') ? $request->date : Carbon::today()->toDateString();

        $attendances = Attendance::with(['employee.user', 'employee.department'])
            ->whereIn('employee_id', $teamIds)
            ->where('date', $date)
            ->get();

        // Team summary
        $summary = [
            'total_team' => $teamIds->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'half_day' => $attendances->where('status', 'half_day')->count(),
            'on_leave' => $attendances->where('status', 'leave')->count(),
        ];

        return view('manager.attendance.index', compact('attendances', 'date', 'summary'));
    }

    /**
     * View own attendance
     */
    public function myAttendance(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->first();

        if (!$employee) {
            return redirect()->route('manager.dashboard')
                ->with('error', 'Employee profile not found.');
        }

        $month = $request->filled('month') ? $request->month : Carbon::now()->format('Y-m');
        $startDate = Carbon::parse($month)->startOfMonth();
        $endDate = Carbon::parse($month)->endOfMonth();

        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        $summary = [
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'half_day' => $attendances->where('status', 'half_day')->count(),
            'leave' => $attendances->where('status', 'leave')->count(),
            'total_hours' => $attendances->sum('working_hours'),
        ];

        $todayAttendance = Attendance::where('employee_id', $employee->id)
            ->where('date', Carbon::today())
            ->first();

        return view('manager.attendance.my-attendance', compact('attendances', 'summary', 'month', 'todayAttendance', 'employee'));
    }
}
