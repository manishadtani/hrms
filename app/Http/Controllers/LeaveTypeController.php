<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

/**
 * Admin: Leave Type Configuration CRUD
 */
class LeaveTypeController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::withCount('leaveRequests')->get();
        return view('admin.leave-types.index', compact('leaveTypes'));
    }

    public function create()
    {
        return view('admin.leave-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:leave_types,name',
            'code' => 'required|string|max:10|unique:leave_types,code',
            'days_per_year' => 'required|integer|min:1|max:365',
            'description' => 'nullable|string',
        ]);

        LeaveType::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'days_per_year' => $request->days_per_year,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.leave-types.index')
            ->with('success', 'Leave type created successfully!');
    }

    public function edit(LeaveType $leaveType)
    {
        return view('admin.leave-types.edit', compact('leaveType'));
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:leave_types,name,' . $leaveType->id,
            'code' => 'required|string|max:10|unique:leave_types,code,' . $leaveType->id,
            'days_per_year' => 'required|integer|min:1|max:365',
            'description' => 'nullable|string',
        ]);

        $leaveType->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'days_per_year' => $request->days_per_year,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.leave-types.index')
            ->with('success', 'Leave type updated successfully!');
    }

    public function destroy(LeaveType $leaveType)
    {
        if ($leaveType->leaveRequests()->count() > 0) {
            return redirect()->route('admin.leave-types.index')
                ->with('error', 'Cannot delete leave type with existing requests!');
        }
        $leaveType->delete();
        return redirect()->route('admin.leave-types.index')
            ->with('success', 'Leave type deleted successfully!');
    }
}
