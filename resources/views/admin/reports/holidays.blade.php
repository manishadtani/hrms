@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    .hol-rpt-page {
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
        0%   { box-shadow: 0 0 0 0 rgba(244,63,94,.25); }
        70%  { box-shadow: 0 0 0 8px rgba(244,63,94,0); }
        100% { box-shadow: 0 0 0 0 rgba(244,63,94,0); }
    }
    .fade-up { animation: fadeUp .5s cubic-bezier(.22,1,.36,1) both; }
    .fade-up-1 { animation-delay: .05s; }
    .fade-up-2 { animation-delay: .10s; }
    .fade-up-3 { animation-delay: .15s; }
    .fade-up-4 { animation-delay: .20s; }
    .fade-up-5 { animation-delay: .25s; }
    .fade-up-6 { animation-delay: .30s; }

    /* ── Breadcrumb ── */
    .hol-rpt-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.82rem;
        color: #94a3b8;
        margin-bottom: 1.5rem;
    }
    .hol-rpt-breadcrumb a {
        color: #6366f1;
        text-decoration: none;
        font-weight: 500;
    }
    .hol-rpt-breadcrumb a:hover { text-decoration: underline; }

    /* ── Page Header ── */
    .hol-rpt-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 1.75rem;
    }
    .hol-rpt-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .hol-rpt-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #f43f5e 0%, #fb7185 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.35rem;
        box-shadow: 0 4px 14px rgba(244,63,94,.3);
        animation: pulseRing 2.5s ease infinite;
    }
    .hol-rpt-header h1 {
        font-size: 1.65rem;
        font-weight: 800;
        background: linear-gradient(135deg, #881337 0%, #f43f5e 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -.025em;
        margin: 0;
    }
    .hol-rpt-header h1 span {
        display: block;
        font-size: .8rem;
        font-weight: 500;
        -webkit-text-fill-color: #64748b;
        letter-spacing: .02em;
        margin-top: 2px;
    }
    .hol-rpt-header-actions {
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
    .hol-rpt-filter-bar {
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
    .hol-rpt-filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 140px;
    }
    .hol-rpt-filter-group label {
        font-size: .75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    .hol-rpt-filter-input {
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
    .hol-rpt-filter-input:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        background: #fff;
    }
    .hol-rpt-filter-actions {
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

    /* ── Summary Cards ── */
    .hol-rpt-summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 1.75rem;
    }
    .hol-rpt-stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        transition: all .3s cubic-bezier(.22,1,.36,1);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .hol-rpt-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        border-radius: 16px 0 0 16px;
    }
    .hol-rpt-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,.08);
    }
    .hol-rpt-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }
    .hol-rpt-stat-value {
        font-size: 1.6rem;
        font-weight: 800;
        letter-spacing: -.03em;
        line-height: 1;
        margin-bottom: 2px;
    }
    .hol-rpt-stat-label {
        font-size: .75rem;
        font-weight: 500;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    /* Card: National – Red */
    .hol-stat-national::before { background: linear-gradient(180deg, #ef4444, #f87171); }
    .hol-stat-national .hol-rpt-stat-icon { background: #fef2f2; color: #ef4444; }
    .hol-stat-national .hol-rpt-stat-value { color: #dc2626; }

    /* Card: Regional – Blue */
    .hol-stat-regional::before { background: linear-gradient(180deg, #3b82f6, #60a5fa); }
    .hol-stat-regional .hol-rpt-stat-icon { background: #eff6ff; color: #3b82f6; }
    .hol-stat-regional .hol-rpt-stat-value { color: #2563eb; }

    /* Card: Company – Green */
    .hol-stat-company::before { background: linear-gradient(180deg, #22c55e, #4ade80); }
    .hol-stat-company .hol-rpt-stat-icon { background: #f0fdf4; color: #22c55e; }
    .hol-stat-company .hol-rpt-stat-value { color: #16a34a; }

    /* Card: Optional – Slate */
    .hol-stat-optional::before { background: linear-gradient(180deg, #94a3b8, #cbd5e1); }
    .hol-stat-optional .hol-rpt-stat-icon { background: #f8fafc; color: #94a3b8; }
    .hol-stat-optional .hol-rpt-stat-value { color: #64748b; }

    /* ── Total Badge ── */
    .hol-rpt-total-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border-radius: 12px;
        background: linear-gradient(135deg, #fff1f2, #ffe4e6);
        border: 1px solid #fecdd3;
        color: #9f1239;
        font-size: 0.88rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    /* ── Table Container ── */
    .hol-rpt-table-wrap {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
    }
    .hol-rpt-table {
        width: 100%;
        border-collapse: collapse;
    }
    .hol-rpt-table thead th {
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
    .hol-rpt-table tbody tr {
        transition: background .2s ease;
    }
    .hol-rpt-table tbody tr:hover {
        background: #f8fafc;
    }
    .hol-rpt-table tbody td {
        padding: 13px 16px;
        font-size: .855rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .hol-rpt-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* ── Date Cell ── */
    .hol-date-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .hol-date-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: .65rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        line-height: 1.1;
    }
    .hol-date-icon .day {
        font-size: 1rem;
        font-weight: 800;
        line-height: 1;
    }
    .hol-date-text {
        display: flex;
        flex-direction: column;
        gap: 1px;
    }
    .hol-date-full {
        font-weight: 600;
        color: #1e293b;
        font-size: .84rem;
        white-space: nowrap;
    }
    .hol-date-weekday {
        font-size: .72rem;
        color: #94a3b8;
        font-weight: 500;
    }

    /* ── Type Badges ── */
    .hol-type-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: .73rem;
        font-weight: 700;
        text-transform: capitalize;
        letter-spacing: .02em;
    }
    .hol-badge-national {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .hol-badge-regional {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }
    .hol-badge-company {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }
    .hol-badge-optional {
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    /* ── Date BG Colors ── */
    .date-bg-national { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .date-bg-regional { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .date-bg-company  { background: linear-gradient(135deg, #22c55e, #16a34a); }
    .date-bg-optional { background: linear-gradient(135deg, #94a3b8, #64748b); }

    /* ── Description ── */
    .hol-desc {
        color: #64748b;
        font-size: .83rem;
        max-width: 280px;
        line-height: 1.5;
    }

    /* ── Row Number ── */
    .row-num {
        font-weight: 700;
        color: #94a3b8;
        font-size: .8rem;
        font-variant-numeric: tabular-nums;
    }

    /* ── Empty State ── */
    .hol-rpt-empty {
        text-align: center;
        padding: 60px 24px;
    }
    .hol-rpt-empty-icon {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        color: #fb7185;
        margin-bottom: 18px;
    }
    .hol-rpt-empty h3 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #334155;
        margin: 0 0 6px;
    }
    .hol-rpt-empty p {
        font-size: .85rem;
        color: #94a3b8;
        margin: 0 auto;
        max-width: 340px;
    }

    /* ── Responsive ── */
    @media (max-width: 992px) {
        .hol-rpt-summary-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .hol-rpt-header { flex-direction: column; align-items: flex-start; }
        .hol-rpt-filter-bar { flex-direction: column; }
        .hol-rpt-filter-group { min-width: 100%; }
        .hol-rpt-summary-grid { grid-template-columns: 1fr; }
        .hol-rpt-table-wrap { overflow-x: auto; }
        .hol-rpt-table { min-width: 650px; }
        .hol-rpt-page { padding: 1rem 0 3rem; }
    }
</style>

<div class="hol-rpt-page">
    <div class="container">

        {{-- ── Breadcrumb ── --}}
        <div class="hol-rpt-breadcrumb fade-up">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ route('admin.reports.index') }}">Reports</a>
            <i class="bi bi-chevron-right"></i>
            <span>Holiday Report</span>
        </div>

        {{-- ── Page Header ── --}}
        <div class="hol-rpt-header fade-up fade-up-1">
            <div class="hol-rpt-header-left">
                <div class="hol-rpt-header-icon">
                    <i class="bi bi-calendar2-heart"></i>
                </div>
                <h1>
                    Holiday Report
                    <span>Annual holiday calendar &amp; type breakdown</span>
                </h1>
            </div>
            <div class="hol-rpt-header-actions">
                <a href="{{ route('admin.reports.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <a href="{{ route('admin.reports.holidays.export', ['format' => 'excel', 'year' => $year]) }}" class="btn-export btn-export-excel">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
                <a href="{{ route('admin.reports.holidays.export', ['format' => 'pdf', 'year' => $year]) }}" class="btn-export btn-export-pdf">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>
            </div>
        </div>

        {{-- ── Filter Bar ── --}}
        <form method="GET" action="{{ route('admin.reports.holidays') }}" class="hol-rpt-filter-bar fade-up fade-up-2">
            <div class="hol-rpt-filter-group">
                <label for="filter-year"><i class="bi bi-calendar-range"></i> Year</label>
                <input type="number" name="year" id="filter-year" class="hol-rpt-filter-input" value="{{ $year }}" min="2000" max="2099" style="width:140px;">
            </div>
            <div class="hol-rpt-filter-actions">
                <button type="submit" class="btn-filter-apply">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="{{ route('admin.reports.holidays') }}" class="btn-filter-reset">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>

        {{-- ── Summary Cards ── --}}
        <div class="hol-rpt-summary-grid fade-up fade-up-3">
            <div class="hol-rpt-stat-card hol-stat-national">
                <div class="hol-rpt-stat-icon"><i class="bi bi-flag-fill"></i></div>
                <div>
                    <div class="hol-rpt-stat-value">{{ $summary['national'] ?? 0 }}</div>
                    <div class="hol-rpt-stat-label">National</div>
                </div>
            </div>
            <div class="hol-rpt-stat-card hol-stat-regional">
                <div class="hol-rpt-stat-icon"><i class="bi bi-geo-alt-fill"></i></div>
                <div>
                    <div class="hol-rpt-stat-value">{{ $summary['regional'] ?? 0 }}</div>
                    <div class="hol-rpt-stat-label">Regional</div>
                </div>
            </div>
            <div class="hol-rpt-stat-card hol-stat-company">
                <div class="hol-rpt-stat-icon"><i class="bi bi-building"></i></div>
                <div>
                    <div class="hol-rpt-stat-value">{{ $summary['company'] ?? 0 }}</div>
                    <div class="hol-rpt-stat-label">Company</div>
                </div>
            </div>
            <div class="hol-rpt-stat-card hol-stat-optional">
                <div class="hol-rpt-stat-icon"><i class="bi bi-bookmark"></i></div>
                <div>
                    <div class="hol-rpt-stat-value">{{ $summary['optional'] ?? 0 }}</div>
                    <div class="hol-rpt-stat-label">Optional</div>
                </div>
            </div>
        </div>

        {{-- ── Total Badge ── --}}
        <div class="hol-rpt-total-badge fade-up fade-up-4">
            <i class="bi bi-calendar2-heart"></i>
            {{ $summary['total'] ?? 0 }} Total Holidays in {{ $year }}
        </div>

        {{-- ── Table ── --}}
        <div class="hol-rpt-table-wrap fade-up fade-up-5">
            @if($holidays->count())
                <table class="hol-rpt-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($holidays as $index => $holiday)
                            <tr>
                                <td><span class="row-num">{{ $index + 1 }}</span></td>
                                <td>
                                    <div class="hol-date-cell">
                                        <div class="hol-date-icon date-bg-{{ $holiday->type }}">
                                            <span style="font-size:.55rem;text-transform:uppercase;letter-spacing:.5px;">{{ $holiday->date->format('M') }}</span>
                                            <span class="day">{{ $holiday->date->format('d') }}</span>
                                        </div>
                                        <div class="hol-date-text">
                                            <span class="hol-date-full">{{ $holiday->date->format('d M Y') }}</span>
                                            <span class="hol-date-weekday">{{ $holiday->date->format('l') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-weight:600;color:#0f172a;">{{ $holiday->name }}</td>
                                <td>
                                    <span class="hol-type-badge hol-badge-{{ $holiday->type }}">
                                        @switch($holiday->type)
                                            @case('national')
                                                <i class="bi bi-flag-fill"></i>
                                                @break
                                            @case('regional')
                                                <i class="bi bi-geo-alt-fill"></i>
                                                @break
                                            @case('company')
                                                <i class="bi bi-building"></i>
                                                @break
                                            @case('optional')
                                                <i class="bi bi-bookmark"></i>
                                                @break
                                        @endswitch
                                        {{ ucfirst($holiday->type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="hol-desc">{{ $holiday->description ?? '—' }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="hol-rpt-empty">
                    <div class="hol-rpt-empty-icon">
                        <i class="bi bi-calendar2-x"></i>
                    </div>
                    <h3>No Holidays Found</h3>
                    <p>No holidays configured for {{ $year }}. Try selecting a different year.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
