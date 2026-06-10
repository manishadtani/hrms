<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeaveExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $year;

    public function __construct($year)
    {
        $this->year = $year;
    }

    public function array(): array
    {
        $leaveTypes = LeaveType::all();
        $employees = Employee::with('department')
            ->where('employment_status', 'active')
            ->orderBy('first_name')
            ->get();

        $leaveUsage = LeaveRequest::selectRaw('employee_id, leave_type_id, SUM(total_days) as total')
            ->where('status', 'approved')
            ->whereYear('start_date', $this->year)
            ->groupBy('employee_id', 'leave_type_id')
            ->get()
            ->groupBy('employee_id');

        $rows = [];
        $index = 0;
        foreach ($employees as $employee) {
            $index++;
            $row = [$index, $employee->full_name, $employee->department->name ?? 'N/A'];
            $empLeaves = $leaveUsage[$employee->id] ?? collect();

            foreach ($leaveTypes as $type) {
                $used = $empLeaves->where('leave_type_id', $type->id)->first()->total ?? 0;
                $row[] = $used . ' / ' . $type->days_per_year;
            }
            $rows[] = $row;
        }

        return $rows;
    }

    public function headings(): array
    {
        $leaveTypes = LeaveType::all();
        $headings = ['#', 'Employee', 'Department'];
        foreach ($leaveTypes as $type) {
            $headings[] = $type->name . ' (Used/Total)';
        }
        return $headings;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
