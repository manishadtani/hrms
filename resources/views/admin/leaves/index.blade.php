@extends('layouts.app')

@section('content')
<style>
    /* ── Base & Typography ── */
    .leave-page {
        font-family: 'Inter', sans-serif;
        padding: 2rem 0 3rem;
        background: #f8f9fc;
        min-height: 100vh;
    }

    /* ── Fade-Up Animation ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up {
        animation: fadeUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    .fade-up-d1 { animation-delay: 0.06s; }
    .fade-up-d2 { animation-delay: 0.12s; }
    .fade-up-d3 { animation-delay: 0.18s; }
    .fade-up-d4 { animation-delay: 0.24s; }
    .fade-up-d5 { animation-delay: 0.30s; }

    /* ── Pulse for Pending ── */
    @keyframes pulse-amber {
        0%, 100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.35); }
        50%      { box-shadow: 0 0 0 10px rgba(245, 158, 11, 0); }
    }

    /* ── Page Header ── */
    .leave-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 1.75rem;
    }
    .leave-page-header h1 {
        font-size: 1.65rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        letter-spacing: -0.02em;
    }
    .leave-page-header h1 i {
        color: #6366f1;
        margin-right: 0.5rem;
        font-size: 1.4rem;
    }
    .leave-page-header .breadcrumb-trail {
        font-size: 0.82rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    .leave-page-header .breadcrumb-trail a {
        color: #6366f1;
        text-decoration: none;
        font-weight: 500;
    }
    .leave-page-header .breadcrumb-trail a:hover {
        text-decoration: underline;
    }

    /* ── Summary Cards ── */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.25rem;
        margin-bottom: 1.75rem;
    }
    .summary-card {
        background: #fff;
        border-radius: 14px;
        padding: 1.35rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid #e5e7eb;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        position: relative;
        overflow: hidden;
    }
    .summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.07);
    }
    .summary-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 4px; height: 100%;
        border-radius: 14px 0 0 14px;
    }
    .summary-card .sc-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }
    .summary-card .sc-info h3 {
        font-size: 1.55rem;
        font-weight: 700;
        margin: 0;
        line-height: 1;
    }
    .summary-card .sc-info p {
        font-size: 0.8rem;
        color: #64748b;
        margin: 0.2rem 0 0;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    /* Pending */
    .sc-pending::before { background: #f59e0b; }
    .sc-pending .sc-icon { background: #fef3c7; color: #d97706; }
    .sc-pending .sc-info h3 { color: #b45309; }
    .sc-pending { animation: pulse-amber 2.5s ease-in-out infinite; }

    /* Approved */
    .sc-approved::before { background: #10b981; }
    .sc-approved .sc-icon { background: #d1fae5; color: #059669; }
    .sc-approved .sc-info h3 { color: #047857; }

    /* Rejected */
    .sc-rejected::before { background: #f43f5e; }
    .sc-rejected .sc-icon { background: #ffe4e6; color: #e11d48; }
    .sc-rejected .sc-info h3 { color: #be123c; }

    /* ── Filter Bar ── */
    .filter-bar {
        background: #fff;
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        border: 1px solid #e5e7eb;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-end;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .filter-bar .fb-group {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
        flex: 1;
        min-width: 180px;
    }
    .filter-bar .fb-group label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .filter-bar .fb-group select,
    .filter-bar .fb-group input {
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        padding: 0.55rem 0.85rem;
        font-size: 0.88rem;
        font-family: 'Inter', sans-serif;
        color: #334155;
        background: #f8fafc;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        width: 100%;
    }
    .filter-bar .fb-group select:focus,
    .filter-bar .fb-group input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        background: #fff;
    }
    .filter-bar .fb-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        padding-bottom: 1px;
    }
    .btn-filter {
        background: linear-gradient(135deg, #6366f1, #818cf8);
        color: #fff;
        border: none;
        border-radius: 9px;
        padding: 0.58rem 1.3rem;
        font-size: 0.88rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .btn-filter:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
    }
    .btn-reset {
        background: #f1f5f9;
        color: #475569;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        padding: 0.55rem 1.1rem;
        font-size: 0.88rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: background 0.2s;
    }
    .btn-reset:hover {
        background: #e2e8f0;
        color: #334155;
    }

    /* ── Flash Messages ── */
    .flash-msg {
        border-radius: 12px;
        padding: 0.9rem 1.25rem;
        margin-bottom: 1.25rem;
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        border: 1px solid transparent;
    }
    .flash-success {
        background: #ecfdf5;
        color: #065f46;
        border-color: #a7f3d0;
    }
    .flash-error {
        background: #fef2f2;
        color: #991b1b;
        border-color: #fecaca;
    }

    /* ── Table Container ── */
    .table-container {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }
    .table-container table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
    }
    .table-container thead {
        background: #f8fafc;
    }
    .table-container thead th {
        padding: 0.85rem 1rem;
        font-size: 0.73rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #e5e7eb;
        white-space: nowrap;
        text-align: left;
    }
    .table-container tbody td {
        padding: 0.8rem 1rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .table-container tbody tr {
        transition: background 0.15s;
    }
    .table-container tbody tr:hover {
        background: #f8fafc;
    }
    .table-container tbody tr:last-child td {
        border-bottom: none;
    }

    /* Employee Cell */
    .emp-cell {
        display: flex;
        flex-direction: column;
        gap: 0.1rem;
    }
    .emp-cell .emp-name {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.88rem;
    }
    .emp-cell .emp-dept {
        font-size: 0.76rem;
        color: #94a3b8;
        font-weight: 500;
    }

    /* Badges */
    .badge-lt {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.25rem 0.65rem;
        border-radius: 6px;
        font-size: 0.76rem;
        font-weight: 600;
        background: #eef2ff;
        color: #4338ca;
        white-space: nowrap;
    }
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.28rem 0.72rem;
        border-radius: 20px;
        font-size: 0.74rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .badge-pending  { background: #fef3c7; color: #92400e; }
    .badge-approved { background: #d1fae5; color: #065f46; }
    .badge-rejected { background: #ffe4e6; color: #9f1239; }

    /* Reason */
    .reason-text {
        max-width: 180px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.84rem;
        color: #475569;
    }

    /* Action Buttons */
    .btn-action {
        border: none;
        border-radius: 8px;
        padding: 0.38rem 0.85rem;
        font-size: 0.78rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .btn-action:hover {
        transform: translateY(-1px);
    }
    .btn-approve {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: #fff;
    }
    .btn-approve:hover {
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
    }
    .btn-reject {
        background: linear-gradient(135deg, #f43f5e, #fb7185);
        color: #fff;
    }
    .btn-reject:hover {
        box-shadow: 0 4px 12px rgba(244, 63, 94, 0.35);
    }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 3.5rem 1rem;
    }
    .empty-state i {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 0.75rem;
        display: block;
    }
    .empty-state h4 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #64748b;
        margin: 0 0 0.3rem;
    }
    .empty-state p {
        font-size: 0.85rem;
        color: #94a3b8;
        margin: 0;
    }

    /* ── Pagination ── */
    .pagination-wrap {
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
        border-top: 1px solid #f1f5f9;
    }
    .pagination-wrap .pag-info {
        font-size: 0.82rem;
        color: #64748b;
        font-weight: 500;
    }
    .pagination-wrap nav .pagination {
        margin: 0;
        gap: 0.25rem;
    }
    .pagination-wrap nav .page-link {
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 600;
        color: #475569;
        border: 1.5px solid #e2e8f0;
        padding: 0.4rem 0.75rem;
        font-family: 'Inter', sans-serif;
        transition: all 0.2s;
    }
    .pagination-wrap nav .page-link:hover {
        background: #6366f1;
        color: #fff;
        border-color: #6366f1;
    }
    .pagination-wrap nav .page-item.active .page-link {
        background: #6366f1;
        border-color: #6366f1;
        color: #fff;
    }
    .pagination-wrap nav .page-item.disabled .page-link {
        color: #cbd5e1;
        background: transparent;
    }

    /* ── Modal Customizations ── */
    .modal {
        z-index: 1060 !important;
    }
    .modal-backdrop {
        z-index: 1055 !important;
    }
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 24px 48px rgba(0,0,0,0.12);
    }
    .modal-header {
        border-bottom: 1px solid #f1f5f9;
        padding: 1.25rem 1.5rem;
    }
    .modal-header .modal-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.1rem;
    }
    .modal-header .btn-close {
        opacity: 0.5;
    }
    .modal-body {
        padding: 1.5rem;
        font-family: 'Inter', sans-serif;
    }
    .modal-footer {
        border-top: 1px solid #f1f5f9;
        padding: 1rem 1.5rem;
    }
    .modal-info-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.45rem 0;
        font-size: 0.88rem;
        color: #334155;
    }
    .modal-info-row .mir-label {
        font-weight: 600;
        color: #64748b;
        min-width: 100px;
    }
    .modal-info-row .mir-value {
        font-weight: 500;
    }
    .modal-divider {
        border: none;
        border-top: 1px dashed #e5e7eb;
        margin: 0.75rem 0;
    }
    .modal-remarks textarea {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.7rem 0.9rem;
        font-size: 0.88rem;
        font-family: 'Inter', sans-serif;
        color: #334155;
        background: #f8fafc;
        resize: vertical;
        width: 100%;
        min-height: 80px;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
    }
    .modal-remarks textarea:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        background: #fff;
    }
    .modal-remarks label {
        font-size: 0.82rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.35rem;
        display: block;
    }
    .btn-modal-approve {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .btn-modal-approve:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(16, 185, 129, 0.35);
    }
    .btn-modal-reject {
        background: linear-gradient(135deg, #ef4444, #f87171);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .btn-modal-reject:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(239, 68, 68, 0.35);
    }
    .btn-modal-cancel {
        background: #f1f5f9;
        color: #475569;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.6rem 1.3rem;
        font-size: 0.9rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-modal-cancel:hover {
        background: #e2e8f0;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .leave-page { padding: 1rem 0; }
        .summary-grid { grid-template-columns: 1fr; }
        .filter-bar { flex-direction: column; }
        .filter-bar .fb-group { min-width: 100%; }
        .table-container { overflow-x: auto; }
        .table-container table { min-width: 900px; }
    }
</style>

<div class="leave-page">
    <div class="container">
        {{-- ── Page Header ── --}}
        <div class="leave-page-header fade-up">
            <h1><i class="bi bi-calendar2-week"></i> Leave Requests</h1>
            <div class="breadcrumb-trail">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <i class="bi bi-chevron-right"></i>
                <span>Leave Requests</span>
            </div>
        </div>

        {{-- ── Flash Messages ── --}}
        @if(session('success'))
            <div class="flash-msg flash-success fade-up">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flash-msg flash-error fade-up">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            </div>
        @endif

        {{-- ── Summary Cards ── --}}
        <div class="summary-grid">
            <div class="summary-card sc-pending fade-up fade-up-d1">
                <div class="sc-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="sc-info">
                    <h3>{{ $summary['pending'] ?? 0 }}</h3>
                    <p>Pending</p>
                </div>
            </div>
            <div class="summary-card sc-approved fade-up fade-up-d2">
                <div class="sc-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="sc-info">
                    <h3>{{ $summary['approved'] ?? 0 }}</h3>
                    <p>Approved</p>
                </div>
            </div>
            <div class="summary-card sc-rejected fade-up fade-up-d3">
                <div class="sc-icon">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="sc-info">
                    <h3>{{ $summary['rejected'] ?? 0 }}</h3>
                    <p>Rejected</p>
                </div>
            </div>
        </div>

        {{-- ── Filters ── --}}
        <form method="GET" action="{{ route('admin.leaves.index') }}" class="filter-bar fade-up fade-up-d4">
            <div class="fb-group">
                <label for="filter-status">Status</label>
                <select name="status" id="filter-status">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="fb-group">
                <label for="filter-leave-type">Leave Type</label>
                <select name="leave_type_id" id="filter-leave-type">
                    <option value="">All Types</option>
                    @foreach($leaveTypes as $lt)
                        <option value="{{ $lt->id }}" {{ request('leave_type_id') == $lt->id ? 'selected' : '' }}>
                            {{ $lt->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="fb-group">
                <label for="filter-search">Search</label>
                <input type="text"
                       name="search"
                       id="filter-search"
                       placeholder="Employee name or code…"
                       value="{{ request('search') }}">
            </div>
            <div class="fb-actions">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="{{ route('admin.leaves.index') }}" class="btn-reset">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>

        {{-- ── Table ── --}}
        <div class="table-container fade-up fade-up-d5">
            @if($leaveRequests->count())
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Days</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Approved By</th>
                            <th style="text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaveRequests as $index => $lr)
                            <tr>
                                <td style="font-weight:600;color:#94a3b8;">
                                    {{ $leaveRequests->firstItem() + $index }}
                                </td>
                                <td>
                                    <div class="emp-cell">
                                        <span class="emp-name">{{ $lr->employee->full_name }}</span>
                                        <span class="emp-dept">{{ $lr->employee->department->name ?? '—' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-lt">
                                        <i class="bi bi-tag"></i> {{ $lr->leaveType->name }}
                                    </span>
                                </td>
                                <td style="white-space:nowrap;">{{ $lr->start_date->format('d M Y') }}</td>
                                <td style="white-space:nowrap;">{{ $lr->end_date->format('d M Y') }}</td>
                                <td style="font-weight:600;text-align:center;">{{ $lr->total_days }}</td>
                                <td>
                                    <div class="reason-text" title="{{ $lr->reason }}">
                                        {{ Str::limit($lr->reason, 40) }}
                                    </div>
                                </td>
                                <td>
                                    @php $st = strtolower($lr->status); @endphp
                                    <span class="badge-status badge-{{ $st }}">
                                        @if($st === 'pending')
                                            <i class="bi bi-clock"></i>
                                        @elseif($st === 'approved')
                                            <i class="bi bi-check-lg"></i>
                                        @else
                                            <i class="bi bi-x-lg"></i>
                                        @endif
                                        {{ ucfirst($st) }}
                                    </span>
                                </td>
                                <td>
                                    @if($lr->approver)
                                        <span style="font-weight:500;">{{ $lr->approver->name }}</span>
                                    @else
                                        <span style="color:#cbd5e1;">—</span>
                                    @endif
                                </td>
                                <td style="text-align:center;white-space:nowrap;">
                                    @if($st === 'pending')
                                        <button type="button"
                                                class="btn-action btn-approve"
                                                data-bs-toggle="modal"
                                                data-bs-target="#approveModal{{ $lr->id }}">
                                            <i class="bi bi-check-lg"></i> Approve
                                        </button>
                                        <button type="button"
                                                class="btn-action btn-reject"
                                                data-bs-toggle="modal"
                                                data-bs-target="#rejectModal{{ $lr->id }}">
                                            <i class="bi bi-x-lg"></i> Reject
                                        </button>
                                    @else
                                        <span style="color:#cbd5e1;font-size:0.82rem;">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- ── Pagination ── --}}
                @if($leaveRequests->hasPages())
                    <div class="pagination-wrap">
                        <div class="pag-info">
                            Showing {{ $leaveRequests->firstItem() }}–{{ $leaveRequests->lastItem() }} of {{ $leaveRequests->total() }} requests
                        </div>
                        <div>
                            {{ $leaveRequests->links() }}
                        </div>
                    </div>
                @endif
            @else
                {{-- ── Empty State ── --}}
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h4>No Leave Requests Found</h4>
                    <p>There are no leave requests matching your current filters.</p>
                </div>
            @endif
        </div>
    </div>{{-- /.container --}}
</div>{{-- /.leave-page --}}

{{-- ═══ MODALS — Rendered outside table to avoid overflow clipping ═══ --}}
@foreach($leaveRequests as $lr)
    @if(strtolower($lr->status) === 'pending')
        {{-- Approve Modal --}}
        <div class="modal fade" id="approveModal{{ $lr->id }}" tabindex="-1" aria-hidden="true" style="z-index:1060;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 24px 48px rgba(0,0,0,0.15);">
                    <div class="modal-header" style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);border-bottom:1px solid #d1fae5;padding:1.25rem 1.5rem;">
                        <h5 class="modal-title" style="font-family:'Inter',sans-serif;font-weight:700;font-size:1.1rem;color:#065f46;">
                            <i class="bi bi-check-circle-fill" style="color:#10b981;margin-right:0.4rem;"></i>
                            Approve Leave Request
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('admin.leaves.update-status', $lr) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="approved">
                        <div class="modal-body" style="padding:1.5rem;font-family:'Inter',sans-serif;">
                            <div style="display:flex;gap:0.5rem;padding:0.45rem 0;font-size:0.88rem;color:#334155;">
                                <span style="font-weight:600;color:#64748b;min-width:110px;">Employee</span>
                                <span>{{ $lr->employee->full_name }}</span>
                            </div>
                            <div style="display:flex;gap:0.5rem;padding:0.45rem 0;font-size:0.88rem;color:#334155;">
                                <span style="font-weight:600;color:#64748b;min-width:110px;">Department</span>
                                <span>{{ $lr->employee->department->name ?? '—' }}</span>
                            </div>
                            <div style="display:flex;gap:0.5rem;padding:0.45rem 0;font-size:0.88rem;color:#334155;">
                                <span style="font-weight:600;color:#64748b;min-width:110px;">Leave Type</span>
                                <span>{{ $lr->leaveType->name }}</span>
                            </div>
                            <div style="display:flex;gap:0.5rem;padding:0.45rem 0;font-size:0.88rem;color:#334155;">
                                <span style="font-weight:600;color:#64748b;min-width:110px;">Duration</span>
                                <span>
                                    {{ $lr->start_date->format('d M Y') }} — {{ $lr->end_date->format('d M Y') }}
                                    <strong style="color:#6366f1;margin-left:0.35rem;">({{ $lr->total_days }} day{{ $lr->total_days > 1 ? 's' : '' }})</strong>
                                </span>
                            </div>
                            <div style="display:flex;gap:0.5rem;padding:0.45rem 0;font-size:0.88rem;color:#334155;">
                                <span style="font-weight:600;color:#64748b;min-width:110px;">Reason</span>
                                <span>{{ $lr->reason }}</span>
                            </div>
                            <hr style="border:none;border-top:1px dashed #e5e7eb;margin:0.75rem 0;">
                            <div>
                                <label style="font-size:0.82rem;font-weight:600;color:#475569;margin-bottom:0.35rem;display:block;">Admin Remarks <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                                <textarea name="admin_remarks" placeholder="Add a note for the employee…" style="border:1.5px solid #e2e8f0;border-radius:10px;padding:0.7rem 0.9rem;font-size:0.88rem;font-family:'Inter',sans-serif;color:#334155;background:#f8fafc;resize:vertical;width:100%;min-height:80px;outline:none;"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top:1px solid #f1f5f9;padding:1rem 1.5rem;">
                            <button type="button" style="background:#f1f5f9;color:#475569;border:1.5px solid #e2e8f0;border-radius:10px;padding:0.6rem 1.3rem;font-size:0.9rem;font-weight:600;font-family:'Inter',sans-serif;cursor:pointer;" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" style="background:linear-gradient(135deg,#10b981,#34d399);color:#fff;border:none;border-radius:10px;padding:0.6rem 1.5rem;font-size:0.9rem;font-weight:600;font-family:'Inter',sans-serif;cursor:pointer;display:inline-flex;align-items:center;gap:0.4rem;">
                                <i class="bi bi-check-circle"></i> Approve Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Reject Modal --}}
        <div class="modal fade" id="rejectModal{{ $lr->id }}" tabindex="-1" aria-hidden="true" style="z-index:1060;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 24px 48px rgba(0,0,0,0.15);">
                    <div class="modal-header" style="background:linear-gradient(135deg,#fef2f2,#ffe4e6);border-bottom:1px solid #ffe4e6;padding:1.25rem 1.5rem;">
                        <h5 class="modal-title" style="font-family:'Inter',sans-serif;font-weight:700;font-size:1.1rem;color:#9f1239;">
                            <i class="bi bi-x-circle-fill" style="color:#ef4444;margin-right:0.4rem;"></i>
                            Reject Leave Request
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('admin.leaves.update-status', $lr) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="rejected">
                        <div class="modal-body" style="padding:1.5rem;font-family:'Inter',sans-serif;">
                            <div style="display:flex;gap:0.5rem;padding:0.45rem 0;font-size:0.88rem;color:#334155;">
                                <span style="font-weight:600;color:#64748b;min-width:110px;">Employee</span>
                                <span>{{ $lr->employee->full_name }}</span>
                            </div>
                            <div style="display:flex;gap:0.5rem;padding:0.45rem 0;font-size:0.88rem;color:#334155;">
                                <span style="font-weight:600;color:#64748b;min-width:110px;">Department</span>
                                <span>{{ $lr->employee->department->name ?? '—' }}</span>
                            </div>
                            <div style="display:flex;gap:0.5rem;padding:0.45rem 0;font-size:0.88rem;color:#334155;">
                                <span style="font-weight:600;color:#64748b;min-width:110px;">Leave Type</span>
                                <span>{{ $lr->leaveType->name }}</span>
                            </div>
                            <div style="display:flex;gap:0.5rem;padding:0.45rem 0;font-size:0.88rem;color:#334155;">
                                <span style="font-weight:600;color:#64748b;min-width:110px;">Duration</span>
                                <span>
                                    {{ $lr->start_date->format('d M Y') }} — {{ $lr->end_date->format('d M Y') }}
                                    <strong style="color:#6366f1;margin-left:0.35rem;">({{ $lr->total_days }} day{{ $lr->total_days > 1 ? 's' : '' }})</strong>
                                </span>
                            </div>
                            <div style="display:flex;gap:0.5rem;padding:0.45rem 0;font-size:0.88rem;color:#334155;">
                                <span style="font-weight:600;color:#64748b;min-width:110px;">Reason</span>
                                <span>{{ $lr->reason }}</span>
                            </div>
                            <hr style="border:none;border-top:1px dashed #e5e7eb;margin:0.75rem 0;">
                            <div>
                                <label style="font-size:0.82rem;font-weight:600;color:#475569;margin-bottom:0.35rem;display:block;">Rejection Reason <span style="color:#ef4444;">*</span></label>
                                <textarea name="admin_remarks" placeholder="Please provide a reason for rejection…" required style="border:1.5px solid #e2e8f0;border-radius:10px;padding:0.7rem 0.9rem;font-size:0.88rem;font-family:'Inter',sans-serif;color:#334155;background:#f8fafc;resize:vertical;width:100%;min-height:80px;outline:none;"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top:1px solid #f1f5f9;padding:1rem 1.5rem;">
                            <button type="button" style="background:#f1f5f9;color:#475569;border:1.5px solid #e2e8f0;border-radius:10px;padding:0.6rem 1.3rem;font-size:0.9rem;font-weight:600;font-family:'Inter',sans-serif;cursor:pointer;" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" style="background:linear-gradient(135deg,#ef4444,#f87171);color:#fff;border:none;border-radius:10px;padding:0.6rem 1.5rem;font-size:0.9rem;font-weight:600;font-family:'Inter',sans-serif;cursor:pointer;display:inline-flex;align-items:center;gap:0.4rem;">
                                <i class="bi bi-x-circle"></i> Reject Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach

@endsection
