<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h2 { text-align: center; color: #333; margin-bottom: 5px; }
        .subtitle { text-align: center; color: #666; margin-bottom: 15px; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #4f46e5; color: white; padding: 8px 5px; text-align: center; font-size: 10px; }
        td { padding: 6px 5px; border-bottom: 1px solid #eee; font-size: 10px; text-align: center; }
        td:nth-child(1), td:nth-child(2) { text-align: left; }
        tr:nth-child(even) { background: #f9fafb; }
        .good { color: #166534; font-weight: bold; }
        .bad { color: #991b1b; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Attendance Report — {{ $monthName }}</h2>
    <p class="subtitle">Working Days: {{ $workingDays }} | Generated on {{ date('d M Y, h:i A') }}</p>

    <table>
        <thead>
            <tr>
                <th style="text-align:left">#</th>
                <th style="text-align:left">Employee</th>
                <th>Present</th>
                <th>Absent</th>
                <th>Leaves</th>
                <th>Attendance %</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendanceData as $index => $item)
                <tr>
                    <td style="text-align:left">{{ $index + 1 }}</td>
                    <td style="text-align:left">{{ $item['employee']->full_name }}</td>
                    <td>{{ $item['present'] }}</td>
                    <td>{{ $item['absent'] }}</td>
                    <td>{{ $item['leaves'] }}</td>
                    <td class="{{ $item['percentage'] >= 80 ? 'good' : 'bad' }}">{{ $item['percentage'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
