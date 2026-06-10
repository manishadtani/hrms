<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;

class LoadTestSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating 50 test users for load testing...');

        for ($i = 1; $i <= 50; $i++) {
            // Skip if user already exists
            if (User::where('email', "testuser{$i}@ems.com")->exists()) {
                continue;
            }

            $user = User::create([
                'name' => "Test User {$i}",
                'email' => "testuser{$i}@ems.com",
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]);

            $user->assignRole('employee');

            Employee::create([
                'user_id' => $user->id,
                'employee_code' => 'EMP' . str_pad($i + 100, 4, '0', STR_PAD_LEFT),
                'first_name' => 'Test',
                'last_name' => "User {$i}",
                'employment_status' => 'active',
                'department_id' => rand(1, 3) <= 3 ? rand(1, 3) : null,
            ]);
        }

        $this->command->info('✅ 50 test users created! (testuser1@ems.com to testuser50@ems.com)');
        $this->command->info('Password: password123');
    }
}
