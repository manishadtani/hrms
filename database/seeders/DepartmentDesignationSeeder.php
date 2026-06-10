<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Designation;

class DepartmentDesignationSeeder extends Seeder
{
    public function run(): void
    {
        // Departments
        $departments = [
            ['name' => 'Information Technology', 'description' => 'IT & Software Development'],
            ['name' => 'Human Resources', 'description' => 'HR & People Management'],
            ['name' => 'Finance', 'description' => 'Accounting & Finance'],
            ['name' => 'Marketing', 'description' => 'Marketing & Communications'],
            ['name' => 'Operations', 'description' => 'Operations & Administration'],
            ['name' => 'Sales', 'description' => 'Sales & Business Development'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        // Designations
        $designations = [
            ['name' => 'Software Engineer', 'description' => 'Software Development'],
            ['name' => 'Senior Software Engineer', 'description' => 'Senior Development Role'],
            ['name' => 'Team Lead', 'description' => 'Team Leadership'],
            ['name' => 'Project Manager', 'description' => 'Project Management'],
            ['name' => 'HR Manager', 'description' => 'HR Management'],
            ['name' => 'HR Executive', 'description' => 'HR Operations'],
            ['name' => 'Accountant', 'description' => 'Accounting'],
            ['name' => 'Marketing Executive', 'description' => 'Marketing Operations'],
            ['name' => 'Sales Executive', 'description' => 'Sales Operations'],
            ['name' => 'Business Analyst', 'description' => 'Business Analysis'],
        ];

        foreach ($designations as $desig) {
            Designation::create($desig);
        }
    }
}
