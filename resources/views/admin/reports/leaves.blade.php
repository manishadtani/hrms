@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    .leave-rpt-page {
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
        0%   { box-shadow: 0 0 0 0 rgba(245,158,11,.25); }
        70%  { box-shadow: 0 0 0 8px rgba(245,158,11,0); }
        100% { box-shadow: 0 0 0 0 rgba(245,158,11,0); }
    }
    .fade-up { animation: fadeUp .5s cubic-bezier(.22,1,.36,1) both; }
    .fade-up-1 { animation-delay: .05s; }
    .fade-up-2 { animation-delay: .10s; }
    .fade-up-3 { animation-delay: .15s; }
    .fade-up-4 { animation-delay: .20s; }
    .fade-up-5 { animation-delay: .25s; }

    /* ── Breadcrumb ── */
    .leave-rpt-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.82rem;
        color: #94a3b8;
        margin-bottom: 1.5rem;
    }
    .leave-rpt-breadcrumb a {
        color: #6366f1;
        text-decoration: none;
        font-weight: 500;
    }
    .leave-rpt-breadcrumb a:hover { text-decoration: underline; }

    /* ── Page Header ── */
    .leave-rpt-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 1.75rem;
    }
    .leave-rpt-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .leave-rpt-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.35rem;
        box-shadow: 0 4px 14px rgba(245,158,11,.3);
        animation: pulseRing 2.5s ease infinite;
    }
    .leave-rpt-header h1 {
        font-size: 1.65rem;
        font-weight: 800;
        background: linear-gradient(135deg, #78350f 0%, #f59e0b 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -.025em;
        margin: 0;
    }
    .leave-rpt-header h1 span {
        display: block;
        font-size: .8rem;
        font-weight: 500;
        -webkit-text-fill-color: #64748b;
        letter-spacing: .02em;
        margin-top: 2px;
    }
    .leave-rpt-header-actions {
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
    .leave-rpt-filter-bar {
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
    .leave-rpt-filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 140px;
    }
    .leave-rpt-filter-group label {
        font-size: .75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    .leave-rpt-filter-input {
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
    .leave-rpt-filter-input:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        background: #fff;
    }
    .leave-rpt-filter-actions {
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

    /* ── Year Badge ── */
    .leave-rpt-year-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border-radius: 12px;
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        border: 1px solid #fde68a;
        color: #92400e;
        font-size: 0.88rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    /* ── Table Container ── */
    .leave-rpt-table-wrap {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow-x: auto;
    }
    .leave-rpt-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
    }
    .leave-rpt-table thead th {
        padding: 12px 14px;
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        text-align: center;
        white-space: nowrap;
    }
    .leave-rpt-table thead th.text-left { text-align: left; }
    .leave-rpt-table thead th.th-leave-type {
        background: linear-gradient(180deg, #fefce8, #f8fafc);
        border-left: 1px solid #f1f5f9;
        min-width: 100px;
    }
    .leave-rpt-table tbody tr {
        transition: background .2s ease;
    }
    .leave-rpt-table tbody tr:hover {
        background: #f8fafc;
    }
    .leave-rpt-table tbody td {
        padding: 12px 14px;
        font-size: .84rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        text-align: center;
    }
    .leave-rpt-table tbody td.text-left { text-align: left; }
    .leave-rpt-table tbody td.td-leave-type {
        border-left: 1px solid #f1f5f9;
    }
    .leave-rpt-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* ── Employee Cell ── */
    .leave-emp-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .leave-emp-name {
        font-weight: 600;
        color: #1e293b;
        font-size: .875rem;
    }
    .leave-emp-code {
        display: inline-flex;
        padding: 2px 7px;
        border-radius: 5px;
        font-size: .7rem;
        font-weight: 600;
        background: #eef2ff;
        color: #6366f1;
        width: fit-content;
    }

    /* ── Leave Usage ── */
    .leave-usage {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 3px;
    }
    .leave-usage-text {
        font-weight: 700;
        font-size: .84rem;
        font-variant-numeric: tabular-nums;
    }
    .leave-usage-bar {
        width: 50px;
        height: 4px;
        border-radius: 4px;
        background: #e2e8f0;
        overflow: hidden;
    }
    .leave-usage-bar-fill {
        height: 100%;
        border-radius: 4px;
        transition: width .3s ease;
    }
    .usage-low .leave-usage-text { color: #059669; }
    .usage-low .leave-usage-bar-fill { background: linear-gradient(90deg, #10b981, #34d399); }
    .usage-mid .leave-usage-text { color: #d97706; }
    .usage-mid .leave-usage-bar-fill { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .usage-high .leave-usage-text { color: #e11d48; }
    .usage-high .leave-usage-bar-fill { background: linear-gradient(90deg, #f43f5e, #fb7185); }

    /* ── Row Number ── */
    .row-num {
        font-weight: 700;
        color: #94a3b8;
        font-size: .8rem;
        font-variant-numeric: tabular-nums;
    }

    /* ── Empty State ── */
    .leave-rpt-empty {
        text-align: center;
        padding: 60px 24px;
    }
    .leave-rpt-empty-icon {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        color: #f59e0b;
        margin-bottom: 18px;
    }
    .leave-rpt-empty h3 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #334155;
        margin: 0 0 6px;
    }
    .leave-rpt-empty p {
        font-size: .85rem;
        color: #94a3b8;
        margin: 0 auto;
        max-width: 340px;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .leave-rpt-header { flex-direction: column; align-items: flex-start; }
        .leave-rpt-filter-bar { flex-direction: column; }
        .leave-rpt-filter-group { min-width: 100%; }
        .leave-rpt-page { padding: 1rem 0 3rem; }
    }
</style>

<div class="leave-rpt-page">
    <div class="container">

        {{-- ── Breadcrumb ── --}}
        <div class="leave-rpt-breadcrumb fade-up">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ route('admin.reports.index') }}">Reports</a>
            <i class="bi bi-chevron-right"></i>
            <span>Leave Report</span>
        </div>

        {{-- ── Page Header ── --}}
        <div class="leave-rpt-header fade-up fade-up-1">
            <div class="leave-rpt-header-left">
                <div class="leave-rpt-header-icon">
                    <i class="bi bi-calendar2-week"></i>
                </div>
                <h1>
                    Leave Report
                    <span>Employee-wise leave balance &amp; utilization</span>
                </h1>
            </div>
            <div class="leave-rpt-header-actions">
                <a href="{{ route('admin.reports.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <a href="{{ route('admin.reports.leaves.export', ['format' => 'excel', 'year' => $year]) }}" class="btn-export btn-export-excel">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
                <a href="{{ route('admin.reports.leaves.export', ['format' => 'pdf', 'year' => $year]) }}" class="btn-export btn-export-pdf">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>
            </div>
        </div>

        {{-- ── Filter Bar ── --}}
        <form method="GET" action="{{ route('admin.reports.leaves') }}" class="leave-rpt-filter-bar fade-up fade-up-2">
            <div class="leave-rpt-filter-group">
                <label for="filter-year"><i class="bi bi-calendar-range"></i> Year</label>
                <input type="number" name="year" id="filter-year" class="leave-rpt-filter-input" value="{{ $year }}" min="2000" max="2099" style="width:140px;">
            </div>
            <div class="leave-rpt-filter-actions">
                <button type="submit" class="btn-filter-apply">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="{{ route('admin.reports.leaves') }}" class="btn-filter-reset">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>

        {{-- ── Year Badge ── --}}
        <div class="leave-rpt-year-badge fade-up fade-up-3">
            <i class="bi bi-calendar-event"></i>
            Leave Balances for {{ $year }}
        </div>

        {{-- ── Table ── --}}
        <div class="leave-rpt-table-wrap fade-up fade-up-4">
            @if(count($leaveData) > 0)
                <table class="leave-rpt-table">
                    <thead>
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">Employee</th>
                            <th class="text-left">Department</th>
                            @foreach($leaveTypes as $lt)
                                <th class="th-leave-type">{{ $lt->name }}<br><small style="font-weight:500;color:#94a3b8;text-transform:none;letter-spacing:0;">Used / Total</small></th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaveData as $index => $data)
                            <tr>
                                <td class="text-left"><span class="row-num">{{ $index + 1 }}</span></td>
                                <td class="text-left">
                                    <div class="leave-emp-info">
                                        <span class="leave-emp-name">{{ $data['employee']->full_name ?? '—' }}</span>
                                        <span class="leave-emp-code">{{ $data['employee']->employee_code ?? '—' }}</span>
                                    </div>
                                </td>
                                <td class="text-left" style="font-weight:500;">{{ $data['employee']->department->name ?? '—' }}</td>
                                @foreach($leaveTypes as $lt)
                                    @php
                                        $typeData = $data['types'][$lt->code] ?? ['total' => 0, 'used' => 0, 'remaining' => 0];
                                        $total = $typeData['total'];
                                        $used = $typeData['used'];
                                        $pct = $total > 0 ? ($used / $total) * 100 : 0;
                                        if ($pct >= 80) $usageClass = 'usage-high';
                                        elseif ($pct >= 50) $usageClass = 'usage-mid';
                                        else $usageClass = 'usage-low';
                                    @endphp
                                    <td class="td-leave-type">
                                        <div class="leave-usage {{ $usageClass }}">
                                            <span class="leave-usage-text">{{ $used }} / {{ $total }}</span>
                                            <div class="leave-usage-bar">
                                                <div class="leave-usage-bar-fill" style="width:{{ min($pct, 100) }}%;"></div>
                                            </div>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="leave-rpt-empty">
                    <div class="leave-rpt-empty-icon">
                        <i class="bi bi-calendar2-x"></i>
                    </div>
                    <h3>No Leave Data</h3>
                    <p>No leave records found for {{ $year }}. Try selecting a different year.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
