@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    /* ── Reset & Base ── */
    .att-page * { box-sizing: border-box; margin: 0; padding: 0; }
    .att-page {
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
    @keyframes shimmer {
        0%   { background-position: -400px 0; }
        100% { background-position: 400px 0; }
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
    .att-flash-error {
        background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
        color: #991b1b;
        border-color: #fca5a5;
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
    .att-header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
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
        text-decoration: none;
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

    /* ── Summary Cards ── */
    .att-summary-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 18px;
        margin-bottom: 28px;
    }
    .att-stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 22px;
        border: 1px solid #e2e8f0;
        transition: all .3s cubic-bezier(.22,1,.36,1);
        position: relative;
        overflow: hidden;
    }
    .att-stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        border-radius: 16px 16px 0 0;
    }
    .att-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,.08);
    }
    .att-stat-icon {
        width: 42px; height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        margin-bottom: 14px;
    }
    .att-stat-value {
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -.03em;
        line-height: 1;
        margin-bottom: 4px;
    }
    .att-stat-label {
        font-size: .78rem;
        font-weight: 500;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .06em;
    }
    /* Card: Total – Indigo */
    .att-stat-total::before { background: linear-gradient(90deg, #6366f1, #818cf8); }
    .att-stat-total .att-stat-icon { background: #eef2ff; color: #6366f1; }
    .att-stat-total .att-stat-value { color: #4338ca; }
    /* Card: Present – Emerald */
    .att-stat-present::before { background: linear-gradient(90deg, #10b981, #34d399); }
    .att-stat-present .att-stat-icon { background: #ecfdf5; color: #10b981; }
    .att-stat-present .att-stat-value { color: #059669; }
    /* Card: Absent – Rose */
    .att-stat-absent::before { background: linear-gradient(90deg, #f43f5e, #fb7185); }
    .att-stat-absent .att-stat-icon { background: #fff1f2; color: #f43f5e; }
    .att-stat-absent .att-stat-value { color: #e11d48; }
    /* Card: Half Day – Amber */
    .att-stat-half::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .att-stat-half .att-stat-icon { background: #fffbeb; color: #f59e0b; }
    .att-stat-half .att-stat-value { color: #d97706; }
    /* Card: On Leave – Sky */
    .att-stat-leave::before { background: linear-gradient(90deg, #0ea5e9, #38bdf8); }
    .att-stat-leave .att-stat-icon { background: #f0f9ff; color: #0ea5e9; }
    .att-stat-leave .att-stat-value { color: #0284c7; }

    /* ── Filter Bar ── */
    .att-filter-bar {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-end;
        gap: 14px;
        flex-wrap: wrap;
    }
    .att-filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1;
        min-width: 180px;
    }
    .att-filter-group label {
        font-size: .75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    .att-filter-input,
    .att-filter-select {
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
    .att-filter-input:focus,
    .att-filter-select:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        background: #fff;
    }
    .att-filter-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        padding-bottom: 1px;
    }
    .att-btn-filter {
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
    }
    .att-btn-search {
        background: linear-gradient(135deg, #6366f1, #818cf8);
        color: #fff;
        box-shadow: 0 2px 8px rgba(99,102,241,.25);
    }
    .att-btn-search:hover {
        box-shadow: 0 4px 14px rgba(99,102,241,.35);
        transform: translateY(-1px);
    }
    .att-btn-reset {
        background: #f1f5f9;
        color: #64748b;
        text-decoration: none;
    }
    .att-btn-reset:hover {
        background: #e2e8f0;
        color: #475569;
        text-decoration: none;
    }

    /* ── Table Container ── */
    .att-table-wrap {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 24px;
    }
    .att-table {
        width: 100%;
        border-collapse: collapse;
    }
    .att-table thead th {
        padding: 14px 18px;
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
    .att-table tbody tr {
        transition: background .2s ease;
    }
    .att-table tbody tr:hover {
        background: #f8fafc;
    }
    .att-table tbody td {
        padding: 14px 18px;
        font-size: .855rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .att-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Employee Cell */
    .att-emp-info { display: flex; flex-direction: column; gap: 4px; }
    .att-emp-name {
        font-weight: 600;
        color: #1e293b;
        font-size: .875rem;
    }
    .att-emp-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .att-emp-code {
        display: inline-flex;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: .7rem;
        font-weight: 600;
        background: #eef2ff;
        color: #6366f1;
        letter-spacing: .02em;
    }
    .att-emp-dept {
        font-size: .75rem;
        color: #94a3b8;
        font-weight: 500;
    }

    /* Clock badges */
    .att-clock {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: .8rem;
        font-weight: 600;
        font-variant-numeric: tabular-nums;
    }
    .att-clock-in {
        background: #ecfdf5;
        color: #059669;
    }
    .att-clock-out {
        background: #fff1f2;
        color: #e11d48;
    }
    .att-clock i { font-size: .7rem; }

    /* Hours */
    .att-hours {
        font-weight: 700;
        color: #334155;
        font-variant-numeric: tabular-nums;
    }

    /* Status badges */
    .att-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: .73rem;
        font-weight: 700;
        text-transform: capitalize;
        letter-spacing: .02em;
    }
    .att-badge-present  { background: #ecfdf5; color: #059669; }
    .att-badge-absent   { background: #fff1f2; color: #e11d48; }
    .att-badge-half_day { background: #fffbeb; color: #d97706; }
    .att-badge-leave,
    .att-badge-on_leave { background: #f0f9ff; color: #0284c7; }

    .att-badge-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        display: inline-block;
    }
    .att-badge-present  .att-badge-dot { background: #10b981; }
    .att-badge-absent   .att-badge-dot { background: #f43f5e; }
    .att-badge-half_day .att-badge-dot { background: #f59e0b; }
    .att-badge-leave    .att-badge-dot,
    .att-badge-on_leave .att-badge-dot { background: #0ea5e9; }

    /* Actions */
    .att-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: .78rem;
        font-weight: 600;
        color: #6366f1;
        background: #eef2ff;
        border: 1px solid #c7d2fe;
        text-decoration: none;
        transition: all .2s ease;
    }
    .att-action-btn:hover {
        background: #6366f1;
        color: #fff;
        border-color: #6366f1;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99,102,241,.3);
        text-decoration: none;
    }

    /* ── Pagination ── */
    .att-pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding: 0 4px;
    }
    .att-pagination-info {
        font-size: .82rem;
        color: #64748b;
        font-weight: 500;
    }
    .att-pagination-info strong {
        color: #1e293b;
        font-weight: 700;
    }
    .att-pagination-links {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .att-pagination-links .page-item .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border-radius: 9px;
        font-size: .8rem;
        font-weight: 600;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        color: #475569;
        text-decoration: none;
        transition: all .2s ease;
    }
    .att-pagination-links .page-item .page-link:hover {
        border-color: #818cf8;
        color: #6366f1;
        background: #eef2ff;
    }
    .att-pagination-links .page-item.active .page-link {
        background: linear-gradient(135deg, #6366f1, #818cf8);
        color: #fff;
        border-color: #6366f1;
        box-shadow: 0 2px 8px rgba(99,102,241,.25);
    }
    .att-pagination-links .page-item.disabled .page-link {
        opacity: .45;
        pointer-events: none;
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
        max-width: 340px;
        margin: 0 auto;
    }

    /* ── Row Counter ── */
    .att-row-num {
        font-weight: 700;
        color: #94a3b8;
        font-size: .8rem;
        font-variant-numeric: tabular-nums;
    }

    /* ── Responsive ── */
    @media (max-width: 1200px) {
        .att-summary-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 768px) {
        .att-summary-grid { grid-template-columns: repeat(2, 1fr); }
        .att-header { flex-direction: column; align-items: flex-start; }
        .att-filter-bar { flex-direction: column; }
        .att-filter-group { min-width: 100%; }
        .att-table-wrap { overflow-x: auto; }
        .att-table { min-width: 780px; }
        .att-pagination-wrap { flex-direction: column; align-items: flex-start; }
    }
    @media (max-width: 480px) {
        .att-summary-grid { grid-template-columns: 1fr; }
        .att-page { padding: 16px 0; }
    }
</style>

<div class="att-page">
    <div class="container">

        {{-- ── Flash Messages ── --}}
        @if(session('success'))
            <div class="att-flash att-flash-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="att-flash att-flash-error">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- ── Page Header ── --}}
        <div class="att-header fade-up fade-up-1">
            <div class="att-header-left">
                <div class="att-header-icon">
                    <i class="bi bi-calendar2-check"></i>
                </div>
                <h1>
                    Attendance
                    <span>Track & manage daily employee attendance</span>
                </h1>
            </div>
            <div class="att-header-actions">
                <a href="{{ route('admin.attendance.monthly-report') }}" class="att-btn att-btn-outline">
                    <i class="bi bi-file-earmark-bar-graph"></i> Monthly Report
                </a>
                <a href="{{ route('admin.attendance.create') }}" class="att-btn att-btn-primary">
                    <i class="bi bi-plus-lg"></i> Add Record
                </a>
            </div>
        </div>

        {{-- ── Summary Stats ── --}}
        <div class="att-summary-grid fade-up fade-up-2">
            {{-- Total --}}
            <div class="att-stat-card att-stat-total">
                <div class="att-stat-icon"><i class="bi bi-people-fill"></i></div>
                <div class="att-stat-value">{{ $summary['total'] ?? 0 }}</div>
                <div class="att-stat-label">Total Employees</div>
            </div>
            {{-- Present --}}
            <div class="att-stat-card att-stat-present">
                <div class="att-stat-icon"><i class="bi bi-check-circle-fill"></i></div>
                <div class="att-stat-value">{{ $summary['present'] ?? 0 }}</div>
                <div class="att-stat-label">Present</div>
            </div>
            {{-- Absent --}}
            <div class="att-stat-card att-stat-absent">
                <div class="att-stat-icon"><i class="bi bi-x-circle-fill"></i></div>
                <div class="att-stat-value">{{ $summary['absent'] ?? 0 }}</div>
                <div class="att-stat-label">Absent</div>
            </div>
            {{-- Half Day --}}
            <div class="att-stat-card att-stat-half">
                <div class="att-stat-icon"><i class="bi bi-clock-history"></i></div>
                <div class="att-stat-value">{{ $summary['half_day'] ?? 0 }}</div>
                <div class="att-stat-label">Half Day</div>
            </div>
            {{-- On Leave --}}
            <div class="att-stat-card att-stat-leave">
                <div class="att-stat-icon"><i class="bi bi-airplane-fill"></i></div>
                <div class="att-stat-value">{{ $summary['on_leave'] ?? 0 }}</div>
                <div class="att-stat-label">On Leave</div>
            </div>
        </div>

        {{-- ── Filter Row ── --}}
        <form method="GET" action="{{ route('admin.attendance.index') }}" class="att-filter-bar fade-up fade-up-3">
            <div class="att-filter-group">
                <label for="filter-date"><i class="bi bi-calendar3"></i> Date</label>
                <input type="date" id="filter-date" name="date" class="att-filter-input" value="{{ $date }}">
            </div>
            <div class="att-filter-group">
                <label for="filter-search"><i class="bi bi-search"></i> Search</label>
                <input type="text" id="filter-search" name="search" class="att-filter-input" placeholder="Name or employee code…" value="{{ request('search') }}">
            </div>
            <div class="att-filter-group">
                <label for="filter-status"><i class="bi bi-funnel"></i> Status</label>
                <select id="filter-status" name="status" class="att-filter-select">
                    <option value="">All Statuses</option>
                    <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                    <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                    <option value="half_day" {{ request('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
                    <option value="leave" {{ request('status') == 'leave' ? 'selected' : '' }}>On Leave</option>
                </select>
            </div>
            <div class="att-filter-actions">
                <button type="submit" class="att-btn-filter att-btn-search">
                    <i class="bi bi-search"></i> Search
                </button>
                <a href="{{ route('admin.attendance.index') }}" class="att-btn-filter att-btn-reset">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>

        {{-- ── Table ── --}}
        <div class="att-table-wrap fade-up fade-up-4">
            @if($attendances->count())
                <table class="att-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Clock In</th>
                            <th>Clock Out</th>
                            <th>Hours</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $index => $att)
                            <tr>
                                <td><span class="att-row-num">{{ $attendances->firstItem() + $index }}</span></td>
                                <td>
                                    <div class="att-emp-info">
                                        <span class="att-emp-name">{{ $att->employee->full_name ?? '—' }}</span>
                                        <div class="att-emp-meta">
                                            <span class="att-emp-code">{{ $att->employee->employee_code ?? '—' }}</span>
                                            <span class="att-emp-dept">{{ $att->employee->department->name ?? '—' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($att->clock_in)
                                        <span class="att-clock att-clock-in">
                                            <i class="bi bi-box-arrow-in-right"></i>
                                            {{ $att->formatted_clock_in }}
                                        </span>
                                    @else
                                        <span style="color:#94a3b8;">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($att->clock_out)
                                        <span class="att-clock att-clock-out">
                                            <i class="bi bi-box-arrow-right"></i>
                                            {{ $att->formatted_clock_out }}
                                        </span>
                                    @else
                                        <span style="color:#94a3b8;">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="att-hours">{{ $att->working_hours ? $att->working_hours . 'h' : '—' }}</span>
                                </td>
                                <td>
                                    <span class="att-badge att-badge-{{ $att->status }}">
                                        <span class="att-badge-dot"></span>
                                        {{ str_replace('_', ' ', ucfirst($att->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.attendance.edit', $att) }}" class="att-action-btn">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                {{-- Empty State --}}
                <div class="att-empty">
                    <div class="att-empty-icon">
                        <i class="bi bi-calendar-x"></i>
                    </div>
                    <h3>No Attendance Records Found</h3>
                    <p>There are no attendance records matching your current filters. Try adjusting the date or search criteria.</p>
                </div>
            @endif
        </div>

        {{-- ── Pagination ── --}}
        @if($attendances->hasPages())
            <div class="att-pagination-wrap fade-up fade-up-5">
                <div class="att-pagination-info">
                    Showing <strong>{{ $attendances->firstItem() }}</strong> to <strong>{{ $attendances->lastItem() }}</strong>
                    of <strong>{{ $attendances->total() }}</strong> records
                </div>
                <div class="att-pagination-links">
                    {{ $attendances->links() }}
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
