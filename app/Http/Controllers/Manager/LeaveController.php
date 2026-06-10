<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\Employee;
use App\Notifications\LeaveApproved;
use App\Notifications\LeaveRejected;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LeaveController extends Controller
{
    /**
     * View pending leave requests from team members
     */
    public function index(Request $request)
    {
        $managerId = auth()->id();
        $teamIds = Employee::where('manager_id', $managerId)->pluck('id');

        $query = LeaveRequest::with(['employee.user', 'employee.department', 'leaveType'])
            ->whereIn('employee_id', $teamIds);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default: show pending first
            $query->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected', 'cancelled')");
        }

        $leaveRequests = $query->latest()->paginate(15)->withQueryString();

        // Summary — single query instead of 3 separate COUNTs
        $statusCounts = LeaveRequest::whereIn('employee_id', $teamIds)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $summary = [
            'pending' => $statusCounts->get('pending', 0),
            'approved' => $statusCounts->get('approved', 0),
            'rejected' => $statusCounts->get('rejected', 0),
        ];

        return view('manager.leaves.index', compact('leaveRequests', 'summary'));
    }

    /**
     * Approve or Reject leave request
     */
    public function updateStatus(Request $request, LeaveRequest $leaveRequest)
    {
        $managerId = auth()->id();
        $teamIds = Employee::where('manager_id', $managerId)->pluck('id');

        // Security: only approve/reject team members' leaves
        if (!$teamIds->contains($leaveRequest->employee_id)) {
            abort(403, 'You can only manage your team members\' leaves.');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_remarks' => 'nullable|string',
        ]);

        $leaveRequest->status = $request->status;
        $leaveRequest->approved_by = auth()->id();
        $leaveRequest->admin_remarks = $request->admin_remarks;
        $leaveRequest->approved_at = now();
        $leaveRequest->save();

        // Update balance on approval
        if ($request->status === 'approved') {
            $year = $leaveRequest->start_date->year;
            $balance = LeaveBalance::firstOrCreate(
                [
                    'employee_id' => $leaveRequest->employee_id,
                    'leave_type_id' => $leaveRequest->leave_type_id,
                    'year' => $year,
                ],
                [
                    'total_days' => $leaveRequest->leaveType->days_per_year,
                    'used_days' => 0,
                    'remaining_days' => $leaveRequest->leaveType->days_per_year,
                ]
            );

            $balance->used_days += $leaveRequest->total_days;
            $balance->remaining_days = $balance->total_days - $balance->used_days;
            $balance->save();
        }

        // Send email notification to employee
        try {
            $leaveRequest->load('leaveType', 'employee.user');
            $employeeUser = $leaveRequest->employee->user;
            if ($employeeUser) {
                if ($request->status === 'approved') {
                    $employeeUser->notify(new LeaveApproved($leaveRequest));
                } else {
                    $employeeUser->notify(new LeaveRejected($leaveRequest));
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Manager leave notification failed: ' . $e->getMessage());
        }

        return redirect()->route('manager.leaves.index')
            ->with('success', 'Leave request ' . ucfirst($request->status) . ' successfully!');
    }

    /**
     * View own leave history (manager is also an employee)
     */
    public function myLeaves()
    {
        $employee = Employee::where('user_id', auth()->id())->first();
        if (!$employee) {
            return redirect()->route('manager.dashboard')->with('error', 'Employee profile not found.');
        }

        $leaveRequests = LeaveRequest::with('leaveType')
            ->where('employee_id', $employee->id)
            ->latest()
            ->paginate(10);

        $year = Carbon::now()->year;
        $leaveTypes = \App\Models\LeaveType::where('is_active', true)->get();
        $balances = LeaveBalance::where('employee_id', $employee->id)
            ->where('year', $year)->get()->keyBy('leave_type_id');

        $leaveBalances = $leaveTypes->map(function ($type) use ($balances) {
            $balance = $balances->get($type->id);
            return [
                'type' => $type,
                'total' => $balance ? $balance->total_days : $type->days_per_year,
                'used' => $balance ? $balance->used_days : 0,
                'remaining' => $balance ? $balance->remaining_days : $type->days_per_year,
            ];
        });

        return view('manager.leaves.my-leaves', compact('leaveRequests', 'leaveBalances'));
    }
}
