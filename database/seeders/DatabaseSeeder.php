<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First create roles & permissions, then create users
        $this->call([
            RolePermissionSeeder::class,
            AdminUserSeeder::class,
            DepartmentDesignationSeeder::class,
            AttendanceSeeder::class,
            LeaveSeeder::class,
            HolidayAnnouncementSeeder::class,
        ]);
    }
}
