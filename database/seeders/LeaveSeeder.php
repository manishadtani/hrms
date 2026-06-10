<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\Employee;
use Carbon\Carbon;

class LeaveSeeder extends Seeder
{
    public function run(): void
    {
        // Leave Types as per SOW
        $types = [
            ['name' => 'Casual Leave', 'code' => 'CL', 'days_per_year' => 12, 'description' => 'For personal/casual reasons'],
            ['name' => 'Sick Leave', 'code' => 'SL', 'days_per_year' => 6, 'description' => 'For illness/medical reasons'],
            ['name' => 'Earned Leave', 'code' => 'EL', 'days_per_year' => 15, 'description' => 'Earned/privilege leave'],
            ['name' => 'Work From Home', 'code' => 'WFH', 'days_per_year' => 24, 'description' => 'Work from home days'],
        ];

        foreach ($types as $type) {
            LeaveType::create($type);
        }

        // Create leave balances for all employees for current year
        $year = Carbon::now()->year;
        $employees = Employee::all();
        $leaveTypes = LeaveType::all();

        foreach ($employees as $employee) {
            foreach ($leaveTypes as $type) {
                LeaveBalance::create([
                    'employee_id' => $employee->id,
                    'leave_type_id' => $type->id,
                    'year' => $year,
                    'total_days' => $type->days_per_year,
                    'used_days' => 0,
                    'remaining_days' => $type->days_per_year,
                ]);
            }
        }

        // Create some sample leave requests
        $employee2 = Employee::where('employee_code', 'EMP002')->first();
        if ($employee2) {
            // Pending leave
            LeaveRequest::create([
                'employee_id' => $employee2->id,
                'leave_type_id' => 1, // CL
                'start_date' => Carbon::today()->addDays(5)->toDateString(),
                'end_date' => Carbon::today()->addDays(7)->toDateString(),
                'total_days' => 2, // excluding weekend
                'reason' => 'Family function - need to travel to hometown for a wedding ceremony.',
                'status' => 'pending',
            ]);

            // Approved leave
            LeaveRequest::create([
                'employee_id' => $employee2->id,
                'leave_type_id' => 2, // SL
                'start_date' => Carbon::today()->subDays(10)->toDateString(),
                'end_date' => Carbon::today()->subDays(9)->toDateString(),
                'total_days' => 2,
                'reason' => 'Fever and cold - doctor recommended rest for 2 days.',
                'status' => 'approved',
                'approved_by' => 2, // Manager user
                'admin_remarks' => 'Get well soon. Approved.',
                'approved_at' => Carbon::today()->subDays(10),
            ]);
        }

        $employee3 = Employee::where('employee_code', 'EMP003')->first();
        if ($employee3) {
            LeaveRequest::create([
                'employee_id' => $employee3->id,
                'leave_type_id' => 1,
                'start_date' => Carbon::today()->addDays(3)->toDateString(),
                'end_date' => Carbon::today()->addDays(4)->toDateString(),
                'total_days' => 2,
                'reason' => 'Personal work - need to visit bank and passport office.',
                'status' => 'pending',
            ]);
        }
    }
}
