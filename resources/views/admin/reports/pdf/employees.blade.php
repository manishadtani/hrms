<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Employee Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h2 { text-align: center; color: #333; margin-bottom: 5px; }
        .subtitle { text-align: center; color: #666; margin-bottom: 15px; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #4f46e5; color: white; padding: 8px 5px; text-align: left; font-size: 10px; }
        td { padding: 6px 5px; border-bottom: 1px solid #eee; font-size: 10px; }
        tr:nth-child(even) { background: #f9fafb; }
        .badge { padding: 2px 6px; border-radius: 3px; font-size: 9px; }
        .active { background: #dcfce7; color: #166534; }
        .inactive { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <h2>Employee Directory Report</h2>
    <p class="subtitle">Generated on {{ date('d M Y, h:i A') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Code</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Joining Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $index => $emp)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $emp->employee_code }}</td>
                    <td>{{ $emp->full_name }}</td>
                    <td>{{ $emp->user->email ?? 'N/A' }}</td>
                    <td>{{ $emp->department->name ?? 'N/A' }}</td>
                    <td>{{ $emp->designation->name ?? 'N/A' }}</td>
                    <td>{{ $emp->joining_date ? $emp->joining_date->format('d M Y') : 'N/A' }}</td>
                    <td><span class="badge {{ $emp->employment_status === 'active' ? 'active' : 'inactive' }}">{{ ucfirst($emp->employment_status) }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p style="text-align:right;color:#999;font-size:9px;margin-top:10px;">Total: {{ $employees->count() }} employees</p>
</body>
</html>
