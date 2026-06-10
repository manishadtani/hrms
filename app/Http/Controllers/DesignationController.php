<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index(Request $request)
    {
        $query = Designation::withCount('employees');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $designations = $query->latest()->paginate(10);

        return view('admin.designations.index', compact('designations'));
    }

    public function create()
    {
        return view('admin.designations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:designations,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Designation::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation created successfully!');
    }

    public function edit(Designation $designation)
    {
        return view('admin.designations.edit', compact('designation'));
    }

    public function update(Request $request, Designation $designation)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:designations,name,' . $designation->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $designation->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation updated successfully!');
    }

    public function destroy(Designation $designation)
    {
        if ($designation->employees()->count() > 0) {
            return redirect()->route('admin.designations.index')
                ->with('error', 'Cannot delete designation with assigned employees!');
        }

        $designation->delete();

        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation deleted successfully!');
    }
}
