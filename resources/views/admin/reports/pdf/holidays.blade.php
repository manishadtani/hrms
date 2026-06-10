<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Holiday Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h2 { text-align: center; color: #333; margin-bottom: 5px; }
        .subtitle { text-align: center; color: #666; margin-bottom: 15px; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #4f46e5; color: white; padding: 8px 5px; text-align: left; font-size: 10px; }
        td { padding: 6px 5px; border-bottom: 1px solid #eee; font-size: 10px; }
        tr:nth-child(even) { background: #f9fafb; }
        .badge { padding: 2px 6px; border-radius: 3px; font-size: 9px; }
        .national { background: #dbeafe; color: #1e40af; }
        .regional { background: #fef3c7; color: #92400e; }
        .company { background: #dcfce7; color: #166534; }
        .optional { background: #f3e8ff; color: #6b21a8; }
    </style>
</head>
<body>
    <h2>Holiday Report — {{ $year }}</h2>
    <p class="subtitle">Generated on {{ date('d M Y, h:i A') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Holiday Name</th>
                <th>Date</th>
                <th>Day</th>
                <th>Type</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($holidays as $index => $holiday)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $holiday->name }}</td>
                    <td>{{ $holiday->date->format('d M Y') }}</td>
                    <td>{{ $holiday->date->format('l') }}</td>
                    <td><span class="badge {{ $holiday->type }}">{{ ucfirst($holiday->type) }}</span></td>
                    <td>{{ $holiday->description ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p style="text-align:right;color:#999;font-size:9px;margin-top:10px;">Total: {{ $holidays->count() }} holidays</p>
</body>
</html>
