@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    .att-rpt-page {
        font-family: 'Inter', sans-serif;
        padding: 2rem 0 4rem;
        min-height: 100vh;
        color: #1e293b;
    }

    /* ── Animations ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(22px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulseRing {
        0%   { box-shadow: 0 0 0 0 rgba(16,185,129,.25); }
        70%  { box-shadow: 0 0 0 8px rgba(16,185,129,0); }
        100% { box-shadow: 0 0 0 0 rgba(16,185,129,0); }
    }
    .fade-up { animation: fadeUp .5s cubic-bezier(.22,1,.36,1) both; }
    .fade-up-1 { animation-delay: .05s; }
    .fade-up-2 { animation-delay: .10s; }
    .fade-up-3 { animation-delay: .15s; }
    .fade-up-4 { animation-delay: .20s; }
    .fade-up-5 { animation-delay: .25s; }

    /* ── Breadcrumb ── */
    .att-rpt-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.82rem;
        color: #94a3b8;
        margin-bottom: 1.5rem;
    }
    .att-rpt-breadcrumb a {
        color: #6366f1;
        text-decoration: none;
        font-weight: 500;
    }
    .att-rpt-breadcrumb a:hover { text-decoration: underline; }

    /* ── Page Header ── */
    .att-rpt-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 1.75rem;
    }
    .att-rpt-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .att-rpt-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.35rem;
        box-shadow: 0 4px 14px rgba(16,185,129,.3);
        animation: pulseRing 2.5s ease infinite;
    }
    .att-rpt-header h1 {
        font-size: 1.65rem;
        font-weight: 800;
        background: linear-gradient(135deg, #064e3b 0%, #10b981 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -.025em;
        margin: 0;
    }
    .att-rpt-header h1 span {
        display: block;
        font-size: .8rem;
        font-weight: 500;
        -webkit-text-fill-color: #64748b;
        letter-spacing: .02em;
        margin-top: 2px;
    }
    .att-rpt-header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* ── Buttons ── */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: .835rem;
        font-weight: 600;
        text-decoration: none;
        background: #fff;
        color: #6366f1;
        border: 1.5px solid #c7d2fe;
        box-shadow: 0 1px 3px rgba(99,102,241,.08);
        transition: all .25s ease;
    }
    .btn-back:hover {
        background: #eef2ff;
        border-color: #818cf8;
        transform: translateY(-2px);
        color: #6366f1;
        text-decoration: none;
    }
    .btn-export {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        border-radius: 20px;
        font-family: 'Inter', sans-serif;
        font-size: .8rem;
        font-weight: 600;
        text-decoration: none;
        color: #fff;
        border: none;
        transition: all .25s ease;
        white-space: nowrap;
    }
    .btn-export:hover {
        transform: translateY(-2px);
        color: #fff;
        text-decoration: none;
    }
    .btn-export-excel {
        background: linear-gradient(135deg, #10b981, #34d399);
        box-shadow: 0 4px 12px rgba(16,185,129,.3);
    }
    .btn-export-excel:hover { box-shadow: 0 6px 18px rgba(16,185,129,.45); }
    .btn-export-pdf {
        background: linear-gradient(135deg, #ef4444, #f87171);
        box-shadow: 0 4px 12px rgba(239,68,68,.3);
    }
    .btn-export-pdf:hover { box-shadow: 0 6px 18px rgba(239,68,68,.45); }

    /* ── Filter Bar ── */
    .att-rpt-filter-bar {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-end;
        gap: 14px;
        flex-wrap: wrap;
    }
    .att-rpt-filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 160px;
    }
    .att-rpt-filter-group label {
        font-size: .75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    .att-rpt-filter-select,
    .att-rpt-filter-input {
        padding: 10px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: .85rem;
        color: #1e293b;
        background: #f8fafc;
        transition: all .2s ease;
        outline: none;
        width: 100%;
    }
    .att-rpt-filter-select:focus,
    .att-rpt-filter-input:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        background: #fff;
    }
    .att-rpt-filter-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        padding-bottom: 1px;
    }
    .btn-filter-apply {
        padding: 10px 22px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: .835rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all .2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #6366f1, #818cf8);
        color: #fff;
        box-shadow: 0 2px 8px rgba(99,102,241,.25);
    }
    .btn-filter-apply:hover {
        box-shadow: 0 4px 14px rgba(99,102,241,.35);
        transform: translateY(-1px);
    }
    .btn-filter-reset {
        padding: 10px 18px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: .835rem;
        font-weight: 600;
        background: #f1f5f9;
        color: #64748b;
        text-decoration: none;
        border: 1.5px solid #e2e8f0;
        transition: all .2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-filter-reset:hover {
        background: #e2e8f0;
        color: #475569;
        text-decoration: none;
    }

    /* ── Month Title Badge ── */
    .att-rpt-month-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border-radius: 12px;
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        border: 1px solid #a7f3d0;
        color: #065f46;
        font-size: 0.88rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    /* ── Table Container ── */
    .att-rpt-table-wrap {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
    }
    .att-rpt-table {
        width: 100%;
        border-collapse: collapse;
    }
    .att-rpt-table thead th {
        padding: 14px 16px;
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        text-align: left;
        white-space: nowrap;
    }
    .att-rpt-table thead th.text-center { text-align: center; }
    .att-rpt-table tbody tr {
        transition: background .2s ease;
    }
    .att-rpt-table tbody tr:hover {
        background: #f8fafc;
    }
    .att-rpt-table tbody td {
        padding: 13px 16px;
        font-size: .855rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .att-rpt-table tbody td.text-center { text-align: center; }
    .att-rpt-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* ── Employee Cell ── */
    .att-emp-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .att-emp-name {
        font-weight: 600;
        color: #1e293b;
        font-size: .875rem;
    }
    .att-emp-code {
        display: inline-flex;
        padding: 2px 7px;
        border-radius: 5px;
        font-size: .7rem;
        font-weight: 600;
        background: #eef2ff;
        color: #6366f1;
        letter-spacing: .02em;
        width: fit-content;
    }

    /* ── Stat Cells ── */
    .stat-present {
        font-weight: 700;
        color: #059669;
        font-variant-numeric: tabular-nums;
    }
    .stat-absent {
        font-weight: 700;
        color: #e11d48;
        font-variant-numeric: tabular-nums;
    }
    .stat-leaves {
        font-weight: 700;
        color: #0284c7;
        font-variant-numeric: tabular-nums;
    }
    .stat-working {
        font-weight: 600;
        color: #475569;
        font-variant-numeric: tabular-nums;
    }

    /* ── Percentage Badge ── */
    .pct-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: .78rem;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
    }
    .pct-excellent { background: #ecfdf5; color: #059669; }
    .pct-good      { background: #f0fdf4; color: #16a34a; }
    .pct-average   { background: #fffbeb; color: #d97706; }
    .pct-poor      { background: #fff1f2; color: #e11d48; }

    /* ── Row Number ── */
    .row-num {
        font-weight: 700;
        color: #94a3b8;
        font-size: .8rem;
        font-variant-numeric: tabular-nums;
    }

    /* ── Empty State ── */
    .att-rpt-empty {
        text-align: center;
        padding: 60px 24px;
    }
    .att-rpt-empty-icon {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        color: #34d399;
        margin-bottom: 18px;
    }
    .att-rpt-empty h3 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #334155;
        margin: 0 0 6px;
    }
    .att-rpt-empty p {
        font-size: .85rem;
        color: #94a3b8;
        margin: 0 auto;
        max-width: 340px;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .att-rpt-header { flex-direction: column; align-items: flex-start; }
        .att-rpt-filter-bar { flex-direction: column; }
        .att-rpt-filter-group { min-width: 100%; }
        .att-rpt-table-wrap { overflow-x: auto; }
        .att-rpt-table { min-width: 800px; }
        .att-rpt-page { padding: 1rem 0 3rem; }
    }
</style>

<div class="att-rpt-page">
    <div class="container">

        {{-- ── Breadcrumb ── --}}
        <div class="att-rpt-breadcrumb fade-up">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ route('admin.reports.index') }}">Reports</a>
            <i class="bi bi-chevron-right"></i>
            <span>Attendance Report</span>
        </div>

        {{-- ── Page Header ── --}}
        <div class="att-rpt-header fade-up fade-up-1">
            <div class="att-rpt-header-left">
                <div class="att-rpt-header-icon">
                    <i class="bi bi-calendar2-check"></i>
                </div>
                <h1>
                    Attendance Report
                    <span>Monthly attendance summary &amp; statistics</span>
                </h1>
            </div>
            <div class="att-rpt-header-actions">
                <a href="{{ route('admin.reports.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                @php
                    $exportParams = ['month' => $month, 'year' => $year];
                @endphp
                <a href="{{ route('admin.reports.attendance.export', array_merge(['format' => 'excel'], $exportParams)) }}" class="btn-export btn-export-excel">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
                <a href="{{ route('admin.reports.attendance.export', array_merge(['format' => 'pdf'], $exportParams)) }}" class="btn-export btn-export-pdf">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>
            </div>
        </div>

        {{-- ── Filter Bar ── --}}
        <form method="GET" action="{{ route('admin.reports.attendance') }}" class="att-rpt-filter-bar fade-up fade-up-2">
            <div class="att-rpt-filter-group">
                <label for="filter-month"><i class="bi bi-calendar3"></i> Month</label>
                <select name="month" id="filter-month" class="att-rpt-filter-select">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="att-rpt-filter-group">
                <label for="filter-year"><i class="bi bi-calendar-range"></i> Year</label>
                <input type="number" name="year" id="filter-year" class="att-rpt-filter-input" value="{{ $year }}" min="2000" max="2099" style="width:130px;">
            </div>
            <div class="att-rpt-filter-actions">
                <button type="submit" class="btn-filter-apply">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="{{ route('admin.reports.attendance') }}" class="btn-filter-reset">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>

        {{-- ── Month Badge ── --}}
        <div class="att-rpt-month-badge fade-up fade-up-3">
            <i class="bi bi-calendar-month"></i>
            {{ $monthName }} {{ $year }} &mdash; {{ $workingDays }} Working Days
        </div>

        {{-- ── Table ── --}}
        <div class="att-rpt-table-wrap fade-up fade-up-4">
            @if(count($attendanceData) > 0)
                <table class="att-rpt-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Department</th>
                            <th class="text-center">Present</th>
                            <th class="text-center">Absent</th>
                            <th class="text-center">Leaves</th>
                            <th class="text-center">Working Days</th>
                            <th class="text-center">Attendance %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendanceData as $index => $data)
                            <tr>
                                <td><span class="row-num">{{ $index + 1 }}</span></td>
                                <td>
                                    <div class="att-emp-info">
                                        <span class="att-emp-name">{{ $data['employee']->full_name ?? '—' }}</span>
                                        <span class="att-emp-code">{{ $data['employee']->employee_code ?? '—' }}</span>
                                    </div>
                                </td>
                                <td style="font-weight:500;">{{ $data['employee']->department->name ?? '—' }}</td>
                                <td class="text-center"><span class="stat-present">{{ $data['present'] }}</span></td>
                                <td class="text-center"><span class="stat-absent">{{ $data['absent'] }}</span></td>
                                <td class="text-center"><span class="stat-leaves">{{ $data['leaves'] }}</span></td>
                                <td class="text-center"><span class="stat-working">{{ $workingDays }}</span></td>
                                <td class="text-center">
                                    @php
                                        $pct = round($data['percentage'], 1);
                                        if ($pct >= 95) $pctClass = 'pct-excellent';
                                        elseif ($pct >= 80) $pctClass = 'pct-good';
                                        elseif ($pct >= 60) $pctClass = 'pct-average';
                                        else $pctClass = 'pct-poor';
                                    @endphp
                                    <span class="pct-badge {{ $pctClass }}">
                                        @if($pct >= 95)
                                            <i class="bi bi-check-circle-fill" style="font-size:.7rem;"></i>
                                        @elseif($pct < 60)
                                            <i class="bi bi-exclamation-triangle-fill" style="font-size:.7rem;"></i>
                                        @endif
                                        {{ $pct }}%
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="att-rpt-empty">
                    <div class="att-rpt-empty-icon">
                        <i class="bi bi-calendar-x"></i>
                    </div>
                    <h3>No Attendance Data</h3>
                    <p>No attendance records found for {{ $monthName }} {{ $year }}. Try selecting a different month or year.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
