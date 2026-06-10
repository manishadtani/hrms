<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display all roles with their permissions
     */
    public function index()
    {
        $roles = Role::withCount('permissions', 'users')->get();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show form to create a new role
     */
    public function create()
    {
        // Group permissions by module for better UI
        $permissions = Permission::all();
        $groupedPermissions = $this->groupPermissions($permissions);

        return view('admin.roles.create', compact('groupedPermissions'));
    }

    /**
     * Store a new role
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => strtolower($request->name)]);

        if ($request->has('permissions')) {
            $role->syncPermissions(Permission::whereIn('id', $request->permissions)->get());
        }

        activity()
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->withProperties(['role' => $role->name])
            ->log('Created role: ' . $role->name);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role "' . $role->name . '" created successfully!');
    }

    /**
     * Show form to edit a role
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $groupedPermissions = $this->groupPermissions($permissions);
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', compact('role', 'groupedPermissions', 'rolePermissions'));
    }

    /**
     * Update role and its permissions
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => strtolower($request->name)]);

        if ($request->has('permissions')) {
            $role->syncPermissions(Permission::whereIn('id', $request->permissions)->get());
        } else {
            $role->syncPermissions([]);
        }

        activity()
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->withProperties(['role' => $role->name])
            ->log('Updated role: ' . $role->name);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role "' . $role->name . '" updated successfully!');
    }

    /**
     * Delete a role (prevent deleting core roles)
     */
    public function destroy(Role $role)
    {
        $coreRoles = ['admin', 'manager', 'employee'];

        if (in_array($role->name, $coreRoles)) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete core role "' . $role->name . '"!');
        }

        if ($role->users->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete role "' . $role->name . '" — it has ' . $role->users->count() . ' users assigned!');
        }

        activity()
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->withProperties(['role' => $role->name])
            ->log('Deleted role: ' . $role->name);

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role "' . $role->name . '" deleted successfully!');
    }

    /**
     * Group permissions by module prefix
     */
    private function groupPermissions($permissions)
    {
        $groups = [
            'User Management' => [],
            'Employee Management' => [],
            'Role & Permission' => [],
            'Attendance' => [],
            'Leave Management' => [],
            'Holiday Management' => [],
            'Announcement' => [],
            'Reports' => [],
            'Dashboard' => [],
            'Other' => [],
        ];

        $mapping = [
            'user' => 'User Management',
            'assign-roles' => 'User Management',
            'reset-user' => 'User Management',
            'activate' => 'User Management',
            'employee' => 'Employee Management',
            'search-filter' => 'Employee Management',
            'assign-manager' => 'Employee Management',
            'manage-roles' => 'Role & Permission',
            'manage-permissions' => 'Role & Permission',
            'attendance' => 'Attendance',
            'manual-attendance' => 'Attendance',
            'leave' => 'Leave Management',
            'apply-leave' => 'Leave Management',
            'configure-leave' => 'Leave Management',
            'override-leave' => 'Leave Management',
            'holiday' => 'Holiday Management',
            'announcement' => 'Announcement',
            'report' => 'Reports',
            'dashboard' => 'Dashboard',
        ];

        foreach ($permissions as $perm) {
            $placed = false;
            foreach ($mapping as $keyword => $group) {
                if (str_contains($perm->name, $keyword)) {
                    $groups[$group][] = $perm;
                    $placed = true;
                    break;
                }
            }
            if (!$placed) {
                $groups['Other'][] = $perm;
            }
        }

        // Remove empty groups
        return array_filter($groups, fn($items) => count($items) > 0);
    }
}
