<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Holiday;
use App\Models\Announcement;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $managerId = auth()->id();
        $today = Carbon::today();
        $teamIds = Employee::where('manager_id', $managerId)->pluck('id');

        // Team Stats
        $teamSize = $teamIds->count();
        $presentToday = Attendance::whereIn('employee_id', $teamIds)
            ->whereDate('date', $today)->count();
        $absentToday = $teamSize - $presentToday;

        // Team Leave Stats
        $pendingLeaves = LeaveRequest::whereIn('employee_id', $teamIds)
            ->where('status', 'pending')->count();
        $onLeaveToday = LeaveRequest::whereIn('employee_id', $teamIds)
            ->where('status', 'approved')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->count();

        // Team members list
        $teamMembers = Employee::with(['user', 'department', 'designation'])
            ->whereIn('id', $teamIds)->get();

        // Upcoming Holidays
        $upcomingHolidays = Holiday::where('is_active', true)
            ->where('date', '>=', $today)
            ->orderBy('date')->take(5)->get();

        // Recent Announcements
        $recentAnnouncements = Announcement::where('status', 'published')
            ->with('creator')
            ->latest('published_at')->take(3)->get();

        // Recent team leave requests
        $recentLeaves = LeaveRequest::with(['employee.user', 'leaveType'])
            ->whereIn('employee_id', $teamIds)
            ->latest()->take(5)->get();

        return view('manager.dashboard', compact(
            'teamSize', 'presentToday', 'absentToday', 'pendingLeaves',
            'onLeaveToday', 'teamMembers', 'upcomingHolidays',
            'recentAnnouncements', 'recentLeaves'
        ));
    }
}
