<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $departmentId;
    protected $status;

    public function __construct($departmentId = null, $status = null)
    {
        $this->departmentId = $departmentId;
        $this->status = $status;
    }

    public function collection()
    {
        $query = Employee::with(['user', 'department', 'designation', 'manager']);

        if ($this->departmentId) {
            $query->where('department_id', $this->departmentId);
        }
        if ($this->status) {
            $query->where('employment_status', $this->status);
        }

        return $query->orderBy('first_name')->get();
    }

    public function headings(): array
    {
        return [
            '#', 'Employee Code', 'Full Name', 'Email', 'Phone',
            'Department', 'Designation', 'Manager', 'Joining Date',
            'Status', 'Gender'
        ];
    }

    public function map($employee): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $employee->employee_code,
            $employee->full_name,
            $employee->user->email ?? 'N/A',
            $employee->phone ?? 'N/A',
            $employee->department->name ?? 'N/A',
            $employee->designation->name ?? 'N/A',
            $employee->manager ? $employee->manager->name : 'N/A',
            $employee->joining_date ? $employee->joining_date->format('d M Y') : 'N/A',
            ucfirst($employee->employment_status),
            ucfirst($employee->gender ?? 'N/A'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
