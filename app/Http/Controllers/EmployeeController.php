<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * List all employees with search & filter
     * 
     * MERN equivalent:
     * Employee.find(filters)
     *   .populate('user department designation manager')
     *   .sort('-createdAt')
     *   .skip(skip).limit(limit)
     */
    public function index(Request $request)
    {
        $query = Employee::with(['user', 'department', 'designation', 'manager']);

        // Search by name, email, employee code
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('employee_code', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by department
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Filter by designation
        if ($request->filled('designation_id')) {
            $query->where('designation_id', $request->designation_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('employment_status', $request->status);
        }

        $employees = $query->latest()->paginate(10)->withQueryString();
        $departments = Department::where('is_active', true)->get();
        $designations = Designation::where('is_active', true)->get();

        return view('admin.employees.index', compact('employees', 'departments', 'designations'));
    }

    /**
     * Show create employee form
     */
    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        $designations = Designation::where('is_active', true)->get();
        $managers = User::role('manager')->get(); // Only users with manager role

        return view('admin.employees.create', compact('departments', 'designations', 'managers'));
    }

    /**
     * Store new employee + create user account
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'employee_code' => 'required|string|unique:employees,employee_code',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'manager_id' => 'nullable|exists:users,id',
            'joining_date' => 'nullable|date',
            'employment_status' => 'required|in:active,inactive,terminated,resigned',
        ]);

        // Step 1: Create User account (for login)
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make('password123'), // Default password
            'email_verified_at' => now(),
        ]);

        // Step 2: Assign employee role
        $user->assignRole('employee');

        // Step 3: Create Employee record
        Employee::create([
            'user_id' => $user->id,
            'employee_code' => $request->employee_code,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'address' => $request->address,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'manager_id' => $request->manager_id,
            'joining_date' => $request->joining_date,
            'employment_status' => $request->employment_status,
        ]);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee created successfully! Default password: password123');
    }

    /**
     * Show employee profile
     */
    public function show(Employee $employee)
    {
        $employee->load(['user', 'department', 'designation', 'manager']);
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show edit form
     */
    public function edit(Employee $employee)
    {
        $departments = Department::where('is_active', true)->get();
        $designations = Designation::where('is_active', true)->get();
        $managers = User::role('manager')->get();

        return view('admin.employees.edit', compact('employee', 'departments', 'designations', 'managers'));
    }

    /**
     * Update employee
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->user_id,
            'employee_code' => 'required|string|unique:employees,employee_code,' . $employee->id,
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'manager_id' => 'nullable|exists:users,id',
            'joining_date' => 'nullable|date',
            'employment_status' => 'required|in:active,inactive,terminated,resigned',
        ]);

        // Update user account
        $employee->user->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
        ]);

        // Update employee record
        $employee->update([
            'employee_code' => $request->employee_code,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'address' => $request->address,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'manager_id' => $request->manager_id,
            'joining_date' => $request->joining_date,
            'employment_status' => $request->employment_status,
        ]);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully!');
    }

    /**
     * Delete employee + user account
     */
    public function destroy(Employee $employee)
    {
        $user = $employee->user;
        $employee->delete();
        $user->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully!');
    }
}
