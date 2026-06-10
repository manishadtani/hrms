<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Leave Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h2 { text-align: center; color: #333; margin-bottom: 5px; }
        .subtitle { text-align: center; color: #666; margin-bottom: 15px; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #4f46e5; color: white; padding: 8px 5px; text-align: center; font-size: 10px; }
        td { padding: 6px 5px; border-bottom: 1px solid #eee; font-size: 10px; text-align: center; }
        td:nth-child(1), td:nth-child(2), td:nth-child(3) { text-align: left; }
        tr:nth-child(even) { background: #f9fafb; }
    </style>
</head>
<body>
    <h2>Leave Utilization Report — {{ $year }}</h2>
    <p class="subtitle">Generated on {{ date('d M Y, h:i A') }}</p>

    <table>
        <thead>
            <tr>
                <th style="text-align:left">#</th>
                <th style="text-align:left">Employee</th>
                <th style="text-align:left">Department</th>
                @foreach ($leaveTypes as $type)
                    <th>{{ $type->name }}<br><small>Used / Total</small></th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $index => $employee)
                @php $empLeaves = $leaveUsage[$employee->id] ?? collect(); @endphp
                <tr>
                    <td style="text-align:left">{{ $index + 1 }}</td>
                    <td style="text-align:left">{{ $employee->full_name }}</td>
                    <td style="text-align:left">{{ $employee->department->name ?? 'N/A' }}</td>
                    @foreach ($leaveTypes as $type)
                        @php $used = $empLeaves->where('leave_type_id', $type->id)->first()->total ?? 0; @endphp
                        <td>{{ $used }} / {{ $type->days_per_year }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
