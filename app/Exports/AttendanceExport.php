<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function array(): array
    {
        $employees = Employee::with('department')
            ->where('employment_status', 'active')
            ->orderBy('first_name')
            ->get();

        $startDate = Carbon::create($this->year, $this->month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $workingDays = 0;
        $tempDate = $startDate->copy();
        while ($tempDate->lte($endDate)) {
            if (!$tempDate->isWeekend()) $workingDays++;
            $tempDate->addDay();
        }

        $attendanceCounts = Attendance::selectRaw('employee_id, COUNT(*) as total')
            ->whereMonth('date', $this->month)
            ->whereYear('date', $this->year)
            ->groupBy('employee_id')
            ->pluck('total', 'employee_id');

        $leaveTotals = LeaveRequest::selectRaw('employee_id, SUM(total_days) as total')
            ->where('status', 'approved')
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate]);
            })
            ->groupBy('employee_id')
            ->pluck('total', 'employee_id');

        $rows = [];
        $index = 0;
        foreach ($employees as $employee) {
            $index++;
            $present = $attendanceCounts[$employee->id] ?? 0;
            $leaves = $leaveTotals[$employee->id] ?? 0;
            $absent = max(0, $workingDays - $present - $leaves);
            $pct = $workingDays > 0 ? round(($present / $workingDays) * 100, 1) : 0;

            $rows[] = [
                $index,
                $employee->full_name,
                $employee->department->name ?? 'N/A',
                $workingDays,
                $present,
                $absent,
                $leaves,
                $pct . '%',
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        $monthName = Carbon::create($this->year, $this->month, 1)->format('F Y');
        return [
            '#', 'Employee', 'Department', 'Working Days',
            'Present', 'Absent', 'Leaves', 'Attendance %'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
