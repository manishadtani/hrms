<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

/**
 * DepartmentController — Full CRUD
 * 
 * MERN equivalent (Express):
 * router.get('/departments', index)        → List all
 * router.get('/departments/create', create) → Show form
 * router.post('/departments', store)        → Save new
 * router.get('/departments/:id/edit', edit)  → Show edit form
 * router.put('/departments/:id', update)    → Update
 * router.delete('/departments/:id', destroy) → Delete
 */
class DepartmentController extends Controller
{
    /**
     * List all departments with employee count
     * MERN: Department.find().sort('-createdAt')
     */
    public function index(Request $request)
    {
        $query = Department::withCount('employees');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $departments = $query->latest()->paginate(10);

        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.departments.create');
    }

    /**
     * Store new department
     * MERN: new Department(req.body).save()
     */
    public function store(Request $request)
    {
        // Validation — like Joi/express-validator in MERN
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Department::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department created successfully!');
    }

    /**
     * Show edit form
     * MERN: Department.findById(req.params.id)
     */
    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    /**
     * Update department
     * MERN: Department.findByIdAndUpdate(id, req.body)
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $department->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department updated successfully!');
    }

    /**
     * Delete department
     * MERN: Department.findByIdAndDelete(id)
     */
    public function destroy(Department $department)
    {
        // Check if department has employees
        if ($department->employees()->count() > 0) {
            return redirect()->route('admin.departments.index')
                ->with('error', 'Cannot delete department with assigned employees!');
        }

        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department deleted successfully!');
    }
}
