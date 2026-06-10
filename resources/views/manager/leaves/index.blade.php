@extends('layouts.app')

@section('content')
<style>
    /* ── Base ─────────────────────────────────────────────── */
    .lr-wrap{font-family:'Inter',sans-serif;padding:2rem 0;min-height:80vh;background:#f8f9fb}

    /* ── Fade-up animation ────────────────────────────────── */
    @keyframes fadeUp{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
    .fade-up{animation:fadeUp .5s ease both}
    .fade-up-d1{animation-delay:.08s}
    .fade-up-d2{animation-delay:.16s}
    .fade-up-d3{animation-delay:.24s}
    .fade-up-d4{animation-delay:.32s}

    /* ── Page header ──────────────────────────────────────── */
    .lr-header{display:flex;align-items:center;gap:.75rem;margin-bottom:1.75rem}
    .lr-header-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#6366f1,#818cf8);color:#fff;font-size:1.25rem;box-shadow:0 4px 14px rgba(99,102,241,.3)}
    .lr-header h1{font-size:1.55rem;font-weight:700;color:#1e293b;margin:0}
    .lr-header p{margin:0;font-size:.875rem;color:#64748b}

    /* ── Summary cards ────────────────────────────────────── */
    .stat-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:1.15rem;margin-bottom:1.75rem}
    .stat-card{background:#fff;border-radius:14px;padding:1.35rem 1.5rem;display:flex;align-items:center;gap:1rem;box-shadow:0 1px 4px rgba(0,0,0,.06);transition:transform .2s,box-shadow .2s;position:relative;overflow:hidden}
    .stat-card:hover{transform:translateY(-3px);box-shadow:0 6px 20px rgba(0,0,0,.09)}
    .stat-card::after{content:'';position:absolute;top:0;left:0;width:4px;height:100%;border-radius:4px 0 0 4px}
    .stat-icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0}
    .stat-info .stat-label{font-size:.78rem;font-weight:500;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px}
    .stat-info .stat-value{font-size:1.65rem;font-weight:700;line-height:1.1}

    /* Amber – Pending */
    .stat-pending .stat-icon{background:#fef3c7;color:#d97706}
    .stat-pending::after{background:linear-gradient(180deg,#f59e0b,#fbbf24)}
    .stat-pending .stat-label{color:#92400e}
    .stat-pending .stat-value{color:#b45309}

    /* Emerald – Approved */
    .stat-approved .stat-icon{background:#d1fae5;color:#059669}
    .stat-approved::after{background:linear-gradient(180deg,#10b981,#34d399)}
    .stat-approved .stat-label{color:#065f46}
    .stat-approved .stat-value{color:#047857}

    /* Rose – Rejected */
    .stat-rejected .stat-icon{background:#ffe4e6;color:#e11d48}
    .stat-rejected::after{background:linear-gradient(180deg,#f43f5e,#fb7185)}
    .stat-rejected .stat-label{color:#9f1239}
    .stat-rejected .stat-value{color:#be123c}

    /* Pulse dot */
    @keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(1.6)}}
    .pulse-dot{width:8px;height:8px;border-radius:50%;background:#f59e0b;display:inline-block;animation:pulse 1.8s ease-in-out infinite;margin-left:6px;vertical-align:middle}

    /* ── Filter bar ───────────────────────────────────────── */
    .filter-bar{background:#fff;border-radius:14px;padding:1rem 1.5rem;margin-bottom:1.5rem;box-shadow:0 1px 4px rgba(0,0,0,.06);display:flex;align-items:center;gap:1rem;flex-wrap:wrap}
    .filter-bar label{font-size:.82rem;font-weight:600;color:#475569;margin:0;white-space:nowrap}
    .filter-select{border:1.5px solid #e2e8f0;border-radius:10px;padding:.45rem 2.2rem .45rem .85rem;font-size:.85rem;font-family:'Inter',sans-serif;color:#334155;background:#f8fafc;transition:border-color .2s,box-shadow .2s;appearance:none;-webkit-appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right .75rem center;min-width:170px}
    .filter-select:focus{outline:none;border-color:#818cf8;box-shadow:0 0 0 3px rgba(129,140,248,.18)}

    /* ── Table card ────────────────────────────────────────── */
    .table-card{background:#fff;border-radius:14px;box-shadow:0 1px 4px rgba(0,0,0,.06);overflow:hidden}
    .table-card .table{margin:0;font-size:.85rem}
    .table-card .table thead th{background:#f8fafc;color:#475569;font-weight:600;font-size:.76rem;text-transform:uppercase;letter-spacing:.4px;padding:.85rem 1rem;border-bottom:2px solid #e2e8f0;white-space:nowrap}
    .table-card .table tbody td{padding:.8rem 1rem;vertical-align:middle;color:#334155;border-bottom:1px solid #f1f5f9}
    .table-card .table tbody tr{transition:background .15s}
    .table-card .table tbody tr:hover{background:#f8fafc}

    /* Employee cell */
    .emp-name{font-weight:600;color:#1e293b;font-size:.85rem;display:block;line-height:1.3}
    .emp-dept{font-size:.74rem;color:#94a3b8}

    /* Leave-type badge */
    .lt-badge{display:inline-block;padding:.25rem .7rem;border-radius:20px;font-size:.74rem;font-weight:600;background:#ede9fe;color:#7c3aed}

    /* Status badges */
    .status-badge{display:inline-flex;align-items:center;gap:4px;padding:.28rem .72rem;border-radius:20px;font-size:.73rem;font-weight:600;text-transform:capitalize}
    .status-pending{background:#fef3c7;color:#92400e}
    .status-approved{background:#d1fae5;color:#065f46}
    .status-rejected{background:#ffe4e6;color:#9f1239}
    .status-cancelled{background:#f1f5f9;color:#64748b}

    /* Action buttons */
    .act-btn{border:none;padding:.35rem .7rem;border-radius:8px;font-size:.76rem;font-weight:600;cursor:pointer;transition:all .2s;display:inline-flex;align-items:center;gap:4px;font-family:'Inter',sans-serif}
    .act-approve{background:#d1fae5;color:#047857}
    .act-approve:hover{background:#059669;color:#fff}
    .act-reject{background:#ffe4e6;color:#be123c}
    .act-reject:hover{background:#e11d48;color:#fff}

    /* ── Modals ────────────────────────────────────────────── */
    .modal-content.lr-modal{border:none;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.18);overflow:hidden;font-family:'Inter',sans-serif}
    .lr-modal .modal-header{padding:1.25rem 1.5rem;border-bottom:1px solid #f1f5f9}
    .lr-modal .modal-title{font-size:1.05rem;font-weight:700;display:flex;align-items:center;gap:.5rem}
    .lr-modal .modal-body{padding:1.5rem}
    .lr-modal .modal-footer{padding:1rem 1.5rem;border-top:1px solid #f1f5f9;gap:.5rem}
    .lr-modal .btn-close{filter:none;opacity:.5}
    .lr-modal .btn-close:hover{opacity:1}
    .lr-modal .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:1.25rem}
    .lr-modal .detail-item{background:#f8fafc;border-radius:10px;padding:.7rem .9rem}
    .lr-modal .detail-item .d-label{font-size:.72rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.3px;margin-bottom:2px}
    .lr-modal .detail-item .d-value{font-size:.88rem;font-weight:600;color:#1e293b}
    .lr-modal textarea{border:1.5px solid #e2e8f0;border-radius:10px;font-family:'Inter',sans-serif;font-size:.85rem;padding:.7rem .9rem;resize:vertical;transition:border-color .2s,box-shadow .2s}
    .lr-modal textarea:focus{border-color:#818cf8;box-shadow:0 0 0 3px rgba(129,140,248,.18);outline:none}
    .lr-modal .modal-submit{border:none;padding:.55rem 1.5rem;border-radius:10px;font-size:.85rem;font-weight:600;cursor:pointer;transition:all .2s;font-family:'Inter',sans-serif;display:inline-flex;align-items:center;gap:.4rem}
    .lr-modal .modal-submit:hover{transform:translateY(-1px);box-shadow:0 4px 14px rgba(0,0,0,.12)}
    .submit-approve{background:#059669;color:#fff}
    .submit-approve:hover{background:#047857}
    .submit-reject{background:#e11d48;color:#fff}
    .submit-reject:hover{background:#be123c}
    .modal-cancel{background:#f1f5f9;color:#475569;border:none;padding:.55rem 1.2rem;border-radius:10px;font-size:.85rem;font-weight:600;cursor:pointer;transition:all .15s;font-family:'Inter',sans-serif}
    .modal-cancel:hover{background:#e2e8f0}

    /* ── Flash messages ────────────────────────────────────── */
    .lr-flash{border-radius:12px;padding:.85rem 1.25rem;font-size:.85rem;font-weight:500;display:flex;align-items:center;gap:.6rem;margin-bottom:1.25rem;animation:fadeUp .4s ease both}
    .lr-flash-success{background:#d1fae5;color:#065f46;border:1px solid #a7f3d0}
    .lr-flash-error{background:#ffe4e6;color:#9f1239;border:1px solid #fecdd3}

    /* ── Empty state ──────────────────────────────────────── */
    .empty-state{text-align:center;padding:3.5rem 1rem}
    .empty-state-icon{width:64px;height:64px;border-radius:50%;background:#f1f5f9;display:inline-flex;align-items:center;justify-content:center;font-size:1.7rem;color:#94a3b8;margin-bottom:1rem}
    .empty-state h4{font-size:1.05rem;font-weight:700;color:#475569;margin-bottom:.35rem}
    .empty-state p{font-size:.85rem;color:#94a3b8;margin:0}

    /* ── Pagination ────────────────────────────────────────── */
    .lr-pagination{display:flex;justify-content:center;padding:1.25rem}
    .lr-pagination nav{display:flex}
    .lr-pagination .pagination{gap:4px;margin:0}
    .lr-pagination .page-link{border:none;border-radius:8px;font-size:.82rem;font-weight:500;color:#475569;padding:.4rem .75rem;transition:all .2s;font-family:'Inter',sans-serif}
    .lr-pagination .page-link:hover{background:#ede9fe;color:#6366f1}
    .lr-pagination .page-item.active .page-link{background:linear-gradient(135deg,#6366f1,#818cf8);color:#fff;box-shadow:0 2px 8px rgba(99,102,241,.3)}
    .lr-pagination .page-item.disabled .page-link{color:#cbd5e1;background:transparent}

    /* ── Reason tooltip ────────────────────────────────────── */
    .reason-text{cursor:default;border-bottom:1px dashed #cbd5e1}

    /* ── Responsive ────────────────────────────────────────── */
    @media(max-width:768px){
        .stat-row{grid-template-columns:1fr}
        .table-card{overflow-x:auto}
        .lr-modal .detail-grid{grid-template-columns:1fr}
        .filter-bar{flex-direction:column;align-items:stretch}
    }
</style>

<div class="lr-wrap">
    <div class="container">

        {{-- ── Flash Messages ──────────────────────────────────── --}}
        @if(session('success'))
            <div class="lr-flash lr-flash-success">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="lr-flash lr-flash-error">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            </div>
        @endif

        {{-- ── Page Header ─────────────────────────────────────── --}}
        <div class="lr-header fade-up">
            <div class="lr-header-icon">
                <i class="bi bi-calendar2-week"></i>
            </div>
            <div>
                <h1>Team Leave Requests</h1>
                <p>Review and manage leave requests from your team members</p>
            </div>
        </div>

        {{-- ── Summary Stats ───────────────────────────────────── --}}
        <div class="stat-row fade-up fade-up-d1">
            <div class="stat-card stat-pending">
                <div class="stat-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Pending <span class="pulse-dot"></span></div>
                    <div class="stat-value">{{ $summary['pending'] ?? 0 }}</div>
                </div>
            </div>
            <div class="stat-card stat-approved">
                <div class="stat-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Approved</div>
                    <div class="stat-value">{{ $summary['approved'] ?? 0 }}</div>
                </div>
            </div>
            <div class="stat-card stat-rejected">
                <div class="stat-icon">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Rejected</div>
                    <div class="stat-value">{{ $summary['rejected'] ?? 0 }}</div>
                </div>
            </div>
        </div>

        {{-- ── Status Filter ───────────────────────────────────── --}}
        <div class="filter-bar fade-up fade-up-d2">
            <label for="statusFilter"><i class="bi bi-funnel"></i>&nbsp; Filter by Status</label>
            <form method="GET" action="{{ url()->current() }}" id="filterForm" style="margin:0">
                <select name="status" id="statusFilter" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="">All Requests</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </form>
        </div>

        {{-- ── Leave Table ─────────────────────────────────────── --}}
        <div class="table-card fade-up fade-up-d3">
            @if($leaveRequests->count())
                <table class="table table-borderless align-middle">
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
                            <th>Applied</th>
                            <th style="text-align:center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaveRequests as $index => $leaveRequest)
                            <tr>
                                <td style="font-weight:600;color:#94a3b8">{{ $leaveRequests->firstItem() + $index }}</td>
                                <td>
                                    <span class="emp-name">{{ $leaveRequest->employee->full_name }}</span>
                                    <span class="emp-dept">{{ $leaveRequest->employee->department->name }}</span>
                                </td>
                                <td><span class="lt-badge">{{ $leaveRequest->leaveType->name }}</span></td>
                                <td>{{ $leaveRequest->start_date->format('d M Y') }}</td>
                                <td>{{ $leaveRequest->end_date->format('d M Y') }}</td>
                                <td style="font-weight:700;color:#1e293b">{{ $leaveRequest->total_days }}</td>
                                <td>
                                    <span class="reason-text" title="{{ $leaveRequest->reason }}">
                                        {{ Str::limit($leaveRequest->reason, 30) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $leaveRequest->status }}">
                                        @if($leaveRequest->status === 'pending')
                                            <i class="bi bi-clock"></i>
                                        @elseif($leaveRequest->status === 'approved')
                                            <i class="bi bi-check-lg"></i>
                                        @elseif($leaveRequest->status === 'rejected')
                                            <i class="bi bi-x-lg"></i>
                                        @else
                                            <i class="bi bi-dash-lg"></i>
                                        @endif
                                        {{ $leaveRequest->status }}
                                    </span>
                                </td>
                                <td style="font-size:.8rem;color:#64748b">{{ $leaveRequest->created_at->format('d M Y') }}</td>
                                <td style="text-align:center">
                                    @if($leaveRequest->status === 'pending')
                                        <button class="act-btn act-approve" data-bs-toggle="modal" data-bs-target="#approveModal{{ $leaveRequest->id }}">
                                            <i class="bi bi-check-lg"></i> Approve
                                        </button>
                                        <button class="act-btn act-reject" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $leaveRequest->id }}">
                                            <i class="bi bi-x-lg"></i> Reject
                                        </button>
                                    @else
                                        <span style="font-size:.78rem;color:#cbd5e1">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- ── Pagination ──────────────────────────────────── --}}
                @if($leaveRequests->hasPages())
                    <div class="lr-pagination">
                        {{ $leaveRequests->withQueryString()->links() }}
                    </div>
                @endif
            @else
                {{-- ── Empty State ─────────────────────────────────── --}}
                <div class="empty-state fade-up">
                    <div class="empty-state-icon">
                        <i class="bi bi-calendar-x"></i>
                    </div>
                    <h4>No Leave Requests Found</h4>
                    <p>There are no leave requests matching your current filter.</p>
                </div>
            @endif
        </div>

    </div>{{-- .container --}}
</div>

{{-- ═══ MODALS — Outside table to avoid overflow clipping ═══ --}}
@foreach($leaveRequests as $leaveRequest)
    @if($leaveRequest->status === 'pending')
        {{-- Approve Modal --}}
        <div class="modal fade" id="approveModal{{ $leaveRequest->id }}" tabindex="-1" aria-hidden="true" style="z-index:1060;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content lr-modal">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-check-circle-fill" style="color:#059669"></i> Approve Leave Request
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('manager.leaves.update-status', $leaveRequest) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="approved">
                        <div class="modal-body">
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <div class="d-label">Employee</div>
                                    <div class="d-value">{{ $leaveRequest->employee->full_name }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="d-label">Leave Type</div>
                                    <div class="d-value">{{ $leaveRequest->leaveType->name }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="d-label">From</div>
                                    <div class="d-value">{{ $leaveRequest->start_date->format('d M Y') }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="d-label">To</div>
                                    <div class="d-value">{{ $leaveRequest->end_date->format('d M Y') }}</div>
                                </div>
                            </div>
                            <div style="margin-bottom:.25rem">
                                <label style="font-size:.82rem;font-weight:600;color:#475569;margin-bottom:.4rem;display:block">
                                    Remarks <span style="color:#94a3b8;font-weight:400">(optional)</span>
                                </label>
                                <textarea name="admin_remarks" rows="3" class="form-control" placeholder="Add any remarks or notes…" style="border:1.5px solid #e2e8f0;border-radius:10px;font-family:'Inter',sans-serif;font-size:.85rem;padding:.7rem .9rem"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="modal-cancel" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="modal-submit submit-approve">
                                <i class="bi bi-check-circle"></i> Approve Leave
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Reject Modal --}}
        <div class="modal fade" id="rejectModal{{ $leaveRequest->id }}" tabindex="-1" aria-hidden="true" style="z-index:1060;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content lr-modal">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-x-circle-fill" style="color:#e11d48"></i> Reject Leave Request
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('manager.leaves.update-status', $leaveRequest) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="rejected">
                        <div class="modal-body">
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <div class="d-label">Employee</div>
                                    <div class="d-value">{{ $leaveRequest->employee->full_name }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="d-label">Leave Type</div>
                                    <div class="d-value">{{ $leaveRequest->leaveType->name }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="d-label">From</div>
                                    <div class="d-value">{{ $leaveRequest->start_date->format('d M Y') }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="d-label">To</div>
                                    <div class="d-value">{{ $leaveRequest->end_date->format('d M Y') }}</div>
                                </div>
                            </div>
                            <div style="margin-bottom:.25rem">
                                <label style="font-size:.82rem;font-weight:600;color:#475569;margin-bottom:.4rem;display:block">
                                    Reason for Rejection <span style="color:#e11d48">*</span>
                                </label>
                                <textarea name="admin_remarks" rows="3" class="form-control" required placeholder="Please provide a reason for rejection…" style="border:1.5px solid #e2e8f0;border-radius:10px;font-family:'Inter',sans-serif;font-size:.85rem;padding:.7rem .9rem"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="modal-cancel" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="modal-submit submit-reject">
                                <i class="bi bi-x-circle"></i> Reject Leave
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach

@endsection
