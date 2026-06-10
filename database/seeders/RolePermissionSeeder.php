<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Seed the roles and permissions for EMS.
     * 
     * 3 Roles: Admin, Manager, Employee
     * Permissions grouped by module as per SOW
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ========================================
        // Define All Permissions (Module-wise)
        // ========================================

        $permissions = [
            // User Management
            'create-user',
            'edit-user',
            'delete-user',
            'view-user',
            'activate-deactivate-user',
            'assign-roles',
            'reset-user-password',

            // Employee Management
            'create-employee',
            'edit-employee',
            'delete-employee',
            'view-employee',
            'search-filter-employee',
            'assign-manager',

            // Role & Permission Management
            'manage-roles',
            'manage-permissions',

            // Attendance Management
            'view-own-attendance',
            'view-team-attendance',
            'view-all-attendance',
            'manual-attendance-entry',
            'attendance-corrections',
            'attendance-reports',

            // Leave Management
            'apply-leave',
            'view-own-leave',
            'approve-reject-leave',
            'cancel-leave',
            'configure-leave-types',
            'configure-leave-rules',
            'view-all-leave',
            'override-leave',

            // Holiday Management
            'create-holiday',
            'edit-holiday',
            'delete-holiday',
            'view-holidays',

            // Announcement Management
            'create-announcement',
            'edit-announcement',
            'delete-announcement',
            'view-announcements',

            // Reports
            'employee-reports',
            'attendance-reports-full',
            'leave-reports',
            'holiday-reports',

            // Dashboard
            'view-admin-dashboard',
            'view-manager-dashboard',
            'view-employee-dashboard',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // ========================================
        // Create Roles & Assign Permissions
        // ========================================

        // 1. ADMIN — Full access to everything
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // 2. MANAGER — Team management + own access
        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view-employee',
            'search-filter-employee',
            'view-own-attendance',
            'view-team-attendance',
            'attendance-reports',
            'apply-leave',
            'view-own-leave',
            'approve-reject-leave',
            'view-holidays',
            'view-announcements',
            'view-manager-dashboard',
            'view-employee-dashboard',
        ]);

        // 3. EMPLOYEE — Self-service only
        $employeeRole = Role::create(['name' => 'employee']);
        $employeeRole->givePermissionTo([
            'view-own-attendance',
            'apply-leave',
            'view-own-leave',
            'cancel-leave',
            'view-holidays',
            'view-announcements',
            'view-employee-dashboard',
        ]);
    }
}
