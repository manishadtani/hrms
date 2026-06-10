<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\LeaveSubmitted;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LeaveController extends Controller
{
    /**
     * View leave history + leave balances
     */
    public function index()
    {
        $employee = Employee::where('user_id', auth()->id())->first();
        if (!$employee) {
            return redirect()->route('employee.dashboard')->with('error', 'Employee profile not found.');
        }

        $leaveRequests = LeaveRequest::with('leaveType')
            ->where('employee_id', $employee->id)
            ->latest()
            ->paginate(10);

        // Leave balances for current year
        $year = Carbon::now()->year;
        $leaveTypes = LeaveType::where('is_active', true)->get();
        $balances = LeaveBalance::where('employee_id', $employee->id)
            ->where('year', $year)
            ->get()
            ->keyBy('leave_type_id');

        // Build balance display with defaults
        $leaveBalances = $leaveTypes->map(function ($type) use ($balances) {
            $balance = $balances->get($type->id);
            return [
                'type' => $type,
                'total' => $balance ? $balance->total_days : $type->days_per_year,
                'used' => $balance ? $balance->used_days : 0,
                'remaining' => $balance ? $balance->remaining_days : $type->days_per_year,
            ];
        });

        return view('employee.leaves.index', compact('leaveRequests', 'leaveBalances', 'employee'));
    }

    /**
     * Show apply leave form
     */
    public function create()
    {
        $leaveTypes = LeaveType::where('is_active', true)->get();
        return view('employee.leaves.create', compact('leaveTypes'));
    }

    /**
     * Submit leave application
     */
    public function store(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->first();

        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|min:10',
        ]);

        // Calculate business days
        $totalDays = LeaveRequest::calculateBusinessDays($request->start_date, $request->end_date);

        if ($totalDays <= 0) {
            return redirect()->back()->with('error', 'Selected dates fall on weekends only!')->withInput();
        }

        // Check leave balance
        $year = Carbon::parse($request->start_date)->year;
        $leaveType = LeaveType::find($request->leave_type_id);
        $balance = LeaveBalance::firstOrCreate(
            ['employee_id' => $employee->id, 'leave_type_id' => $request->leave_type_id, 'year' => $year],
            ['total_days' => $leaveType->days_per_year, 'used_days' => 0, 'remaining_days' => $leaveType->days_per_year]
        );

        if ($balance->remaining_days < $totalDays) {
            return redirect()->back()
                ->with('error', "Insufficient {$leaveType->name} balance! Available: {$balance->remaining_days} days, Requested: {$totalDays} days.")
                ->withInput();
        }

        // Check overlapping leaves
        $overlap = LeaveRequest::where('employee_id', $employee->id)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_date', [$request->start_date, $request->end_date])
                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('start_date', '<=', $request->start_date)
                         ->where('end_date', '>=', $request->end_date);
                  });
            })->exists();

        if ($overlap) {
            return redirect()->back()->with('error', 'You already have a leave request for overlapping dates!')->withInput();
        }

        $leaveRequest = LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $request->leave_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_days' => $totalDays,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        // Notify manager or admin about new leave request
        try {
            $leaveRequest->load('leaveType', 'employee');
            if ($employee->manager_id) {
                $manager = User::find($employee->manager_id);
                if ($manager) $manager->notify(new LeaveSubmitted($leaveRequest));
            } else {
                // Notify all admins if no manager assigned
                $admins = User::role('admin')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new LeaveSubmitted($leaveRequest));
                }
            }
        } catch (\Exception $e) {
            // Don't fail leave submission if email fails
            \Log::warning('Leave notification email failed: ' . $e->getMessage());
        }

        return redirect()->route('employee.leaves.index')
            ->with('success', "Leave applied successfully for {$totalDays} day(s)! Waiting for approval.");
    }

    /**
     * Cancel pending leave request
     */
    public function cancel(LeaveRequest $leaveRequest)
    {
        $employee = Employee::where('user_id', auth()->id())->first();

        if ($leaveRequest->employee_id !== $employee->id) {
            abort(403);
        }
        if ($leaveRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending leave requests can be cancelled.');
        }

        $leaveRequest->update(['status' => 'cancelled']);

        return redirect()->route('employee.leaves.index')
            ->with('success', 'Leave request cancelled successfully.');
    }
}
