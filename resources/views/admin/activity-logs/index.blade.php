@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .al-wrapper {
        font-family: 'Inter', sans-serif;
        padding: 32px 0;
        min-height: 80vh;
        background: #f8f9fc;
    }

    /* ── Flash Messages ── */
    .al-flash {
        padding: 14px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: alFadeUp 0.5s ease both;
    }
    .al-flash-success {
        background: #e8f8ef;
        color: #1a7d42;
        border: 1px solid #b8e6cb;
    }
    .al-flash-error {
        background: #fde8e8;
        color: #b91c1c;
        border: 1px solid #f5c6c6;
    }

    /* ── Page Header ── */
    .al-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        animation: alFadeUp 0.4s ease both;
    }
    .al-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .al-header-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 22px;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
    }
    .al-header h1 {
        font-size: 26px;
        font-weight: 700;
        color: #1e1b4b;
        margin: 0;
        letter-spacing: -0.5px;
    }
    .al-header p {
        font-size: 13px;
        color: #6b7280;
        margin: 2px 0 0;
    }
    .al-btn-clear {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);
    }
    .al-btn-clear:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    /* ── Filter Card ── */
    .al-filter-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px 28px;
        margin-bottom: 24px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.03);
        border: 1px solid #e9ecf2;
        animation: alFadeUp 0.5s ease both;
        animation-delay: 0.05s;
    }
    .al-filter-row {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    .al-filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1;
        min-width: 170px;
    }
    .al-filter-group label {
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .al-filter-group select,
    .al-filter-group input {
        padding: 10px 14px;
        border: 1.5px solid #e2e5ed;
        border-radius: 10px;
        font-size: 13.5px;
        font-family: 'Inter', sans-serif;
        color: #1e1b4b;
        background: #f9fafb;
        transition: all 0.2s ease;
        outline: none;
        width: 100%;
        box-sizing: border-box;
    }
    .al-filter-group select:focus,
    .al-filter-group input:focus {
        border-color: #6366f1;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .al-filter-actions {
        display: flex;
        gap: 8px;
        align-items: flex-end;
        padding-bottom: 1px;
    }
    .al-btn-filter {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 20px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 3px 10px rgba(99, 102, 241, 0.25);
        white-space: nowrap;
    }
    .al-btn-filter:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(99, 102, 241, 0.35);
    }
    .al-btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 18px;
        background: #fff;
        color: #6b7280;
        border: 1.5px solid #e2e5ed;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        white-space: nowrap;
    }
    .al-btn-reset:hover {
        background: #f3f4f6;
        color: #374151;
        border-color: #d1d5db;
    }

    /* ── Table Card ── */
    .al-table-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.03);
        border: 1px solid #e9ecf2;
        animation: alFadeUp 0.5s ease both;
        animation-delay: 0.1s;
    }
    .al-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 28px;
        border-bottom: 1px solid #f0f1f5;
    }
    .al-table-header h3 {
        font-size: 15px;
        font-weight: 600;
        color: #1e1b4b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .al-count-badge {
        background: #eef2ff;
        color: #6366f1;
        font-size: 12px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
    }
    .al-table-wrap {
        overflow-x: auto;
    }
    .al-table {
        width: 100%;
        border-collapse: collapse;
    }
    .al-table thead th {
        padding: 14px 20px;
        font-size: 11.5px;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        border-bottom: 1px solid #f0f1f5;
        background: #fafafc;
        text-align: left;
        white-space: nowrap;
    }
    .al-table tbody tr {
        transition: background 0.15s ease;
    }
    .al-table tbody tr:hover {
        background: #f8f9ff;
    }
    .al-table tbody td {
        padding: 16px 20px;
        font-size: 13.5px;
        color: #374151;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    .al-table tbody tr:last-child td {
        border-bottom: none;
    }
    .al-num {
        color: #9ca3af;
        font-weight: 600;
        font-size: 12.5px;
    }

    /* User cell */
    .al-user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .al-user-avatar {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }
    .al-user-avatar.system {
        background: linear-gradient(135deg, #94a3b8, #64748b);
    }
    .al-user-name {
        font-weight: 600;
        color: #1e1b4b;
        font-size: 13.5px;
    }

    /* Action badges */
    .al-action-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }
    .al-badge-created {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }
    .al-badge-updated {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }
    .al-badge-deleted {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .al-badge-default {
        background: #f3f4f6;
        color: #6b7280;
        border: 1px solid #e5e7eb;
    }

    /* Subject cell */
    .al-subject-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        background: #f3f4f6;
        border-radius: 7px;
        font-size: 12.5px;
        color: #4b5563;
        font-weight: 500;
    }
    .al-subject-tag i {
        font-size: 12px;
        color: #9ca3af;
    }

    /* Changes toggle */
    .al-changes-toggle {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        background: #eef2ff;
        color: #6366f1;
        border: 1px solid #c7d2fe;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all 0.2s ease;
    }
    .al-changes-toggle:hover {
        background: #e0e7ff;
        border-color: #a5b4fc;
    }
    .al-changes-toggle i {
        transition: transform 0.3s ease;
    }
    .al-changes-toggle.active i {
        transform: rotate(180deg);
    }
    .al-no-changes {
        color: #9ca3af;
        font-size: 12.5px;
        font-style: italic;
    }

    /* Changes detail row */
    .al-changes-row td {
        padding: 0 !important;
        border-bottom: 1px solid #f3f4f6 !important;
    }
    .al-changes-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease, padding 0.3s ease;
    }
    .al-changes-content.open {
        max-height: 600px;
        padding: 16px 24px 20px;
    }
    .al-diff-table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e9ecf2;
        font-size: 13px;
    }
    .al-diff-table thead th {
        padding: 10px 16px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        background: #f8f9fc;
        color: #6b7280;
        border-bottom: 1px solid #e9ecf2;
        text-align: left;
    }
    .al-diff-table tbody td {
        padding: 10px 16px;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: top;
        word-break: break-word;
    }
    .al-diff-table tbody tr:last-child td {
        border-bottom: none;
    }
    .al-diff-field {
        font-weight: 600;
        color: #4b5563;
    }
    .al-diff-old {
        background: #fef2f2;
        color: #b91c1c;
        padding: 3px 8px;
        border-radius: 5px;
        font-size: 12.5px;
        display: inline-block;
        max-width: 260px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .al-diff-new {
        background: #ecfdf5;
        color: #047857;
        padding: 3px 8px;
        border-radius: 5px;
        font-size: 12.5px;
        display: inline-block;
        max-width: 260px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Date cell */
    .al-date-main {
        font-weight: 600;
        color: #374151;
        font-size: 13px;
    }
    .al-date-sub {
        color: #9ca3af;
        font-size: 11.5px;
        margin-top: 2px;
    }

    /* ── Empty State ── */
    .al-empty {
        text-align: center;
        padding: 60px 20px;
    }
    .al-empty-icon {
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        color: #6366f1;
        margin-bottom: 18px;
    }
    .al-empty h4 {
        font-size: 17px;
        font-weight: 700;
        color: #1e1b4b;
        margin: 0 0 6px;
    }
    .al-empty p {
        font-size: 13.5px;
        color: #9ca3af;
        margin: 0;
    }

    /* ── Pagination ── */
    .al-pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 28px;
        border-top: 1px solid #f0f1f5;
    }
    .al-pagination-info {
        font-size: 13px;
        color: #6b7280;
    }
    .al-pagination-links {
        display: flex;
        gap: 4px;
    }
    .al-pagination-links .page-item .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        background: #fff;
        border: 1.5px solid #e2e5ed;
        text-decoration: none;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
    }
    .al-pagination-links .page-item .page-link:hover {
        background: #eef2ff;
        border-color: #c7d2fe;
        color: #6366f1;
    }
    .al-pagination-links .page-item.active .page-link {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 3px 10px rgba(99, 102, 241, 0.3);
    }
    .al-pagination-links .page-item.disabled .page-link {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* ── Modal ── */
    .al-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 15, 35, 0.5);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        animation: alFadeIn 0.25s ease;
    }
    .al-modal-overlay.active {
        display: flex;
    }
    .al-modal {
        background: #fff;
        border-radius: 20px;
        width: 100%;
        max-width: 460px;
        padding: 32px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        animation: alScaleIn 0.3s ease;
    }
    .al-modal-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #dc2626;
        margin-bottom: 20px;
    }
    .al-modal h3 {
        font-size: 20px;
        font-weight: 700;
        color: #1e1b4b;
        margin: 0 0 8px;
    }
    .al-modal p {
        font-size: 13.5px;
        color: #6b7280;
        line-height: 1.6;
        margin: 0 0 24px;
    }
    .al-modal-field {
        margin-bottom: 24px;
    }
    .al-modal-field label {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    .al-modal-field input {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #e2e5ed;
        border-radius: 12px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        color: #1e1b4b;
        background: #f9fafb;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .al-modal-field input:focus {
        border-color: #ef4444;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    .al-modal-warning {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px 16px;
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 12.5px;
        color: #92400e;
        line-height: 1.5;
    }
    .al-modal-warning i {
        font-size: 16px;
        color: #f59e0b;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .al-modal-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }
    .al-btn-cancel {
        padding: 10px 22px;
        background: #fff;
        color: #6b7280;
        border: 1.5px solid #e2e5ed;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .al-btn-cancel:hover {
        background: #f3f4f6;
        color: #374151;
    }
    .al-btn-delete {
        padding: 10px 22px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 3px 10px rgba(239, 68, 68, 0.25);
    }
    .al-btn-delete:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(239, 68, 68, 0.35);
    }

    /* ── Animations ── */
    @keyframes alFadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes alFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes alScaleIn {
        from { opacity: 0; transform: scale(0.92); }
        to { opacity: 1; transform: scale(1); }
    }

    .al-fade-row {
        animation: alFadeUp 0.4s ease both;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .al-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
        .al-filter-row {
            flex-direction: column;
        }
        .al-filter-group {
            min-width: 100%;
        }
        .al-pagination {
            flex-direction: column;
            gap: 14px;
        }
    }
</style>

<div class="al-wrapper">
    <div class="container">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="al-flash al-flash-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="al-flash al-flash-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Page Header --}}
        <div class="al-header">
            <div class="al-header-left">
                <div class="al-header-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <h1>Activity Logs</h1>
                    <p>Track all system actions and changes</p>
                </div>
            </div>
            <button type="button" class="al-btn-clear" onclick="document.getElementById('alClearModal').classList.add('active')">
                <i class="bi bi-trash3"></i>
                Clear Old Logs
            </button>
        </div>

        {{-- Filters --}}
        <div class="al-filter-card">
            <form method="GET" action="{{ url()->current() }}">
                <div class="al-filter-row">
                    <div class="al-filter-group">
                        <label>User</label>
                        <select name="user_id">
                            <option value="">All Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="al-filter-group">
                        <label>Log Name</label>
                        <select name="log_name">
                            <option value="">All Logs</option>
                            @foreach($logNames as $name)
                                <option value="{{ $name }}" {{ request('log_name') == $name ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $name)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="al-filter-group">
                        <label>Date From</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}">
                    </div>
                    <div class="al-filter-group">
                        <label>Date To</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}">
                    </div>
                    <div class="al-filter-group">
                        <label>Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search logs...">
                    </div>
                    <div class="al-filter-actions">
                        <button type="submit" class="al-btn-filter">
                            <i class="bi bi-funnel"></i>
                            Filter
                        </button>
                        <a href="{{ url()->current() }}" class="al-btn-reset">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Activity Table --}}
        <div class="al-table-card">
            <div class="al-table-header">
                <h3>
                    <i class="bi bi-list-ul" style="color: #6366f1;"></i>
                    Log Entries
                    <span class="al-count-badge">{{ $activities->total() }}</span>
                </h3>
            </div>

            @if($activities->count())
                <div class="al-table-wrap">
                    <table class="al-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Subject</th>
                                <th>Changes</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activities as $index => $activity)
                                @php
                                    $colors = ['#6366f1','#8b5cf6','#ec4899','#f59e0b','#10b981','#3b82f6','#ef4444','#14b8a6'];
                                    $causerName = $activity->causer ? $activity->causer->name : 'System';
                                    $initials = $activity->causer
                                        ? strtoupper(collect(explode(' ', $activity->causer->name))->map(fn($w) => $w[0] ?? '')->take(2)->join(''))
                                        : 'SYS';
                                    $avatarColor = $activity->causer
                                        ? $colors[$activity->causer->id % count($colors)]
                                        : null;
                                    $desc = strtolower($activity->description);
                                    $badgeClass = match(true) {
                                        str_contains($desc, 'created') => 'al-badge-created',
                                        str_contains($desc, 'updated') => 'al-badge-updated',
                                        str_contains($desc, 'deleted') => 'al-badge-deleted',
                                        default => 'al-badge-default',
                                    };
                                    $props = $activity->properties;
                                    $oldVals = $props['old'] ?? [];
                                    $newVals = $props['attributes'] ?? [];
                                    $hasChanges = !empty($oldVals) || !empty($newVals);
                                    $subjectLabel = ucfirst(str_replace('_', ' ', $activity->log_name));
                                    $rowId = 'al-row-' . $activity->id;
                                @endphp
                                <tr class="al-fade-row" style="animation-delay: {{ $index * 0.03 }}s;">
                                    <td><span class="al-num">{{ $activities->firstItem() + $index }}</span></td>
                                    <td>
                                        <div class="al-user-cell">
                                            <div class="al-user-avatar {{ !$activity->causer ? 'system' : '' }}"
                                                 style="{{ $activity->causer ? 'background: linear-gradient(135deg, '.$avatarColor.', '.$avatarColor.'dd)' : '' }}">
                                                {{ $initials }}
                                            </div>
                                            <span class="al-user-name">{{ $causerName }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="al-action-badge {{ $badgeClass }}">
                                            @if(str_contains($desc, 'created'))
                                                <i class="bi bi-plus-circle-fill"></i>
                                            @elseif(str_contains($desc, 'updated'))
                                                <i class="bi bi-pencil-fill"></i>
                                            @elseif(str_contains($desc, 'deleted'))
                                                <i class="bi bi-trash-fill"></i>
                                            @else
                                                <i class="bi bi-activity"></i>
                                            @endif
                                            {{ $activity->description }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="al-subject-tag">
                                            <i class="bi bi-tag"></i>
                                            {{ $subjectLabel }}
                                            @if($activity->subject_id)
                                                #{{ $activity->subject_id }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        @if($hasChanges)
                                            <button type="button" class="al-changes-toggle" onclick="toggleChanges('{{ $rowId }}', this)">
                                                <i class="bi bi-chevron-down"></i>
                                                View Changes
                                            </button>
                                        @else
                                            <span class="al-no-changes">No changes</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="al-date-main">{{ $activity->created_at->format('M d, Y') }}</div>
                                        <div class="al-date-sub">{{ $activity->created_at->format('h:i A') }}</div>
                                    </td>
                                </tr>
                                @if($hasChanges)
                                    <tr class="al-changes-row">
                                        <td colspan="6">
                                            <div class="al-changes-content" id="{{ $rowId }}">
                                                <table class="al-diff-table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 25%;">Field</th>
                                                            <th style="width: 37.5%;">Old Value</th>
                                                            <th style="width: 37.5%;">New Value</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $allKeys = collect(array_keys($oldVals))->merge(array_keys($newVals))->unique();
                                                        @endphp
                                                        @foreach($allKeys as $field)
                                                            <tr>
                                                                <td class="al-diff-field">{{ ucfirst(str_replace('_', ' ', $field)) }}</td>
                                                                <td>
                                                                    @if(isset($oldVals[$field]))
                                                                        <span class="al-diff-old">{{ is_array($oldVals[$field]) ? json_encode($oldVals[$field]) : $oldVals[$field] }}</span>
                                                                    @else
                                                                        <span style="color: #d1d5db; font-style: italic; font-size: 12.5px;">—</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if(isset($newVals[$field]))
                                                                        <span class="al-diff-new">{{ is_array($newVals[$field]) ? json_encode($newVals[$field]) : $newVals[$field] }}</span>
                                                                    @else
                                                                        <span style="color: #d1d5db; font-style: italic; font-size: 12.5px;">—</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($activities->hasPages())
                    <div class="al-pagination">
                        <div class="al-pagination-info">
                            Showing {{ $activities->firstItem() }}–{{ $activities->lastItem() }} of {{ $activities->total() }} entries
                        </div>
                        <div class="al-pagination-links">
                            {{ $activities->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="al-empty">
                    <div class="al-empty-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h4>No Activity Logs Found</h4>
                    <p>There are no logs matching your current filters.</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Clear Logs Modal --}}
<div class="al-modal-overlay" id="alClearModal">
    <div class="al-modal">
        <div class="al-modal-icon">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <h3>Clear Old Logs</h3>
        <p>Permanently remove activity log entries older than a specified number of days. This action cannot be undone.</p>
        <form method="POST" action="{{ route('admin.activity-logs.clear') }}">
            @csrf
            <div class="al-modal-field">
                <label for="alClearDays">Days to Keep</label>
                <input type="number" name="days" id="alClearDays" min="1" max="365" placeholder="e.g. 30" required>
            </div>
            <div class="al-modal-warning">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>All activity log entries older than the specified number of days will be permanently deleted. Make sure you have exported any important records before proceeding.</span>
            </div>
            <div class="al-modal-actions">
                <button type="button" class="al-btn-cancel" onclick="document.getElementById('alClearModal').classList.remove('active')">
                    Cancel
                </button>
                <button type="submit" class="al-btn-delete">
                    <i class="bi bi-trash3"></i>
                    Clear Logs
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleChanges(id, btn) {
        const el = document.getElementById(id);
        if (el) {
            el.classList.toggle('open');
            btn.classList.toggle('active');
            btn.querySelector('span') || null;
            const label = el.classList.contains('open') ? 'Hide Changes' : 'View Changes';
            btn.childNodes.forEach(n => {
                if (n.nodeType === 3 && n.textContent.trim()) {
                    n.textContent = '\n                                ' + label + '\n                            ';
                }
            });
        }
    }

    // Close modal on overlay click
    document.getElementById('alClearModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
        }
    });

    // Close modal on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('alClearModal').classList.remove('active');
        }
    });
</script>
@endsection
