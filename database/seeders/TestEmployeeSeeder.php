<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use Spatie\Permission\Models\Role;

class TestEmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'yasheue55@gmail.com'],
            ['name' => 'Yasheu Employee', 'password' => bcrypt('password123')]
        );

        $role = Role::where('name', 'employee')->first();
        $user->assignRole($role);

        $dept = Department::first();
        $desig = Designation::first();

        $employee = Employee::firstOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => 'Yasheu',
                'last_name' => 'Employee',
                'employee_code' => 'EMP-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                'phone' => '9876543210',
                'department_id' => $dept->id,
                'designation_id' => $desig->id,
                'joining_date' => now()->toDateString(),
                'gender' => 'male',
                'date_of_birth' => '1998-01-15',
            ]
        );

        echo "Created! Email: yasheue55@gmail.com | Password: password123\n";
    }
}
