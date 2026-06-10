@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    .leave-types-page {
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
        background: #f0f2f5;
        padding: 2rem 0 4rem;
    }

    /* ── Page Header ── */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .page-header-left h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
        letter-spacing: -0.025em;
    }

    .page-header-left p {
        color: #64748b;
        font-size: 0.9rem;
        margin: 0.25rem 0 0;
        font-weight: 400;
    }

    .btn-add-leave {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.5rem;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
        transition: all 0.25s ease;
        font-family: 'Inter', sans-serif;
    }

    .btn-add-leave:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.45);
        color: #fff;
        text-decoration: none;
        background: linear-gradient(135deg, #818cf8, #6366f1);
    }

    .btn-add-leave:active {
        transform: translateY(0);
    }

    .btn-add-leave i {
        font-size: 1rem;
    }

    /* ── Flash Messages ── */
    .flash-alert {
        border: none;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 1.5rem;
        animation: slideDown 0.4s ease;
        font-family: 'Inter', sans-serif;
    }

    .flash-alert-success {
        background: #ecfdf5;
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    .flash-alert-error {
        background: #fef2f2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    .flash-alert i {
        font-size: 1.15rem;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ── Cards Grid ── */
    .leave-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    @media (max-width: 1199px) {
        .leave-cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 767px) {
        .leave-cards-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ── Leave Card ── */
    .leave-card {
        background: #fff;
        border-radius: 16px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 4px 12px rgba(0, 0, 0, 0.04);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeUp 0.5s ease forwards;
    }

    .leave-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1), 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    @keyframes fadeUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .leave-card:nth-child(1) { animation-delay: 0.05s; }
    .leave-card:nth-child(2) { animation-delay: 0.1s; }
    .leave-card:nth-child(3) { animation-delay: 0.15s; }
    .leave-card:nth-child(4) { animation-delay: 0.2s; }
    .leave-card:nth-child(5) { animation-delay: 0.25s; }
    .leave-card:nth-child(6) { animation-delay: 0.3s; }
    .leave-card:nth-child(7) { animation-delay: 0.35s; }
    .leave-card:nth-child(8) { animation-delay: 0.4s; }
    .leave-card:nth-child(9) { animation-delay: 0.45s; }

    .leave-card-body {
        padding: 1.5rem 1.5rem 1rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .leave-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }

    .leave-card-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        line-height: 1.3;
        flex: 1;
        padding-right: 0.75rem;
    }

    .leave-code-badge {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 0.3rem 0.65rem;
        border-radius: 8px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .leave-card-desc {
        color: #64748b;
        font-size: 0.825rem;
        line-height: 1.55;
        margin-bottom: 1.25rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    .leave-card-stats {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .days-stat {
        display: flex;
        align-items: baseline;
        gap: 0.35rem;
        background: #f1f5f9;
        padding: 0.5rem 0.85rem;
        border-radius: 10px;
    }

    .days-stat-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: #4f46e5;
        line-height: 1;
    }

    .days-stat-label {
        font-size: 0.7rem;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .status-badge {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.3rem 0.7rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .status-badge-active {
        background: #ecfdf5;
        color: #059669;
    }

    .status-badge-active::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #10b981;
        display: inline-block;
    }

    .status-badge-inactive {
        background: #fef2f2;
        color: #dc2626;
    }

    .status-badge-inactive::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #ef4444;
        display: inline-block;
    }

    .requests-badge {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.3rem 0.7rem;
        border-radius: 20px;
        background: #eff6ff;
        color: #3b82f6;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .requests-badge i {
        font-size: 0.75rem;
    }

    /* ── Card Actions ── */
    .leave-card-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 1.5rem;
        border-top: 1px solid #f1f5f9;
    }

    .btn-card-edit {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 1rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #4f46e5;
        background: #eef2ff;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
    }

    .btn-card-edit:hover {
        background: #e0e7ff;
        color: #4338ca;
        text-decoration: none;
    }

    .btn-card-delete {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 1rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #dc2626;
        background: #fef2f2;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
    }

    .btn-card-delete:hover {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* ── Bottom Color Bar ── */
    .leave-card-bar {
        height: 4px;
        width: 100%;
        border-radius: 0 0 16px 16px;
    }

    /* ── Color Themes ── */
    .theme-indigo .leave-code-badge { background: #eef2ff; color: #4f46e5; }
    .theme-indigo .leave-card-bar { background: linear-gradient(90deg, #6366f1, #818cf8); }

    .theme-emerald .leave-code-badge { background: #ecfdf5; color: #059669; }
    .theme-emerald .leave-card-bar { background: linear-gradient(90deg, #10b981, #34d399); }

    .theme-amber .leave-code-badge { background: #fffbeb; color: #d97706; }
    .theme-amber .leave-card-bar { background: linear-gradient(90deg, #f59e0b, #fbbf24); }

    .theme-rose .leave-code-badge { background: #fff1f2; color: #e11d48; }
    .theme-rose .leave-card-bar { background: linear-gradient(90deg, #f43f5e, #fb7185); }

    .theme-sky .leave-code-badge { background: #f0f9ff; color: #0284c7; }
    .theme-sky .leave-card-bar { background: linear-gradient(90deg, #0ea5e9, #38bdf8); }

    .theme-violet .leave-code-badge { background: #f5f3ff; color: #7c3aed; }
    .theme-violet .leave-card-bar { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }

    .theme-teal .leave-code-badge { background: #f0fdfa; color: #0d9488; }
    .theme-teal .leave-card-bar { background: linear-gradient(90deg, #14b8a6, #2dd4bf); }

    .theme-orange .leave-code-badge { background: #fff7ed; color: #ea580c; }
    .theme-orange .leave-card-bar { background: linear-gradient(90deg, #f97316, #fb923c); }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        animation: fadeUp 0.5s ease forwards;
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
    }

    .empty-state-icon i {
        font-size: 2rem;
        color: #6366f1;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #94a3b8;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        max-width: 360px;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<div class="leave-types-page">
    <div class="container">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="flash-alert flash-alert-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="flash-alert flash-alert-error">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Page Header --}}
        <div class="page-header">
            <div class="page-header-left">
                <h1><i class="bi bi-calendar2-week" style="color:#6366f1; margin-right:0.5rem;"></i>Leave Types</h1>
                <p>Manage and configure your organization's leave categories</p>
            </div>
            <a href="{{ route('admin.leave-types.create') }}" class="btn-add-leave">
                <i class="bi bi-plus-lg"></i>
                Add Leave Type
            </a>
        </div>

        {{-- Cards Grid --}}
        @if($leaveTypes->count() > 0)
            @php
                $themes = ['indigo', 'emerald', 'amber', 'rose', 'sky', 'violet', 'teal', 'orange'];
            @endphp

            <div class="leave-cards-grid">
                @foreach($leaveTypes as $index => $leaveType)
                    @php $theme = $themes[$index % count($themes)]; @endphp
                    <div class="leave-card theme-{{ $theme }}">
                        <div class="leave-card-body">
                            <div class="leave-card-top">
                                <h5 class="leave-card-name">{{ $leaveType->name }}</h5>
                                <span class="leave-code-badge">{{ $leaveType->code }}</span>
                            </div>

                            <p class="leave-card-desc">
                                {{ $leaveType->description ?: 'No description provided.' }}
                            </p>

                            <div class="leave-card-stats">
                                <div class="days-stat">
                                    <span class="days-stat-number">{{ $leaveType->days_per_year }}</span>
                                    <span class="days-stat-label">days/yr</span>
                                </div>

                                @if($leaveType->is_active)
                                    <span class="status-badge status-badge-active">Active</span>
                                @else
                                    <span class="status-badge status-badge-inactive">Inactive</span>
                                @endif

                                <span class="requests-badge">
                                    <i class="bi bi-file-earmark-text"></i>
                                    {{ $leaveType->leave_requests_count }} {{ Str::plural('request', $leaveType->leave_requests_count) }}
                                </span>
                            </div>
                        </div>

                        <div class="leave-card-actions">
                            <a href="{{ route('admin.leave-types.edit', $leaveType) }}" class="btn-card-edit">
                                <i class="bi bi-pencil-square"></i>
                                Edit
                            </a>
                            <form action="{{ route('admin.leave-types.destroy', $leaveType) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this leave type?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-card-delete">
                                    <i class="bi bi-trash3"></i>
                                    Delete
                                </button>
                            </form>
                        </div>

                        <div class="leave-card-bar"></div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-calendar2-x"></i>
                </div>
                <h3>No Leave Types Yet</h3>
                <p>Get started by creating your first leave type to manage employee time-off categories.</p>
                <a href="{{ route('admin.leave-types.create') }}" class="btn-add-leave">
                    <i class="bi bi-plus-lg"></i>
                    Create First Leave Type
                </a>
            </div>
        @endif

    </div>
</div>
@endsection
