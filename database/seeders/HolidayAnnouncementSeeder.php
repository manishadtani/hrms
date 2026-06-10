<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Holiday;
use App\Models\Announcement;
use Carbon\Carbon;

class HolidayAnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        // Indian Holidays 2026
        $holidays = [
            ['name' => 'Republic Day', 'date' => '2026-01-26', 'type' => 'national', 'description' => 'Republic Day of India'],
            ['name' => 'Holi', 'date' => '2026-03-17', 'type' => 'national', 'description' => 'Festival of Colors'],
            ['name' => 'Good Friday', 'date' => '2026-04-03', 'type' => 'national', 'description' => 'Good Friday'],
            ['name' => 'Independence Day', 'date' => '2026-08-15', 'type' => 'national', 'description' => 'Independence Day of India'],
            ['name' => 'Gandhi Jayanti', 'date' => '2026-10-02', 'type' => 'national', 'description' => 'Birthday of Mahatma Gandhi'],
            ['name' => 'Diwali', 'date' => '2026-10-20', 'type' => 'national', 'description' => 'Festival of Lights'],
            ['name' => 'Christmas', 'date' => '2026-12-25', 'type' => 'national', 'description' => 'Christmas Day'],
            ['name' => 'Company Foundation Day', 'date' => '2026-06-15', 'type' => 'company', 'description' => 'Company anniversary celebration'],
            ['name' => 'Team Building Day', 'date' => '2026-09-10', 'type' => 'company', 'description' => 'Annual team building event'],
            ['name' => 'Chhath Puja', 'date' => '2026-11-08', 'type' => 'regional', 'description' => 'Regional festival'],
        ];

        foreach ($holidays as $holiday) {
            Holiday::create(array_merge($holiday, ['is_active' => true]));
        }

        // Sample Announcements
        Announcement::create([
            'title' => 'Welcome to EMS!',
            'content' => 'We are excited to launch our new Employee Management System. This platform will help us manage attendance, leaves, holidays, and much more. Please explore all the features and let us know your feedback.',
            'created_by' => 1,
            'status' => 'published',
            'published_at' => now()->subDays(5),
            'is_pinned' => true,
        ]);

        Announcement::create([
            'title' => 'Office Timing Update',
            'content' => 'Starting from next month, office timings will be 9:30 AM to 6:30 PM. Please adjust your schedules accordingly. The lunch break will remain 1:00 PM to 2:00 PM.',
            'created_by' => 1,
            'status' => 'published',
            'published_at' => now()->subDays(2),
            'is_pinned' => false,
        ]);

        Announcement::create([
            'title' => 'Annual Day Celebration',
            'content' => 'We are planning our annual day celebration on June 15th. All employees are requested to participate. More details will be shared soon.',
            'created_by' => 1,
            'status' => 'draft',
            'is_pinned' => false,
        ]);
    }
}
