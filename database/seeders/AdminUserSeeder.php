<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Create default Admin user for the system.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@ems.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Assign Admin role
        $admin->assignRole('admin');

        // Create a test Manager
        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@ems.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $manager->assignRole('manager');

        // Create a test Employee
        $employee = User::create([
            'name' => 'Employee User',
            'email' => 'employee@ems.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $employee->assignRole('employee');
    }
}
