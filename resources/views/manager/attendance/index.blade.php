@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    .attendance-page {
        font-family: 'Inter', sans-serif;
        background: #f1f5f9;
        min-height: 100vh;
        padding: 2rem 1.5rem;
    }

    /* Flash Messages */
    .flash-message {
        padding: 1rem 1.25rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: fadeUp 0.5s ease forwards;
        opacity: 0;
        transform: translateY(16px);
    }

    .flash-success {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .flash-error {
        background: linear-gradient(135deg, #fef2f2, #fecaca);
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    /* Page Header */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
        animation: fadeUp 0.5s ease forwards;
        opacity: 0;
        transform: translateY(16px);
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-header-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, #6366f1, #818cf8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.5rem;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.3);
    }

    .page-header-text h1 {
        font-size: 1.65rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.025em;
    }

    .page-header-text p {
        font-size: 0.85rem;
        color: #64748b;
        margin: 0.15rem 0 0 0;
        font-weight: 400;
    }

    .date-filter-form {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .date-filter-form label {
        font-size: 0.82rem;
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
    }

    .date-input {
        padding: 0.6rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-family: 'Inter', sans-serif;
        font-size: 0.88rem;
        font-weight: 500;
        color: #1e293b;
        background: #fff;
        transition: all 0.3s ease;
        outline: none;
        min-width: 170px;
    }

    .date-input:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    /* Summary Cards */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 0, 0, 0.03);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        opacity: 0;
        transform: translateY(16px);
        animation: fadeUp 0.5s ease forwards;
    }

    .stat-card:nth-child(1) { animation-delay: 0.08s; }
    .stat-card:nth-child(2) { animation-delay: 0.16s; }
    .stat-card:nth-child(3) { animation-delay: 0.24s; }
    .stat-card:nth-child(4) { animation-delay: 0.32s; }
    .stat-card:nth-child(5) { animation-delay: 0.40s; }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .stat-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .stat-card-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .stat-card-label {
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
    }

    .stat-card-value {
        font-size: 2rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    .stat-card-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 0 0 16px 16px;
    }

    /* Card color variants */
    .stat-card--indigo .stat-card-icon {
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: #6366f1;
    }
    .stat-card--indigo .stat-card-bar { background: linear-gradient(90deg, #6366f1, #818cf8); }

    .stat-card--emerald .stat-card-icon {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        color: #10b981;
    }
    .stat-card--emerald .stat-card-bar { background: linear-gradient(90deg, #10b981, #34d399); }

    .stat-card--rose .stat-card-icon {
        background: linear-gradient(135deg, #fff1f2, #fecdd3);
        color: #f43f5e;
    }
    .stat-card--rose .stat-card-bar { background: linear-gradient(90deg, #f43f5e, #fb7185); }

    .stat-card--amber .stat-card-icon {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        color: #f59e0b;
    }
    .stat-card--amber .stat-card-bar { background: linear-gradient(90deg, #f59e0b, #fbbf24); }

    .stat-card--sky .stat-card-icon {
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        color: #0ea5e9;
    }
    .stat-card--sky .stat-card-bar { background: linear-gradient(90deg, #0ea5e9, #38bdf8); }

    /* Table Card */
    .table-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 0, 0, 0.03);
        overflow: hidden;
        opacity: 0;
        transform: translateY(16px);
        animation: fadeUp 0.5s ease forwards;
        animation-delay: 0.5s;
    }

    .table-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .table-card-title i {
        color: #6366f1;
    }

    .table-card-badge {
        font-size: 0.75rem;
        font-weight: 600;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: #6366f1;
        padding: 0.3rem 0.85rem;
        border-radius: 20px;
    }

    .attendance-table-wrap {
        overflow-x: auto;
    }

    .attendance-table {
        width: 100%;
        border-collapse: collapse;
    }

    .attendance-table thead th {
        padding: 0.85rem 1.25rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #64748b;
        background: #f8fafc;
        text-align: left;
        border-bottom: 2px solid #f1f5f9;
        white-space: nowrap;
    }

    .attendance-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .attendance-table tbody tr:last-child {
        border-bottom: none;
    }

    .attendance-table tbody tr:hover {
        background: #f8fafc;
    }

    .attendance-table tbody td {
        padding: 1rem 1.25rem;
        font-size: 0.88rem;
        color: #334155;
        vertical-align: middle;
        white-space: nowrap;
    }

    .employee-cell {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
    }

    .employee-name {
        font-weight: 600;
        color: #0f172a;
        font-size: 0.9rem;
    }

    .employee-dept {
        font-size: 0.76rem;
        color: #94a3b8;
        font-weight: 400;
    }

    .time-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-weight: 500;
        font-size: 0.85rem;
        padding: 0.3rem 0.65rem;
        border-radius: 8px;
    }

    .time-badge--in {
        background: #ecfdf5;
        color: #059669;
    }

    .time-badge--out {
        background: #fef2f2;
        color: #dc2626;
    }

    .time-badge--dash {
        background: #f1f5f9;
        color: #94a3b8;
    }

    .working-hours {
        font-weight: 600;
        color: #334155;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.9rem;
        border-radius: 20px;
        font-size: 0.76rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-badge--present {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        color: #065f46;
    }

    .status-badge--absent {
        background: linear-gradient(135deg, #fef2f2, #fecdd3);
        color: #9f1239;
    }

    .status-badge--half_day {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        color: #92400e;
    }

    .status-badge--leave {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        color: #1e40af;
    }

    .status-badge--late {
        background: linear-gradient(135deg, #fff7ed, #fed7aa);
        color: #c2410c;
    }

    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
    }

    .status-dot--present { background: #10b981; }
    .status-dot--absent { background: #f43f5e; }
    .status-dot--half_day { background: #f59e0b; }
    .status-dot--leave { background: #3b82f6; }
    .status-dot--late { background: #f97316; }

    .row-number {
        font-weight: 600;
        color: #94a3b8;
        font-size: 0.82rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        opacity: 0;
        transform: translateY(16px);
        animation: fadeUp 0.5s ease forwards;
        animation-delay: 0.5s;
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        border-radius: 24px;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        font-size: 2rem;
        color: #6366f1;
    }

    .empty-state h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 0.5rem;
    }

    .empty-state p {
        font-size: 0.88rem;
        color: #64748b;
        margin: 0;
    }

    /* Animation */
    @keyframes fadeUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .summary-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .attendance-page {
            padding: 1.25rem 1rem;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .stat-card-value {
            font-size: 1.6rem;
        }

        .page-header-text h1 {
            font-size: 1.35rem;
        }
    }

    @media (max-width: 480px) {
        .summary-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="attendance-page">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flash-message flash-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flash-message flash-error">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-header-icon">
                <i class="bi bi-calendar2-check"></i>
            </div>
            <div class="page-header-text">
                <h1>Team Attendance</h1>
                <p>Monitor your team's daily attendance and hours</p>
            </div>
        </div>
        <form method="GET" action="{{ route('manager.attendance.index') }}" class="date-filter-form">
            <label for="attendance-date"><i class="bi bi-funnel"></i> Filter Date</label>
            <input type="date" id="attendance-date" name="date" class="date-input" value="{{ $date }}" onchange="this.form.submit()">
        </form>
    </div>

    {{-- Summary Stats --}}
    <div class="summary-grid">
        {{-- Total Team --}}
        <div class="stat-card stat-card--indigo">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <span class="stat-card-label">Total Team</span>
            </div>
            <div class="stat-card-value">{{ $summary['total_team'] }}</div>
            <div class="stat-card-bar"></div>
        </div>

        {{-- Present --}}
        <div class="stat-card stat-card--emerald">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <span class="stat-card-label">Present</span>
            </div>
            <div class="stat-card-value">{{ $summary['present'] }}</div>
            <div class="stat-card-bar"></div>
        </div>

        {{-- Absent --}}
        <div class="stat-card stat-card--rose">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
                <span class="stat-card-label">Absent</span>
            </div>
            <div class="stat-card-value">{{ $summary['absent'] }}</div>
            <div class="stat-card-bar"></div>
        </div>

        {{-- Half Day --}}
        <div class="stat-card stat-card--amber">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <span class="stat-card-label">Half Day</span>
            </div>
            <div class="stat-card-value">{{ $summary['half_day'] }}</div>
            <div class="stat-card-bar"></div>
        </div>

        {{-- On Leave --}}
        <div class="stat-card stat-card--sky">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class="bi bi-calendar-x-fill"></i>
                </div>
                <span class="stat-card-label">On Leave</span>
            </div>
            <div class="stat-card-value">{{ $summary['on_leave'] }}</div>
            <div class="stat-card-bar"></div>
        </div>
    </div>

    {{-- Attendance Table --}}
    @if($attendances->count() > 0)
        <div class="table-card">
            <div class="table-card-header">
                <div class="table-card-title">
                    <i class="bi bi-table"></i>
                    Attendance Records
                </div>
                <span class="table-card-badge">{{ $attendances->count() }} {{ Str::plural('record', $attendances->count()) }}</span>
            </div>
            <div class="attendance-table-wrap">
                <table class="attendance-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Clock In</th>
                            <th>Clock Out</th>
                            <th>Working Hours</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $index => $attendance)
                            <tr>
                                <td><span class="row-number">{{ $index + 1 }}</span></td>
                                <td>
                                    <div class="employee-cell">
                                        <span class="employee-name">{{ $attendance->employee->full_name }}</span>
                                        <span class="employee-dept">{{ $attendance->employee->department->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($attendance->formatted_clock_in !== '-')
                                        <span class="time-badge time-badge--in">
                                            <i class="bi bi-box-arrow-in-right"></i>
                                            {{ $attendance->formatted_clock_in }}
                                        </span>
                                    @else
                                        <span class="time-badge time-badge--dash">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->formatted_clock_out !== '-')
                                        <span class="time-badge time-badge--out">
                                            <i class="bi bi-box-arrow-right"></i>
                                            {{ $attendance->formatted_clock_out }}
                                        </span>
                                    @else
                                        <span class="time-badge time-badge--dash">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="working-hours">{{ $attendance->working_hours ? $attendance->working_hours . ' hrs' : '—' }}</span>
                                </td>
                                <td>
                                    <span class="status-badge status-badge--{{ $attendance->status }}">
                                        <span class="status-dot status-dot--{{ $attendance->status }}"></span>
                                        {{ str_replace('_', ' ', $attendance->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        {{-- Empty State --}}
        <div class="table-card">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-calendar2-x"></i>
                </div>
                <h3>No Attendance Records</h3>
                <p>There are no attendance records for the selected date. Try choosing a different date.</p>
            </div>
        </div>
    @endif

</div>
@endsection
