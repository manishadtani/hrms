<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Notifications\LeaveApproved;
use App\Notifications\LeaveRejected;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * Admin: View all leave requests, override decisions
 */
class LeaveRequestController extends Controller
{
    /**
     * View all leave requests with filters
     */
    public function index(Request $request)
    {
        $query = LeaveRequest::with(['employee.user', 'employee.department', 'leaveType', 'approver']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('leave_type_id')) {
            $query->where('leave_type_id', $request->leave_type_id);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('employee_code', 'LIKE', "%{$search}%");
            });
        }

        $leaveRequests = $query->latest()->paginate(15)->withQueryString();
        $leaveTypes = LeaveType::where('is_active', true)->get();

        // Summary — single query instead of 3 separate COUNTs
        $statusCounts = LeaveRequest::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $summary = [
            'pending' => $statusCounts->get('pending', 0),
            'approved' => $statusCounts->get('approved', 0),
            'rejected' => $statusCounts->get('rejected', 0),
        ];

        return view('admin.leaves.index', compact('leaveRequests', 'leaveTypes', 'summary'));
    }

    /**
     * Admin can approve/reject any leave
     */
    public function updateStatus(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_remarks' => 'nullable|string',
        ]);

        $leaveRequest->status = $request->status;
        $leaveRequest->approved_by = auth()->id();
        $leaveRequest->admin_remarks = $request->admin_remarks;
        $leaveRequest->approved_at = now();
        $leaveRequest->save();

        // Update leave balance if approved
        if ($request->status === 'approved') {
            $this->updateLeaveBalance($leaveRequest, 'deduct');
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
            \Log::warning('Leave status notification failed: ' . $e->getMessage());
        }

        $statusText = ucfirst($request->status);
        return redirect()->back()->with('success', "Leave request {$statusText} successfully!");
    }

    /**
     * Update leave balance when leave is approved/cancelled
     */
    private function updateLeaveBalance(LeaveRequest $leaveRequest, $action)
    {
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

        if ($action === 'deduct') {
            $balance->used_days += $leaveRequest->total_days;
            $balance->remaining_days = $balance->total_days - $balance->used_days;
        } elseif ($action === 'refund') {
            $balance->used_days -= $leaveRequest->total_days;
            $balance->remaining_days = $balance->total_days - $balance->used_days;
        }

        $balance->save();
    }
}
