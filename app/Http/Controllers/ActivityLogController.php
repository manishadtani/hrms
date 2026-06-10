<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    /**
     * Display activity logs with filters
     */
    public function index(Request $request)
    {
        $query = Activity::with('causer', 'subject')->latest();

        // Filter by causer (user)
        if ($request->filled('user_id')) {
            $query->where('causer_id', $request->user_id)
                  ->where('causer_type', 'App\\Models\\User');
        }

        // Filter by log name
        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search in description
        if ($request->filled('search')) {
            $query->where('description', 'LIKE', '%' . $request->search . '%');
        }

        $activities = $query->paginate(20)->withQueryString();

        // Get unique log names for filter dropdown
        $logNames = Activity::distinct()->pluck('log_name')->filter();

        // Get users for filter
        $users = \App\Models\User::orderBy('name')->get(['id', 'name']);

        return view('admin.activity-logs.index', compact('activities', 'logNames', 'users'));
    }

    /**
     * Clear old activity logs
     */
    public function clear(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:365',
        ]);

        $count = Activity::where('created_at', '<', now()->subDays($request->days))->count();
        Activity::where('created_at', '<', now()->subDays($request->days))->delete();

        return redirect()->route('admin.activity-logs.index')
            ->with('success', $count . ' activity logs older than ' . $request->days . ' days cleared!');
    }
}
