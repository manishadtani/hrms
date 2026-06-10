<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

/**
 * Employee Self-Service — View and edit own profile
 */
class ProfileController extends Controller
{
    public function show()
    {
        $employee = Employee::with(['user', 'department', 'designation', 'manager'])
            ->where('user_id', auth()->id())
            ->first();

        if (!$employee) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Employee profile not found.');
        }

        return view('employee.profile.show', compact('employee'));
    }

    public function edit()
    {
        $employee = Employee::with(['user', 'department', 'designation'])
            ->where('user_id', auth()->id())
            ->first();

        if (!$employee) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Employee profile not found.');
        }

        return view('employee.profile.edit', compact('employee'));
    }

    public function update(Request $request)
    {
        $employee = Employee::where('user_id', auth()->id())->first();

        if (!$employee) {
            return redirect()->route('employee.dashboard')
                ->with('error', 'Employee profile not found.');
        }

        $request->validate([
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $employee->update([
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ]);

        return redirect()->route('employee.profile.show')
            ->with('success', 'Profile updated successfully!');
    }
}
