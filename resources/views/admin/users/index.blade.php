@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .usr-page {
        font-family: 'Inter', sans-serif;
        padding: 2rem 0 4rem;
        min-height: 100vh;
        background: #f1f5f9;
    }

    /* ── Fade-up animation ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up {
        animation: fadeUp .5s cubic-bezier(.22,1,.36,1) both;
    }
    .fade-up-d1 { animation-delay: .07s; }
    .fade-up-d2 { animation-delay: .14s; }
    .fade-up-d3 { animation-delay: .21s; }

    /* ── Page header ── */
    .usr-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .usr-header-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -.025em;
        margin: 0;
    }
    .usr-header-title i {
        color: #6366f1;
        margin-right: .5rem;
        font-size: 1.5rem;
    }
    .btn-add-usr {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .65rem 1.5rem;
        font-size: .875rem;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
        border: none;
        border-radius: .625rem;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(99,102,241,.35);
        transition: all .25s ease;
        cursor: pointer;
    }
    .btn-add-usr:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99,102,241,.45);
        color: #fff;
        text-decoration: none;
    }

    /* ── Flash messages ── */
    .usr-flash {
        padding: .85rem 1.25rem;
        border-radius: .625rem;
        font-size: .875rem;
        font-weight: 500;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .usr-flash-success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .usr-flash-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* ── Card ── */
    .usr-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 14px rgba(0,0,0,.04);
        overflow: hidden;
    }

    /* ── Filter bar ── */
    .usr-filter-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .75rem;
        padding: 1.125rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        background: #fafbfc;
    }
    .usr-filter-header h6 {
        margin: 0;
        font-weight: 700;
        font-size: .9rem;
        color: #334155;
    }
    .usr-filter-form {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
        align-items: center;
    }
    .usr-filter-input,
    .usr-filter-select {
        padding: .5rem 1rem;
        font-size: .8125rem;
        font-family: 'Inter', sans-serif;
        border: 1px solid #e2e8f0;
        border-radius: .5rem;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        color: #334155;
        background: #fff;
    }
    .usr-filter-input {
        min-width: 240px;
    }
    .usr-filter-select {
        min-width: 160px;
        cursor: pointer;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .75rem center;
        padding-right: 2.25rem;
    }
    .usr-filter-input::placeholder {
        color: #94a3b8;
    }
    .usr-filter-input:focus,
    .usr-filter-select:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
    }
    .usr-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .5rem 1rem;
        font-size: .8125rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        color: #6366f1;
        background: #eef2ff;
        border: 1px solid #c7d2fe;
        border-radius: .5rem;
        cursor: pointer;
        transition: all .2s;
    }
    .usr-filter-btn:hover {
        background: #e0e7ff;
    }
    .usr-clear-btn {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .5rem .85rem;
        font-size: .8125rem;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        color: #64748b;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .5rem;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
    }
    .usr-clear-btn:hover {
        background: #f8fafc;
        color: #475569;
        text-decoration: none;
    }

    /* ── Table ── */
    .usr-table {
        width: 100%;
        border-collapse: collapse;
    }
    .usr-table thead th {
        padding: .85rem 1.25rem;
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .usr-table tbody tr {
        transition: background .2s;
    }
    .usr-table tbody tr:hover {
        background: #f8fafc;
    }
    .usr-table tbody td {
        padding: .85rem 1.25rem;
        font-size: .8125rem;
        color: #475569;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .usr-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* ── User cell ── */
    .usr-cell {
        display: flex;
        align-items: center;
        gap: .75rem;
    }
    .usr-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: .8rem;
        color: #fff;
        flex-shrink: 0;
        letter-spacing: .02em;
    }
    .usr-avatar-admin { background: linear-gradient(135deg, #6366f1, #818cf8); }
    .usr-avatar-manager { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
    .usr-avatar-employee { background: linear-gradient(135deg, #059669, #34d399); }
    .usr-avatar-default { background: linear-gradient(135deg, #64748b, #94a3b8); }
    .usr-info-name {
        font-weight: 700;
        color: #1e293b;
        font-size: .8125rem;
        line-height: 1.3;
    }
    .usr-info-email {
        font-size: .75rem;
        color: #94a3b8;
        line-height: 1.3;
    }

    /* ── Role badges ── */
    .usr-role-badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .25rem .65rem;
        font-size: .7rem;
        font-weight: 600;
        border-radius: 9999px;
        white-space: nowrap;
        margin: .1rem;
    }
    .usr-role-admin {
        background: #eef2ff;
        color: #4f46e5;
        border: 1px solid #c7d2fe;
    }
    .usr-role-manager {
        background: #f5f3ff;
        color: #7c3aed;
        border: 1px solid #ddd6fe;
    }
    .usr-role-employee {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }
    .usr-role-default {
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    /* ── Status badge ── */
    .usr-status {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-size: .75rem;
        font-weight: 600;
    }
    .usr-status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .usr-status-active .usr-status-dot {
        background: #22c55e;
        box-shadow: 0 0 0 3px rgba(34,197,94,.2);
    }
    .usr-status-active {
        color: #16a34a;
    }
    .usr-status-inactive .usr-status-dot {
        background: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,.2);
    }
    .usr-status-inactive {
        color: #dc2626;
    }

    /* ── Actions ── */
    .usr-actions {
        display: flex;
        align-items: center;
        gap: .35rem;
        flex-wrap: nowrap;
    }
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        font-size: .85rem;
        border-radius: .5rem;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
        padding: 0;
    }
    .btn-action-edit {
        color: #6366f1;
        background: #eef2ff;
        border-color: #e0e7ff;
    }
    .btn-action-edit:hover {
        background: #e0e7ff;
        color: #4f46e5;
        transform: translateY(-1px);
    }
    .btn-action-toggle {
        color: #f59e0b;
        background: #fffbeb;
        border-color: #fde68a;
    }
    .btn-action-toggle:hover {
        background: #fef3c7;
        color: #d97706;
        transform: translateY(-1px);
    }
    .btn-action-reset {
        color: #0ea5e9;
        background: #f0f9ff;
        border-color: #bae6fd;
    }
    .btn-action-reset:hover {
        background: #e0f2fe;
        color: #0284c7;
        transform: translateY(-1px);
    }
    .btn-action-delete {
        color: #ef4444;
        background: #fef2f2;
        border-color: #fecaca;
    }
    .btn-action-delete:hover {
        background: #fee2e2;
        color: #dc2626;
        transform: translateY(-1px);
    }

    /* ── Empty state ── */
    .usr-empty {
        padding: 3.5rem 1rem;
        text-align: center;
    }
    .usr-empty-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        color: #6366f1;
        margin-bottom: 1rem;
    }
    .usr-empty h5 {
        font-size: 1rem;
        font-weight: 700;
        color: #334155;
        margin: 0 0 .35rem;
    }
    .usr-empty p {
        font-size: .8125rem;
        color: #94a3b8;
        margin: 0;
    }

    /* ── Pagination ── */
    .usr-pagination {
        padding: 1rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .75rem;
    }
    .usr-pagination-info {
        font-size: .775rem;
        color: #94a3b8;
        font-weight: 500;
    }
    .usr-pagination .pagination {
        margin: 0;
        gap: .25rem;
    }

    /* ── Row serial number ── */
    .row-num {
        font-weight: 600;
        color: #94a3b8;
        font-size: .75rem;
    }

    /* ── Date cell ── */
    .usr-date {
        font-size: .78rem;
        color: #64748b;
        white-space: nowrap;
    }

    /* ── Modal overlay ── */
    .usr-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, .55);
        backdrop-filter: blur(4px);
        z-index: 1060;
        justify-content: center;
        align-items: center;
        padding: 1rem;
    }
    .usr-modal-overlay.active {
        display: flex;
    }
    .usr-modal {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 25px 60px rgba(0,0,0,.15);
        width: 100%;
        max-width: 440px;
        animation: fadeUp .35s cubic-bezier(.22,1,.36,1) both;
        overflow: hidden;
    }
    .usr-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .usr-modal-header h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .usr-modal-close {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .2s;
        font-size: .9rem;
        font-family: 'Inter', sans-serif;
    }
    .usr-modal-close:hover {
        background: #fef2f2;
        border-color: #fecaca;
        color: #ef4444;
    }
    .usr-modal-body {
        padding: 1.5rem;
    }
    .usr-modal-label {
        font-size: .8rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: .4rem;
        display: block;
    }
    .usr-modal-input {
        width: 100%;
        padding: .6rem 1rem;
        font-size: .8125rem;
        font-family: 'Inter', sans-serif;
        border: 1px solid #e2e8f0;
        border-radius: .5rem;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        color: #334155;
        background: #fff;
        margin-bottom: 1rem;
        box-sizing: border-box;
    }
    .usr-modal-input:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
    }
    .usr-modal-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: .5rem;
        padding: 1rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        background: #fafbfc;
    }
    .usr-modal-cancel {
        padding: .55rem 1.25rem;
        font-size: .8125rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        color: #64748b;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .5rem;
        cursor: pointer;
        transition: all .2s;
    }
    .usr-modal-cancel:hover {
        background: #f8fafc;
        color: #475569;
    }
    .usr-modal-submit {
        padding: .55rem 1.25rem;
        font-size: .8125rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        color: #fff;
        background: linear-gradient(135deg, #6366f1, #818cf8);
        border: none;
        border-radius: .5rem;
        cursor: pointer;
        transition: all .25s;
        box-shadow: 0 2px 8px rgba(99,102,241,.3);
    }
    .usr-modal-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(99,102,241,.4);
    }

    /* ── Validation errors in modal ── */
    .usr-modal-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
        border-radius: .5rem;
        padding: .6rem 1rem;
        font-size: .78rem;
        margin-bottom: 1rem;
    }
    .usr-modal-error ul {
        margin: 0;
        padding-left: 1.1rem;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .usr-header { flex-direction: column; align-items: flex-start; }
        .usr-filter-form { width: 100%; flex-direction: column; }
        .usr-filter-input,
        .usr-filter-select { min-width: 0; width: 100%; }
        .usr-table thead { display: none; }
        .usr-table tbody tr {
            display: block;
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .usr-table tbody td {
            display: flex;
            justify-content: space-between;
            padding: .4rem 0;
            border: none;
        }
        .usr-table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            color: #64748b;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .usr-actions {
            flex-wrap: wrap;
        }
        .usr-modal {
            max-width: 100%;
        }
    }
