<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Holiday;
use App\Models\Announcement;
use App\Models\User;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Cache stats for 5 minutes (300 seconds) — reduces 9 queries to 1 cache hit
        $stats = Cache::remember('admin_dashboard_stats_' . $today->toDateString(), 300, function () use ($today, $currentMonth, $currentYear) {
            $activeEmployees = Employee::where('employment_status', 'active')->count();
            $presentToday = Attendance::whereDate('date', $today)->count();

            return [
                'totalEmployees' => Employee::count(),
                'activeEmployees' => $activeEmployees,
                'presentToday' => $presentToday,
                'absentToday' => $activeEmployees - $presentToday,
                'pendingLeaves' => LeaveRequest::where('status', 'pending')->count(),
                'onLeaveToday' => LeaveRequest::where('status', 'approved')
                    ->where('start_date', '<=', $today)
                    ->where('end_date', '>=', $today)
                    ->count(),
                'monthlyAttendance' => Attendance::whereMonth('date', $currentMonth)
                    ->whereYear('date', $currentYear)
                    ->count(),
            ];
        });

        // These change less frequently — cache for 10 minutes
        $upcomingHolidays = Cache::remember('admin_upcoming_holidays', 600, function () use ($today) {
            return Holiday::where('is_active', true)
                ->where('date', '>=', $today)
                ->orderBy('date', 'asc')
                ->take(5)
                ->get();
        });

        $departmentStats = Cache::remember('admin_department_stats', 600, function () {
            return Department::withCount('employees')->get();
        });

        // These should be fresh — no cache
        $recentAnnouncements = Announcement::where('status', 'published')
            ->with('creator')
            ->latest('published_at')
            ->take(3)
            ->get();

        $recentLeaves = LeaveRequest::with(['employee.user', 'leaveType'])
            ->latest()
            ->take(5)
            ->get();

        // Extract cached values
        $totalEmployees = $stats['totalEmployees'];
        $activeEmployees = $stats['activeEmployees'];
        $presentToday = $stats['presentToday'];
        $absentToday = $stats['absentToday'];
        $pendingLeaves = $stats['pendingLeaves'];
        $onLeaveToday = $stats['onLeaveToday'];
        $monthlyAttendance = $stats['monthlyAttendance'];

        return view('admin.dashboard', compact(
            'totalEmployees', 'activeEmployees', 'presentToday', 'absentToday',
            'pendingLeaves', 'onLeaveToday', 'upcomingHolidays', 'recentAnnouncements',
            'departmentStats', 'recentLeaves', 'monthlyAttendance'
        ));
    }
}
