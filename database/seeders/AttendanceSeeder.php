<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        // First, create some employee records for our existing test users
        $adminUser = User::where('email', 'admin@ems.com')->first();
        $managerUser = User::where('email', 'manager@ems.com')->first();
        $employeeUser = User::where('email', 'employee@ems.com')->first();

        // Create employee profiles for manager and employee users
        $managerEmp = Employee::firstOrCreate(
            ['user_id' => $managerUser->id],
            [
                'employee_code' => 'EMP001',
                'first_name' => 'Manager',
                'last_name' => 'User',
                'department_id' => 1, // IT
                'designation_id' => 4, // Project Manager
                'joining_date' => '2024-01-15',
                'employment_status' => 'active',
            ]
        );

        $employeeEmp = Employee::firstOrCreate(
            ['user_id' => $employeeUser->id],
            [
                'employee_code' => 'EMP002',
                'first_name' => 'Employee',
                'last_name' => 'User',
                'department_id' => 1, // IT
                'designation_id' => 1, // Software Engineer
                'manager_id' => $managerUser->id, // Reports to manager
                'joining_date' => '2024-03-01',
                'employment_status' => 'active',
            ]
        );

        // Create 2 more test employees
        $user3 = User::create([
            'name' => 'Rahul Sharma',
            'email' => 'rahul@ems.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $user3->assignRole('employee');

        $emp3 = Employee::create([
            'user_id' => $user3->id,
            'employee_code' => 'EMP003',
            'first_name' => 'Rahul',
            'last_name' => 'Sharma',
            'gender' => 'male',
            'department_id' => 1,
            'designation_id' => 2,
            'manager_id' => $managerUser->id,
            'joining_date' => '2024-06-01',
            'employment_status' => 'active',
        ]);

        $user4 = User::create([
            'name' => 'Priya Singh',
            'email' => 'priya@ems.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $user4->assignRole('employee');

        $emp4 = Employee::create([
            'user_id' => $user4->id,
            'employee_code' => 'EMP004',
            'first_name' => 'Priya',
            'last_name' => 'Singh',
            'gender' => 'female',
            'department_id' => 2, // HR
            'designation_id' => 6, // HR Executive
            'manager_id' => $managerUser->id,
            'joining_date' => '2024-08-15',
            'employment_status' => 'active',
        ]);

        // Seed attendance for the last 7 days
        $employees = [$managerEmp, $employeeEmp, $emp3, $emp4];
        $statuses = ['present', 'present', 'present', 'present', 'present', 'half_day', 'absent'];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            // Skip weekends
            if ($date->isWeekend()) continue;

            foreach ($employees as $index => $emp) {
                $status = $statuses[array_rand($statuses)];
                $clockIn = null;
                $clockOut = null;
                $hours = 0;

                if ($status === 'present') {
                    $clockIn = sprintf('%02d:%02d:00', rand(8, 9), rand(0, 59));
                    $clockOut = sprintf('%02d:%02d:00', rand(17, 19), rand(0, 59));
                    $hours = round((strtotime($clockOut) - strtotime($clockIn)) / 3600, 2);
                } elseif ($status === 'half_day') {
                    $clockIn = sprintf('%02d:%02d:00', rand(9, 10), rand(0, 59));
                    $clockOut = sprintf('%02d:%02d:00', rand(13, 14), rand(0, 59));
                    $hours = round((strtotime($clockOut) - strtotime($clockIn)) / 3600, 2);
                }

                Attendance::create([
                    'employee_id' => $emp->id,
                    'date' => $date->toDateString(),
                    'clock_in' => $clockIn,
                    'clock_out' => $clockOut,
                    'working_hours' => $hours,
                    'status' => $status,
                ]);
            }
        }
    }
}
