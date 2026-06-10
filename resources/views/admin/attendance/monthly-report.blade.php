@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    /* ── Reset & Base ── */
    .att-report-page * { box-sizing: border-box; margin: 0; padding: 0; }
    .att-report-page {
        font-family: 'Inter', sans-serif;
        color: #1e293b;
        min-height: 100vh;
        padding: 32px 0;
    }

    /* ── Animations ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(22px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulseRing {
        0%   { box-shadow: 0 0 0 0 rgba(99,102,241,.25); }
        70%  { box-shadow: 0 0 0 8px rgba(99,102,241,0); }
        100% { box-shadow: 0 0 0 0 rgba(99,102,241,0); }
    }
    .fade-up { animation: fadeUp .5s cubic-bezier(.22,1,.36,1) both; }
    .fade-up-1 { animation-delay: .05s; }
    .fade-up-2 { animation-delay: .10s; }
    .fade-up-3 { animation-delay: .15s; }
    .fade-up-4 { animation-delay: .20s; }
    .fade-up-5 { animation-delay: .25s; }

    /* ── Flash Messages ── */
    .att-flash {
        padding: 14px 20px;
        border-radius: 12px;
        font-size: .875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
        animation: fadeUp .45s cubic-bezier(.22,1,.36,1) both;
        border: 1px solid;
    }
    .att-flash-success {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        color: #065f46;
        border-color: #a7f3d0;
    }
    .att-flash i { font-size: 1.15rem; }

    /* ── Page Header ── */
    .att-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 28px;
    }
    .att-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .att-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.35rem;
        box-shadow: 0 4px 14px rgba(99,102,241,.3);
        animation: pulseRing 2.5s ease infinite;
    }
    .att-header h1 {
        font-size: 1.65rem;
        font-weight: 800;
        background: linear-gradient(135deg, #312e81 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -.025em;
    }
    .att-header h1 span {
        display: block;
        font-size: .8rem;
        font-weight: 500;
        -webkit-text-fill-color: #64748b;
        letter-spacing: .02em;
    }

    /* ── Buttons ── */
    .att-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 20px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: .835rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all .25s cubic-bezier(.22,1,.36,1);
        white-space: nowrap;
    }
    .att-btn-primary {
        background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
        color: #fff;
        box-shadow: 0 4px 14px rgba(99,102,241,.3);
    }
    .att-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(99,102,241,.4);
        color: #fff;
    }
    .att-btn-outline {
        background: #fff;
        color: #6366f1;
        border: 1.5px solid #c7d2fe;
        box-shadow: 0 1px 3px rgba(99,102,241,.08);
    }
    .att-btn-outline:hover {
        background: #eef2ff;
        border-color: #818cf8;
        transform: translateY(-2px);
        color: #6366f1;
        text-decoration: none;
    }

    /* ── Filter Card ── */
    .att-filter-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 22px 28px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-end;
        gap: 16px;
        flex-wrap: wrap;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
    }
    .att-filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .att-filter-group label {
        font-size: .72rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: .05em;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .att-filter-input {
        padding: 10px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: .85rem;
        color: #1e293b;
        background: #f8fafc;
        transition: all .2s ease;
        outline: none;
        min-width: 200px;
    }
    .att-filter-input:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        background: #fff;
    }

    /* ── Summary Cards ── */
    .att-summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .att-summary-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        transition: all .3s cubic-bezier(.22,1,.36,1);
        position: relative;
        overflow: hidden;
    }
    .att-summary-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 14px 14px 0 0;
    }
    .att-summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(0,0,0,.07);
    }
    .att-summary-card-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        margin-bottom: 12px;
    }
    .att-summary-card-value {
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -.03em;
        line-height: 1;
        margin-bottom: 4px;
    }
    .att-summary-card-label {
        font-size: .72rem;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .06em;
    }
    .att-sc-employees::before { background: linear-gradient(90deg, #6366f1, #818cf8); }
    .att-sc-employees .att-summary-card-icon { background: #eef2ff; color: #6366f1; }
    .att-sc-employees .att-summary-card-value { color: #4338ca; }
    .att-sc-present::before { background: linear-gradient(90deg, #10b981, #34d399); }
    .att-sc-present .att-summary-card-icon { background: #ecfdf5; color: #10b981; }
    .att-sc-present .att-summary-card-value { color: #059669; }
    .att-sc-absent::before { background: linear-gradient(90deg, #f43f5e, #fb7185); }
    .att-sc-absent .att-summary-card-icon { background: #fff1f2; color: #f43f5e; }
    .att-sc-absent .att-summary-card-value { color: #e11d48; }
    .att-sc-hours::before { background: linear-gradient(90deg, #0ea5e9, #38bdf8); }
    .att-sc-hours .att-summary-card-icon { background: #f0f9ff; color: #0ea5e9; }
    .att-sc-hours .att-summary-card-value { color: #0284c7; }

    /* ── Table ── */
    .att-table-wrap {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
    }
    .att-table {
        width: 100%;
        border-collapse: collapse;
    }
    .att-table thead th {
        padding: 14px 16px;
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        text-align: left;
        white-space: nowrap;
    }
    .att-table thead th.text-center { text-align: center; }
    .att-table tbody tr {
        transition: background .2s ease;
    }
    .att-table tbody tr:hover {
        background: #f8fafc;
    }
    .att-table tbody td {
        padding: 13px 16px;
        font-size: .84rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .att-table tbody td.text-center { text-align: center; }
    .att-table tbody tr:last-child td {
        border-bottom: none;
    }
    .att-table tfoot td {
        padding: 14px 16px;
        font-size: .84rem;
        font-weight: 700;
        background: #f8fafc;
        border-top: 2px solid #e2e8f0;
    }
    .att-table tfoot td.text-center { text-align: center; }

    /* ── Row Counter ── */
    .att-row-num {
        font-weight: 700;
        color: #94a3b8;
        font-size: .78rem;
        font-variant-numeric: tabular-nums;
    }

    /* ── Employee Cell ── */
    .att-emp-name {
        font-weight: 600;
        color: #1e293b;
        font-size: .87rem;
    }
    .att-emp-dept {
        font-size: .75rem;
        color: #94a3b8;
        font-weight: 500;
        margin-top: 2px;
    }

    /* ── Stat Badges (table) ── */
    .att-count-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: .78rem;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
    }
    .att-count-present  { background: #ecfdf5; color: #059669; }
    .att-count-absent   { background: #fff1f2; color: #e11d48; }
    .att-count-half     { background: #fffbeb; color: #d97706; }
    .att-count-leave    { background: #f0f9ff; color: #0284c7; }
    .att-count-holiday  { background: #f5f3ff; color: #7c3aed; }

    /* ── Attendance Percentage Badge ── */
    .att-pct-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: .76rem;
        font-weight: 700;
        letter-spacing: .02em;
    }
    .att-pct-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: inline-block;
    }
    .att-pct-green  { background: #ecfdf5; color: #059669; }
    .att-pct-green .att-pct-dot { background: #10b981; }
    .att-pct-amber  { background: #fffbeb; color: #d97706; }
    .att-pct-amber .att-pct-dot { background: #f59e0b; }
    .att-pct-red    { background: #fff1f2; color: #e11d48; }
    .att-pct-red .att-pct-dot { background: #f43f5e; }

    /* ── Total Hours ── */
    .att-hours {
        font-weight: 700;
        color: #334155;
        font-variant-numeric: tabular-nums;
    }

    /* ── Empty State ── */
    .att-empty {
        text-align: center;
        padding: 60px 24px;
    }
    .att-empty-icon {
        width: 72px; height: 72px;
        border-radius: 20px;
        background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        color: #818cf8;
        margin-bottom: 18px;
    }
    .att-empty h3 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }
    .att-empty p {
        font-size: .85rem;
        color: #94a3b8;
        max-width: 360px;
        margin: 0 auto;
    }

    /* ── Month Info Tag ── */
    .att-month-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 10px;
        background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
        font-size: .82rem;
        font-weight: 700;
        color: #4338ca;
        margin-bottom: 24px;
        border: 1px solid #c7d2fe;
    }
    .att-month-tag i { font-size: 1rem; }

    /* ── Responsive ── */
    @media (max-width: 1200px) {
        .att-summary-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .att-header { flex-direction: column; align-items: flex-start; }
        .att-summary-grid { grid-template-columns: 1fr; }
        .att-filter-card { flex-direction: column; align-items: stretch; }
        .att-table-wrap { overflow-x: auto; }
        .att-table { min-width: 900px; }
        .att-report-page { padding: 16px 0; }
    }
</style>

<div class="att-report-page">
    <div class="container">

        {{-- ── Flash Messages ── --}}
        @if(session('success'))
            <div class="att-flash att-flash-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- ── Page Header ── --}}
        <div class="att-header fade-up fade-up-1">
            <div class="att-header-left">
                <div class="att-header-icon">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i>
                </div>
                <h1>
                    Monthly Report
                    <span>Attendance summary for {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}</span>
                </h1>
            </div>
            <a href="{{ route('admin.attendance.index') }}" class="att-btn att-btn-outline">
                <i class="bi bi-arrow-left"></i> Back to Attendance
            </a>
        </div>

        {{-- ── Month Filter ── --}}
        <form action="{{ route('admin.attendance.monthly-report') }}" method="GET" id="monthFilterForm" class="att-filter-card fade-up fade-up-2">
            <div class="att-filter-group">
                <label for="month">
                    <i class="bi bi-calendar-month"></i> Select Month
                </label>
                <input type="month" name="month" id="month" class="att-filter-input"
                       value="{{ $month }}"
                       onchange="document.getElementById('monthFilterForm').submit();">
            </div>
            <button type="submit" class="att-btn att-btn-primary">
                <i class="bi bi-funnel-fill"></i> Generate Report
            </button>
        </form>

        {{-- ── Summary Cards ── --}}
        @if(count($report) > 0)
            <div class="att-summary-grid fade-up fade-up-3">
                <div class="att-summary-card att-sc-employees">
                    <div class="att-summary-card-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="att-summary-card-value">{{ count($report) }}</div>
                    <div class="att-summary-card-label">Employees</div>
                </div>
                <div class="att-summary-card att-sc-present">
                    <div class="att-summary-card-icon"><i class="bi bi-check-circle-fill"></i></div>
                    <div class="att-summary-card-value">{{ collect($report)->sum('present') }}</div>
                    <div class="att-summary-card-label">Total Present</div>
                </div>
                <div class="att-summary-card att-sc-absent">
                    <div class="att-summary-card-icon"><i class="bi bi-x-circle-fill"></i></div>
                    <div class="att-summary-card-value">{{ collect($report)->sum('absent') }}</div>
                    <div class="att-summary-card-label">Total Absent</div>
                </div>
                <div class="att-summary-card att-sc-hours">
                    <div class="att-summary-card-icon"><i class="bi bi-clock-fill"></i></div>
                    <div class="att-summary-card-value">{{ number_format(collect($report)->sum('total_hours'), 1) }}</div>
                    <div class="att-summary-card-label">Total Hours</div>
                </div>
            </div>
        @endif

        {{-- ── Report Table ── --}}
        <div class="att-table-wrap fade-up fade-up-4">
            @if(count($report) > 0)
                <table class="att-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Employee Name</th>
                            <th>Department</th>
                            <th class="text-center">Present</th>
                            <th class="text-center">Absent</th>
                            <th class="text-center">Half Day</th>
                            <th class="text-center">Leave</th>
                            <th class="text-center">Holiday</th>
                            <th class="text-center">Total Hours</th>
                            <th class="text-center">Attendance %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report as $index => $item)
                            @php
                                $totalDays = $item['total_days'] > 0 ? $item['total_days'] : $daysInMonth;
                                $attendancePct = $totalDays > 0
                                    ? round((($item['present'] + ($item['half_day'] * 0.5)) / $totalDays) * 100, 1)
                                    : 0;
                                $pctClass = $attendancePct >= 90 ? 'att-pct-green' : ($attendancePct >= 70 ? 'att-pct-amber' : 'att-pct-red');
                            @endphp
                            <tr>
                                <td><span class="att-row-num">{{ $index + 1 }}</span></td>
                                <td>
                                    <div class="att-emp-name">{{ $item['employee']->full_name }}</div>
                                </td>
                                <td>
                                    <div class="att-emp-dept" style="color: #64748b; font-weight: 500;">{{ $item['employee']->department->name ?? 'N/A' }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="att-count-badge att-count-present">{{ $item['present'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="att-count-badge att-count-absent">{{ $item['absent'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="att-count-badge att-count-half">{{ $item['half_day'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="att-count-badge att-count-leave">{{ $item['leave'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="att-count-badge att-count-holiday">{{ $item['holiday'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="att-hours">{{ number_format($item['total_hours'], 1) }}h</span>
                                </td>
                                <td class="text-center">
                                    <span class="att-pct-badge {{ $pctClass }}">
                                        <span class="att-pct-dot"></span>
                                        {{ $attendancePct }}%
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="font-weight: 700;">
                                <i class="bi bi-calculator me-1"></i> Summary Totals
                            </td>
                            <td class="text-center" style="color: #059669; font-weight: 700;">
                                {{ collect($report)->sum('present') }}
                            </td>
                            <td class="text-center" style="color: #e11d48; font-weight: 700;">
                                {{ collect($report)->sum('absent') }}
                            </td>
                            <td class="text-center" style="color: #d97706; font-weight: 700;">
                                {{ collect($report)->sum('half_day') }}
                            </td>
                            <td class="text-center" style="color: #0284c7; font-weight: 700;">
                                {{ collect($report)->sum('leave') }}
                            </td>
                            <td class="text-center" style="color: #7c3aed; font-weight: 700;">
                                {{ collect($report)->sum('holiday') }}
                            </td>
                            <td class="text-center" style="font-weight: 700;">
                                {{ number_format(collect($report)->sum('total_hours'), 1) }}h
                            </td>
                            <td class="text-center">
                                @php
                                    $totalPresent = collect($report)->sum('present');
                                    $totalHalfDay = collect($report)->sum('half_day');
                                    $totalWorkDays = collect($report)->sum('total_days');
                                    $avgPct = $totalWorkDays > 0
                                        ? round((($totalPresent + ($totalHalfDay * 0.5)) / $totalWorkDays) * 100, 1)
                                        : 0;
                                    $avgClass = $avgPct >= 90 ? 'att-pct-green' : ($avgPct >= 70 ? 'att-pct-amber' : 'att-pct-red');
                                @endphp
                                <span class="att-pct-badge {{ $avgClass }}">
                                    <span class="att-pct-dot"></span>
                                    {{ $avgPct }}%
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            @else
                <div class="att-empty">
                    <div class="att-empty-icon">
                        <i class="bi bi-calendar-x"></i>
                    </div>
                    <h3>No Attendance Data Found</h3>
                    <p>There are no attendance records for {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}. Try selecting a different month.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
