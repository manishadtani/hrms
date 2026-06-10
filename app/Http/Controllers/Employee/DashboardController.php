<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\Holiday;
use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $employee = Employee::where('user_id', auth()->id())->first();
        $today = Carbon::today();
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Today's attendance — always fresh
        $todayAttendance = null;
        $monthlyPresent = 0;
        if ($employee) {
            $todayAttendance = Attendance::where('employee_id', $employee->id)
                ->whereDate('date', $today)->first();
            $monthlyPresent = Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->count();
        }

        // Leave Balances — cache per employee for 10 minutes
        $leaveBalances = collect();
        if ($employee) {
            $leaveBalances = Cache::remember("emp_leave_bal_{$employee->id}_{$currentYear}", 600, function () use ($employee, $currentYear) {
                $leaveTypes = LeaveType::where('is_active', true)->get();
                $balances = LeaveBalance::where('employee_id', $employee->id)
                    ->where('year', $currentYear)->get()->keyBy('leave_type_id');

                return $leaveTypes->map(function ($type) use ($balances) {
                    $balance = $balances->get($type->id);
                    return [
                        'type' => $type,
                        'total' => $balance ? $balance->total_days : $type->days_per_year,
                        'used' => $balance ? $balance->used_days : 0,
                        'remaining' => $balance ? $balance->remaining_days : $type->days_per_year,
                    ];
                });
            });
        }

        // Pending leaves count
        $pendingLeaves = $employee ? LeaveRequest::where('employee_id', $employee->id)
            ->where('status', 'pending')->count() : 0;

        // Shared data — cache for 10 minutes (same for all employees)
        $upcomingHolidays = Cache::remember('upcoming_holidays', 600, function () use ($today) {
            return Holiday::where('is_active', true)
                ->where('date', '>=', $today)
                ->orderBy('date')->take(5)->get();
        });

        $recentAnnouncements = Cache::remember('recent_announcements', 600, function () {
            return Announcement::where('status', 'published')
                ->with('creator')
                ->latest('published_at')->take(3)->get();
        });

        return view('employee.dashboard', compact(
            'employee', 'todayAttendance', 'monthlyPresent',
            'leaveBalances', 'pendingLeaves', 'upcomingHolidays', 'recentAnnouncements'
        ));
    }
}
