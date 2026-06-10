@extends('layouts.app')

@section('content')
<style>
    .leaves-page{font-family:'Inter',sans-serif;}
    .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:16px}
    .page-header h1{font-size:1.5rem;font-weight:800;color:#1e1b4b;display:flex;align-items:center;gap:10px;margin:0}
    .page-header h1 .h-icon{width:42px;height:42px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;background:#eef2ff;color:#6366f1}

    .alert-box{padding:14px 18px;border-radius:14px;font-size:.88rem;margin-bottom:20px;display:flex;align-items:center;gap:10px;animation:slideIn .4s ease}
    .alert-success{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
    .alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
    @keyframes slideIn{from{opacity:0;transform:translateX(-10px)}to{opacity:1;transform:translateX(0)}}

    .balance-card{background:#fff;border-radius:16px;border:1px solid #f1f5f9;padding:22px;position:relative;overflow:hidden;transition:all .3s;height:100%}
    .balance-card:hover{transform:translateY(-4px);box-shadow:0 12px 40px rgba(0,0,0,.08)}
    .balance-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px}
    .balance-type{font-size:.88rem;font-weight:700;color:#1e293b}
    .balance-remaining{font-size:1.6rem;font-weight:800;line-height:1}
    .balance-remaining small{font-size:.7rem;font-weight:500;color:#94a3b8;display:block}
    .balance-bar{height:8px;background:#f1f5f9;border-radius:4px;overflow:hidden;margin-top:8px}
    .balance-fill{height:100%;border-radius:4px;transition:width 1s ease}
    .balance-meta{display:flex;justify-content:space-between;margin-top:8px;font-size:.75rem;color:#64748b;font-weight:500}
    .balance-bar-strip{position:absolute;bottom:0;left:0;right:0;height:4px;border-radius:0 0 16px 16px}

    .table-card{background:#fff;border-radius:20px;border:1px solid #f1f5f9;overflow:hidden;margin-top:24px}
    .table-card:hover{box-shadow:0 8px 30px rgba(0,0,0,.06)}
    .table-head{padding:20px 24px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #f1f5f9}
    .table-head h5{font-size:1rem;font-weight:700;color:#1e293b;margin:0;display:flex;align-items:center;gap:8px}
    .table-head h5 .t-icon{width:32px;height:32px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:.85rem;background:#eef2ff;color:#6366f1}
    .leave-table{width:100%;border-collapse:collapse}
    .leave-table th{padding:12px 18px;text-align:left;font-size:.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;background:#f8fafc;border-bottom:1px solid #f1f5f9}
    .leave-table td{padding:14px 18px;font-size:.85rem;color:#334155;border-bottom:1px solid #f8fafc;transition:background .2s}
    .leave-table tr:hover td{background:#fafafe}
    .leave-table tr:last-child td{border-bottom:none}
    .status-badge{padding:4px 12px;border-radius:20px;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px}
    .badge-pending{background:#fef3c7;color:#92400e}.badge-approved{background:#dcfce7;color:#166534}.badge-rejected{background:#fee2e2;color:#991b1b}.badge-cancelled{background:#f1f5f9;color:#475569}
    .reason-cell{max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#64748b;font-size:.82rem}
    .type-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:8px;font-size:.78rem;font-weight:600;background:#f1f5f9;color:#475569}

    .pagination-wrap{padding:16px 24px;display:flex;justify-content:center}
    .pagination-wrap .pagination{display:flex;gap:4px;list-style:none;padding:0;margin:0}
    .pagination-wrap .page-link{padding:8px 14px;border-radius:10px;border:1px solid #e5e7eb;color:#6366f1;font-weight:600;font-size:.82rem;text-decoration:none;transition:all .2s}
    .pagination-wrap .page-link:hover{background:#eef2ff;border-color:#c7d2fe}
    .pagination-wrap .page-item.active .page-link{background:#6366f1;color:#fff;border-color:#6366f1}
    .pagination-wrap .page-item.disabled .page-link{color:#d1d5db;pointer-events:none}

    .empty-state{text-align:center;padding:48px 20px}
    .empty-state i{font-size:3rem;color:#e2e8f0}
    .empty-state p{color:#94a3b8;font-size:.9rem;margin-top:8px}

    .fade-up{opacity:0;transform:translateY(20px);animation:fadeUp .5s ease forwards}
    @keyframes fadeUp{to{opacity:1;transform:translateY(0)}}
    .fade-up:nth-child(1){animation-delay:.05s}.fade-up:nth-child(2){animation-delay:.1s}.fade-up:nth-child(3){animation-delay:.15s}.fade-up:nth-child(4){animation-delay:.2s}.fade-up:nth-child(5){animation-delay:.25s}

    @media(max-width:768px){
        .page-header{flex-direction:column;align-items:flex-start}
        .leave-table th,.leave-table td{padding:10px 12px;font-size:.78rem}
        .reason-cell{max-width:100px}
    }
</style>

<div class="leaves-page">
    @if(session('success'))
        <div class="alert-box alert-success"><i class="bi bi-check-circle-fill" style="font-size:1.2rem"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-box alert-error"><i class="bi bi-exclamation-circle-fill" style="font-size:1.2rem"></i>{{ session('error') }}</div>
    @endif

    <div class="page-header fade-up">
        <h1><span class="h-icon"><i class="bi bi-calendar2-check-fill"></i></span> My Leaves</h1>
    </div>

    {{-- Leave Balance Cards --}}
    @php
        $bColors = ['#6366f1','#10b981','#f59e0b','#06b6d4','#f43f5e','#8b5cf6','#ec4899','#14b8a6'];
    @endphp
    <div class="row g-3 mb-3">
        @foreach($leaveBalances as $i => $bal)
            @php
                $color = $bColors[$i % count($bColors)];
                $pct = $bal['total'] > 0 ? round(($bal['used'] / $bal['total']) * 100) : 0;
            @endphp
            <div class="col-6 col-lg-3 fade-up">
                <div class="balance-card">
                    <div class="balance-top">
                        <span class="balance-type"><i class="bi bi-bookmark-fill me-1" style="color:{{ $color }}"></i>{{ $bal['type']->name }}</span>
                        <div class="balance-remaining" style="color:{{ $color }}">{{ $bal['remaining'] }}<small>remaining</small></div>
                    </div>
                    <div class="balance-bar">
                        <div class="balance-fill" style="width:{{ $pct }}%;background:{{ $color }}"></div>
                    </div>
                    <div class="balance-meta">
                        <span>Used: {{ $bal['used'] }}</span>
                        <span>Total: {{ $bal['total'] }}</span>
                    </div>
                    <div class="balance-bar-strip" style="background:linear-gradient(90deg,{{ $color }},{{ $color }}88)"></div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Leave Requests Table --}}
    <div class="table-card fade-up">
        <div class="table-head">
            <h5><span class="t-icon"><i class="bi bi-list-check"></i></span> Leave Requests</h5>
            <span style="font-size:.82rem;color:#94a3b8;font-weight:500">{{ $leaveRequests->total() }} total</span>
        </div>
        @if($leaveRequests->count())
            <div style="overflow-x:auto;">
                <table class="leave-table">
                    <thead>
                        <tr>
                            <th>Leave Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Days</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Applied</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaveRequests as $lr)
                        <tr>
                            <td><span class="type-badge"><i class="bi bi-bookmark-fill" style="font-size:.65rem;color:#6366f1"></i>{{ $lr->leaveType->name }}</span></td>
                            <td style="font-weight:600">{{ $lr->start_date->format('d M Y') }}</td>
                            <td style="font-weight:600">{{ $lr->end_date->format('d M Y') }}</td>
                            <td><strong>{{ $lr->total_days }}</strong></td>
                            <td class="reason-cell" title="{{ $lr->reason }}">{{ Str::limit($lr->reason, 30) }}</td>
                            <td><span class="status-badge badge-{{ $lr->status }}">{{ $lr->status }}</span></td>
                            <td style="color:#94a3b8;font-size:.82rem">{{ $lr->created_at->format('d M') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($leaveRequests->hasPages())
                <div class="pagination-wrap">{{ $leaveRequests->links() }}</div>
            @endif
        @else
            <div class="empty-state">
                <i class="bi bi-calendar-x"></i>
                <p>No leave requests found.</p>
            </div>
        @endif
    </div>
</div>
@endsection
