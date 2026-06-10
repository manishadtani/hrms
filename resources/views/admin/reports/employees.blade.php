@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    .emp-rpt-page {
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

    /* ── Page Header ── */
    .emp-rpt-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 1.75rem;
    }
    .emp-rpt-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .emp-rpt-header-icon {
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
    .emp-rpt-header h1 {
        font-size: 1.65rem;
        font-weight: 800;
        background: linear-gradient(135deg, #312e81 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -.025em;
        margin: 0;
    }
    .emp-rpt-header h1 span {
        display: block;
        font-size: .8rem;
        font-weight: 500;
        -webkit-text-fill-color: #64748b;
        letter-spacing: .02em;
        margin-top: 2px;
    }
    .emp-rpt-header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* ── Breadcrumb ── */
    .emp-rpt-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.82rem;
        color: #94a3b8;
        margin-bottom: 1.5rem;
    }
    .emp-rpt-breadcrumb a {
        color: #6366f1;
        text-decoration: none;
        font-weight: 500;
    }
    .emp-rpt-breadcrumb a:hover { text-decoration: underline; }

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
    .emp-rpt-filter-bar {
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
    .emp-rpt-filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1;
        min-width: 180px;
    }
    .emp-rpt-filter-group label {
        font-size: .75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    .emp-rpt-filter-select {
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
    .emp-rpt-filter-select:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        background: #fff;
    }
    .emp-rpt-filter-actions {
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

    /* ── Results Count ── */
    .emp-rpt-results {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 1rem;
        font-size: 0.82rem;
        color: #64748b;
        font-weight: 500;
    }
    .emp-rpt-results strong {
        color: #1e293b;
        font-weight: 700;
    }

    /* ── Table Container ── */
    .emp-rpt-table-wrap {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
    }
    .emp-rpt-table {
        width: 100%;
        border-collapse: collapse;
    }
    .emp-rpt-table thead th {
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
    .emp-rpt-table tbody tr {
        transition: background .2s ease;
    }
    .emp-rpt-table tbody tr:hover {
        background: #f8fafc;
    }
    .emp-rpt-table tbody td {
        padding: 13px 16px;
        font-size: .855rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .emp-rpt-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* ── Employee Name Cell ── */
    .emp-name-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .emp-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.82rem;
        font-weight: 700;
        color: #6366f1;
        flex-shrink: 0;
    }
    .emp-name-text {
        font-weight: 600;
        color: #1e293b;
    }

    /* ── Code Badge ── */
    .emp-code-badge {
        display: inline-flex;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: .72rem;
        font-weight: 600;
        background: #eef2ff;
        color: #6366f1;
        letter-spacing: .02em;
        font-variant-numeric: tabular-nums;
    }

    /* ── Status Badge ── */
    .emp-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: .73rem;
        font-weight: 700;
        text-transform: capitalize;
    }
    .emp-status-badge .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
    }
    .status-active {
        background: #ecfdf5;
        color: #059669;
    }
    .status-active .status-dot { background: #10b981; }
    .status-inactive {
        background: #fff1f2;
        color: #e11d48;
    }
    .status-inactive .status-dot { background: #f43f5e; }

    /* ── Row Number ── */
    .row-num {
        font-weight: 700;
        color: #94a3b8;
        font-size: .8rem;
        font-variant-numeric: tabular-nums;
    }

    /* ── Empty State ── */
    .emp-rpt-empty {
        text-align: center;
        padding: 60px 24px;
    }
    .emp-rpt-empty-icon {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        color: #818cf8;
        margin-bottom: 18px;
    }
    .emp-rpt-empty h3 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #334155;
        margin: 0 0 6px;
    }
    .emp-rpt-empty p {
        font-size: .85rem;
        color: #94a3b8;
        margin: 0;
        max-width: 340px;
        margin: 0 auto;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .emp-rpt-header { flex-direction: column; align-items: flex-start; }
        .emp-rpt-filter-bar { flex-direction: column; }
        .emp-rpt-filter-group { min-width: 100%; }
        .emp-rpt-table-wrap { overflow-x: auto; }
        .emp-rpt-table { min-width: 900px; }
        .emp-rpt-page { padding: 1rem 0 3rem; }
    }
</style>

<div class="emp-rpt-page">
    <div class="container">

        {{-- ── Breadcrumb ── --}}
        <div class="emp-rpt-breadcrumb fade-up">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ route('admin.reports.index') }}">Reports</a>
            <i class="bi bi-chevron-right"></i>
            <span>Employee Directory</span>
        </div>

        {{-- ── Page Header ── --}}
        <div class="emp-rpt-header fade-up fade-up-1">
            <div class="emp-rpt-header-left">
                <div class="emp-rpt-header-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h1>
                    Employee Directory
                    <span>Complete employee listing with all details</span>
                </h1>
            </div>
            <div class="emp-rpt-header-actions">
                <a href="{{ route('admin.reports.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                @php
                    $exportParams = request()->only(['department_id', 'status']);
                @endphp
                <a href="{{ route('admin.reports.employees.export', array_merge(['format' => 'excel'], $exportParams)) }}" class="btn-export btn-export-excel">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
                <a href="{{ route('admin.reports.employees.export', array_merge(['format' => 'pdf'], $exportParams)) }}" class="btn-export btn-export-pdf">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>
            </div>
        </div>

        {{-- ── Filter Bar ── --}}
        <form method="GET" action="{{ route('admin.reports.employees') }}" class="emp-rpt-filter-bar fade-up fade-up-2">
            <div class="emp-rpt-filter-group">
                <label for="filter-department"><i class="bi bi-building"></i> Department</label>
                <select name="department_id" id="filter-department" class="emp-rpt-filter-select">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="emp-rpt-filter-group">
                <label for="filter-status"><i class="bi bi-funnel"></i> Status</label>
                <select name="status" id="filter-status" class="emp-rpt-filter-select">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="emp-rpt-filter-actions">
                <button type="submit" class="btn-filter-apply">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="{{ route('admin.reports.employees') }}" class="btn-filter-reset">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>

        {{-- ── Results Count ── --}}
        <div class="emp-rpt-results fade-up fade-up-3">
            <i class="bi bi-info-circle"></i>
            Showing <strong>{{ $employees->count() }}</strong> employee{{ $employees->count() !== 1 ? 's' : '' }}
            @if(request('department_id') || request('status'))
                <span style="color:#94a3b8;">with active filters</span>
            @endif
        </div>

        {{-- ── Table ── --}}
        <div class="emp-rpt-table-wrap fade-up fade-up-4">
            @if($employees->count())
                <table class="emp-rpt-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Manager</th>
                            <th>Joining Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $index => $emp)
                            <tr>
                                <td><span class="row-num">{{ $index + 1 }}</span></td>
                                <td>
                                    <div class="emp-name-cell">
                                        <div class="emp-avatar">
                                            {{ strtoupper(substr($emp->full_name ?? $emp->user->name ?? '?', 0, 1)) }}
                                        </div>
                                        <span class="emp-name-text">{{ $emp->full_name ?? $emp->user->name ?? '—' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="emp-code-badge">{{ $emp->employee_code ?? '—' }}</span>
                                </td>
                                <td style="color:#475569;font-size:.83rem;">{{ $emp->user->email ?? '—' }}</td>
                                <td style="font-weight:500;">{{ $emp->department->name ?? '—' }}</td>
                                <td style="font-weight:500;">{{ $emp->designation->name ?? '—' }}</td>
                                <td style="font-size:.83rem;color:#475569;">{{ $emp->manager->full_name ?? '—' }}</td>
                                <td style="white-space:nowrap;font-variant-numeric:tabular-nums;font-size:.83rem;">
                                    {{ $emp->joining_date ? \Carbon\Carbon::parse($emp->joining_date)->format('d M Y') : '—' }}
                                </td>
                                <td>
                                    @php $status = strtolower($emp->status ?? 'active'); @endphp
                                    <span class="emp-status-badge status-{{ $status }}">
                                        <span class="status-dot"></span>
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="emp-rpt-empty">
                    <div class="emp-rpt-empty-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3>No Employees Found</h3>
                    <p>No employees match your current filter criteria. Try adjusting the filters.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
