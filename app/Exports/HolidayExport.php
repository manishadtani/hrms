<?php

namespace App\Exports;

use App\Models\Holiday;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HolidayExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $year;

    public function __construct($year)
    {
        $this->year = $year;
    }

    public function collection()
    {
        return Holiday::whereYear('date', $this->year)->orderBy('date')->get();
    }

    public function headings(): array
    {
        return ['#', 'Holiday Name', 'Date', 'Day', 'Type', 'Description'];
    }

    public function map($holiday): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $holiday->name,
            $holiday->date->format('d M Y'),
            $holiday->date->format('l'),
            ucfirst($holiday->type),
            $holiday->description ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