</style>

<div class="usr-page">
    <div class="container">

        {{-- ── Flash Messages ── --}}
        @if(session('success'))
            <div class="usr-flash usr-flash-success fade-up">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="usr-flash usr-flash-error fade-up">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- ── Page Header ── --}}
        <div class="usr-header fade-up">
            <h1 class="usr-header-title">
                <i class="bi bi-person-gear"></i>Users
            </h1>
            <a href="{{ route('admin.users.create') }}" class="btn-add-usr">
                <i class="bi bi-plus-lg"></i>
                Add User
            </a>
        </div>

        {{-- ── Main Card ── --}}
        <div class="usr-card fade-up fade-up-d1">

            {{-- Filter Header --}}
            <div class="usr-filter-header">
                <h6><i class="bi bi-funnel-fill" style="margin-right:.4rem;color:#6366f1;"></i>Filter Users</h6>
                <form action="{{ route('admin.users.index') }}" method="GET" class="usr-filter-form">
                    <input
                        type="text"
                        name="search"
                        class="usr-filter-input"
                        placeholder="Search by name or email…"
                        value="{{ request('search') }}"
                    />
                    <select name="role" class="usr-filter-select">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="usr-filter-btn">
                        <i class="bi bi-search"></i> Search
                    </button>
                    @if(request('search') || request('role'))
                        <a href="{{ route('admin.users.index') }}" class="usr-clear-btn">
                            <i class="bi bi-x-lg"></i> Clear
                        </a>
                    @endif
                </form>
            </div>

            {{-- Table --}}
            @if($users->count())
                <div style="overflow-x:auto;">
                    <table class="usr-table">
                        <thead>
                            <tr>
                                <th style="width:50px;">#</th>
                                <th>User</th>
                                <th>Role</th>
                                <th style="text-align:center;">Status</th>
                                <th>Created</th>
                                <th style="text-align:center;width:160px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                                @php
                                    $userRoles = $user->roles->pluck('name');
                                    $primaryRole = $userRoles->first() ?? 'default';
                                    $initials = strtoupper(collect(explode(' ', $user->name))->map(fn($w) => substr($w, 0, 1))->take(2)->join(''));
                                    $avatarClass = match($primaryRole) {
                                        'admin' => 'usr-avatar-admin',
                                        'manager' => 'usr-avatar-manager',
                                        'employee' => 'usr-avatar-employee',
                                        default => 'usr-avatar-default'
                                    };
                                @endphp
                                <tr class="fade-up" style="animation-delay:{{ 0.18 + ($index * 0.04) }}s;">
                                    <td data-label="#">
                                        <span class="row-num">{{ $users->firstItem() + $index }}</span>
                                    </td>
                                    <td data-label="User">
                                        <div class="usr-cell">
                                            <div class="usr-avatar {{ $avatarClass }}">{{ $initials }}</div>
                                            <div>
                                                <div class="usr-info-name">{{ $user->name }}</div>
                                                <div class="usr-info-email">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Role">
                                        @foreach($userRoles as $roleName)
                                            @php
                                                $roleClass = match($roleName) {
                                                    'admin' => 'usr-role-admin',
                                                    'manager' => 'usr-role-manager',
                                                    'employee' => 'usr-role-employee',
                                                    default => 'usr-role-default'
                                                };
                                                $roleIcon = match($roleName) {
                                                    'admin' => 'bi-shield-lock-fill',
                                                    'manager' => 'bi-star-fill',
                                                    'employee' => 'bi-person-fill',
                                                    default => 'bi-tag-fill'
                                                };
                                            @endphp
                                            <span class="usr-role-badge {{ $roleClass }}">
                                                <i class="bi {{ $roleIcon }}" style="font-size:.6rem;"></i>
                                                {{ ucfirst($roleName) }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td data-label="Status" style="text-align:center;">
                                        @if($user->email_verified_at)
                                            <span class="usr-status usr-status-active">
                                                <span class="usr-status-dot"></span>
                                                Active
                                            </span>
                                        @else
                                            <span class="usr-status usr-status-inactive">
                                                <span class="usr-status-dot"></span>
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td data-label="Created">
                                        <span class="usr-date">{{ $user->created_at->format('d M Y') }}</span>
                                    </td>
                                    <td data-label="Actions" style="text-align:center;">
                                        <div class="usr-actions" style="justify-content:center;">
                                            {{-- Edit --}}
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-action btn-action-edit" title="Edit User">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>

                                            {{-- Toggle Status --}}
                                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" style="margin:0;" onsubmit="return confirm('Are you sure you want to toggle this user\'s status?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn-action btn-action-toggle" title="Toggle Status">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                            </form>

                                            {{-- Reset Password --}}
                                            <button
                                                type="button"
                                                class="btn-action btn-action-reset"
                                                title="Reset Password"
                                                onclick="openResetModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                            >
                                                <i class="bi bi-key-fill"></i>
                                            </button>

                                            {{-- Delete --}}
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="margin:0;" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-action-delete" title="Delete User">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($users->hasPages())
                    <div class="usr-pagination fade-up fade-up-d2">
                        <span class="usr-pagination-info">
                            Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users
                        </span>
                        {{ $users->links() }}
                    </div>
                @endif

            @else
                {{-- Empty State --}}
                <div class="usr-empty fade-up fade-up-d2">
                    <div class="usr-empty-icon">
                        <i class="bi bi-person-gear"></i>
                    </div>
                    <h5>No users found</h5>
                    <p>
                        @if(request('search') || request('role'))
                            No results matching your filters. Try adjusting your search or role filter.
                        @else
                            Get started by creating your first user.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════ --}}
{{-- ── Reset Password Modal ── --}}
{{-- ════════════════════════════════════════════════════ --}}
<div class="usr-modal-overlay" id="resetPasswordModal">
    <div class="usr-modal">
        <div class="usr-modal-header">
            <h5>
                <i class="bi bi-key-fill" style="color:#6366f1;"></i>
                Reset Password
            </h5>
            <button type="button" class="usr-modal-close" onclick="closeResetModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form id="resetPasswordForm" method="POST">
            @csrf
            @method('PUT')
            <div class="usr-modal-body">
                <p style="font-size:.8125rem;color:#64748b;margin:0 0 1.25rem;">
                    Set a new password for <strong id="resetUserName" style="color:#1e293b;"></strong>.
                </p>

                @if($errors->any())
                    <div class="usr-modal-error">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <label class="usr-modal-label">New Password</label>
                <input
                    type="password"
                    name="password"
                    class="usr-modal-input"
                    placeholder="Enter new password"
                    required
                    minlength="8"
                />

                <label class="usr-modal-label">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="usr-modal-input"
                    placeholder="Confirm new password"
                    required
                    minlength="8"
                    style="margin-bottom:0;"
                />
            </div>
            <div class="usr-modal-footer">
                <button type="button" class="usr-modal-cancel" onclick="closeResetModal()">Cancel</button>
                <button type="submit" class="usr-modal-submit">
                    <i class="bi bi-check-lg" style="margin-right:.3rem;"></i> Reset Password
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openResetModal(userId, userName) {
        const modal = document.getElementById('resetPasswordModal');
        const form  = document.getElementById('resetPasswordForm');
        const nameEl = document.getElementById('resetUserName');

        // Build route — replace placeholder
        form.action = "{{ url('admin/users') }}/" + userId + "/reset-password";
        nameEl.textContent = userName;

        modal.classList.add('active');
        // Focus first input
        setTimeout(() => {
            form.querySelector('input[name="password"]').focus();
        }, 100);
    }

    function closeResetModal() {
        const modal = document.getElementById('resetPasswordModal');
        modal.classList.remove('active');
        // Clear inputs
        document.getElementById('resetPasswordForm').reset();
    }

    // Close modal on overlay click
    document.getElementById('resetPasswordModal').addEventListener('click', function(e) {
        if (e.target === this) closeResetModal();
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeResetModal();
    });

    // Re-open modal if validation errors exist
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            openResetModal(
                {{ old('_reset_user_id', 0) }},
                '{{ old('_reset_user_name', '') }}'
            );
        });
    @endif
</script>

@endsection
