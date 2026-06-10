<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Carbon\Carbon;

/**
 * Manager Team View — View reporting employees
 */
class TeamController extends Controller
{
    public function index()
    {
        $managerId = auth()->id();
        $today = Carbon::today();

        $teamMembers = Employee::with(['user', 'department', 'designation'])
            ->where('manager_id', $managerId)
            ->orderBy('first_name')
            ->get();

        $teamIds = $teamMembers->pluck('id');

        // Bulk load today's attendance for all team members (1 query instead of N)
        $todayAttendances = Attendance::whereIn('employee_id', $teamIds)
            ->whereDate('date', $today)
            ->get()
            ->keyBy('employee_id');

        // Bulk load approved leaves for today (1 query instead of N)
        $onLeaveIds = LeaveRequest::whereIn('employee_id', $teamIds)
            ->where('status', 'approved')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->pluck('employee_id')
            ->toArray();

        // Enrich with today's status — NO queries in loop
        $teamData = $teamMembers->map(function ($employee) use ($todayAttendances, $onLeaveIds) {
            $attendance = $todayAttendances->get($employee->id);
            $onLeave = in_array($employee->id, $onLeaveIds);

            return [
                'employee' => $employee,
                'status' => $attendance ? ($attendance->clock_out ? 'Completed' : 'Working') : ($onLeave ? 'On Leave' : 'Absent'),
                'clock_in' => $attendance ? $attendance->clock_in : null,
                'clock_out' => $attendance ? $attendance->clock_out : null,
            ];
        });

        return view('manager.team.index', ['team' => $teamData]);
    }
}
