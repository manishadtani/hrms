@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .ann-page {
        font-family: 'Inter', sans-serif;
        background: #f0f2f5;
        min-height: 100vh;
        padding: 2rem 0 4rem;
    }

    .ann-container {
        max-width: 960px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    /* Flash Messages */
    .ann-flash {
        padding: 1rem 1.25rem;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        animation: fadeUp 0.5s ease both;
        border: 1px solid transparent;
    }

    .ann-flash-success {
        background: #ecfdf5;
        color: #065f46;
        border-color: #a7f3d0;
    }

    .ann-flash-error {
        background: #fef2f2;
        color: #991b1b;
        border-color: #fecaca;
    }

    .ann-flash-warning {
        background: #fffbeb;
        color: #92400e;
        border-color: #fde68a;
    }

    .ann-flash i {
        font-size: 1.15rem;
    }

    /* Page Header */
    .ann-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        animation: fadeUp 0.45s ease both;
    }

    .ann-header-left h1 {
        font-size: 1.85rem;
        font-weight: 800;
        color: #111827;
        margin: 0;
        letter-spacing: -0.025em;
    }

    .ann-header-left p {
        color: #6b7280;
        font-size: 0.92rem;
        margin: 0.3rem 0 0;
        font-weight: 400;
    }

    .ann-btn-create {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.7rem 1.4rem;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 0.88rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.25);
    }

    .ann-btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.35);
        color: #fff;
        text-decoration: none;
        background: linear-gradient(135deg, #5558e6 0%, #7c4fe0 100%);
    }

    .ann-btn-create:active {
        transform: translateY(0);
    }

    /* Filter Tabs */
    .ann-filters {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 1.75rem;
        background: #fff;
        padding: 0.35rem;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        animation: fadeUp 0.5s ease 0.06s both;
        border: 1px solid #e5e7eb;
    }

    .ann-filter-tab {
        padding: 0.55rem 1.2rem;
        border-radius: 9px;
        font-size: 0.84rem;
        font-weight: 500;
        color: #6b7280;
        text-decoration: none;
        transition: all 0.2s ease;
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .ann-filter-tab:hover {
        color: #374151;
        background: #f3f4f6;
        text-decoration: none;
    }

    .ann-filter-tab.active {
        background: #6366f1;
        color: #fff;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.25);
    }

    .ann-filter-tab.active:hover {
        color: #fff;
        background: #5558e6;
    }

    .ann-filter-count {
        font-size: 0.72rem;
        font-weight: 700;
        min-width: 1.3rem;
        height: 1.3rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        padding: 0 0.35rem;
    }

    .ann-filter-tab.active .ann-filter-count {
        background: rgba(255, 255, 255, 0.25);
        color: #fff;
    }

    .ann-filter-tab:not(.active) .ann-filter-count {
        background: #e5e7eb;
        color: #6b7280;
    }

    /* Announcement Cards */
    .ann-cards-list {
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
    }

    .ann-card {
        background: #fff;
        border-radius: 14px;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .ann-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        border-radius: 14px 0 0 14px;
        transition: all 0.3s ease;
    }

    .ann-card[data-status="draft"]::before {
        background: linear-gradient(180deg, #fbbf24, #f59e0b);
    }

    .ann-card[data-status="published"]::before {
        background: linear-gradient(180deg, #34d399, #10b981);
    }

    .ann-card[data-status="archived"]::before {
        background: linear-gradient(180deg, #9ca3af, #6b7280);
    }

    .ann-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04);
        border-color: #d1d5db;
    }

    .ann-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }

    .ann-card-title-group {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        flex: 1;
        min-width: 0;
    }

    .ann-pin-icon {
        color: #6366f1;
        font-size: 1rem;
        flex-shrink: 0;
        animation: pinPulse 2s ease-in-out infinite;
    }

    @keyframes pinPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }

    .ann-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
        line-height: 1.35;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .ann-card-actions {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        flex-shrink: 0;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .ann-card:hover .ann-card-actions {
        opacity: 1;
    }

    .ann-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
        color: #6b7280;
        text-decoration: none;
        font-size: 0.88rem;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .ann-action-btn:hover {
        text-decoration: none;
    }

    .ann-action-edit:hover {
        background: #eef2ff;
        border-color: #c7d2fe;
        color: #6366f1;
    }

    .ann-action-delete:hover {
        background: #fef2f2;
        border-color: #fecaca;
        color: #ef4444;
    }

    .ann-card-content {
        color: #6b7280;
        font-size: 0.88rem;
        line-height: 1.65;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .ann-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.6rem;
    }

    .ann-card-meta {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        flex-wrap: wrap;
    }

    .ann-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.25rem 0.7rem;
        border-radius: 20px;
        font-size: 0.74rem;
        font-weight: 600;
        letter-spacing: 0.01em;
        text-transform: capitalize;
    }

    .ann-badge-draft {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .ann-badge-published {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .ann-badge-archived {
        background: #f3f4f6;
        color: #6b7280;
        border: 1px solid #e5e7eb;
    }

    .ann-badge-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .ann-badge-draft .ann-badge-dot {
        background: #f59e0b;
    }

    .ann-badge-published .ann-badge-dot {
        background: #10b981;
    }

    .ann-badge-archived .ann-badge-dot {
        background: #9ca3af;
    }

    .ann-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.8rem;
        color: #9ca3af;
    }

    .ann-meta-item i {
        font-size: 0.85rem;
    }

    .ann-meta-divider {
        width: 3px;
        height: 3px;
        border-radius: 50%;
        background: #d1d5db;
    }

    /* Empty State */
    .ann-empty {
        text-align: center;
        padding: 4rem 2rem;
        background: #fff;
        border-radius: 16px;
        border: 2px dashed #e5e7eb;
        animation: fadeUp 0.5s ease 0.1s both;
    }

    .ann-empty-icon {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
    }

    .ann-empty-icon i {
        font-size: 1.7rem;
        color: #6366f1;
    }

    .ann-empty h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #111827;
        margin: 0 0 0.5rem;
    }

    .ann-empty p {
        color: #9ca3af;
        font-size: 0.88rem;
        margin: 0 0 1.5rem;
        max-width: 340px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Pagination */
    .ann-pagination {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
        animation: fadeUp 0.5s ease 0.15s both;
    }

    .ann-pagination nav {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .ann-pagination .pagination {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        list-style: none;
        padding: 0;
        margin: 0;
        flex-wrap: wrap;
        justify-content: center;
    }

    .ann-pagination .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 0.6rem;
        border-radius: 10px;
        font-size: 0.84rem;
        font-weight: 500;
        color: #6b7280;
        background: #fff;
        border: 1px solid #e5e7eb;
        text-decoration: none;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
    }

    .ann-pagination .page-link:hover {
        background: #f3f4f6;
        border-color: #d1d5db;
        color: #374151;
        text-decoration: none;
    }

    .ann-pagination .page-item.active .page-link {
        background: #6366f1;
        color: #fff;
        border-color: #6366f1;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.25);
    }

    .ann-pagination .page-item.disabled .page-link {
        opacity: 0.45;
        pointer-events: none;
    }

    /* Delete Form */
    .ann-delete-form {
        display: inline;
        margin: 0;
        padding: 0;
    }

    .ann-delete-form button {
        font-family: 'Inter', sans-serif;
    }

    /* Animations */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .ann-card-animate {
        animation: fadeUp 0.45s ease both;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .ann-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .ann-btn-create {
            width: 100%;
            justify-content: center;
        }

        .ann-filters {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .ann-filter-tab {
            white-space: nowrap;
        }

        .ann-card-top {
            flex-direction: column;
            gap: 0.5rem;
        }

        .ann-card-actions {
            opacity: 1;
        }

        .ann-card-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .ann-card {
            padding: 1.15rem;
        }
    }
</style>

<div class="ann-page">
    <div class="ann-container">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="ann-flash ann-flash-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="ann-flash ann-flash-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="ann-flash ann-flash-warning">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('warning') }}
            </div>
        @endif

        {{-- Page Header --}}
        <div class="ann-header">
            <div class="ann-header-left">
                <h1>Announcements</h1>
                <p>Manage and broadcast announcements to your organization</p>
            </div>
            <a href="{{ route('admin.announcements.create') }}" class="ann-btn-create">
                <i class="bi bi-plus-lg"></i>
                New Announcement
            </a>
        </div>

        {{-- Status Filter Tabs --}}
        @php
            $currentStatus = request('status', 'all');
        @endphp
        <div class="ann-filters">
            <a href="{{ route('admin.announcements.index') }}"
               class="ann-filter-tab {{ $currentStatus === 'all' ? 'active' : '' }}">
                <i class="bi bi-grid-3x3-gap"></i>
                All
            </a>
            <a href="{{ route('admin.announcements.index', ['status' => 'draft']) }}"
               class="ann-filter-tab {{ $currentStatus === 'draft' ? 'active' : '' }}">
                <i class="bi bi-pencil"></i>
                Draft
            </a>
            <a href="{{ route('admin.announcements.index', ['status' => 'published']) }}"
               class="ann-filter-tab {{ $currentStatus === 'published' ? 'active' : '' }}">
                <i class="bi bi-broadcast"></i>
                Published
            </a>
            <a href="{{ route('admin.announcements.index', ['status' => 'archived']) }}"
               class="ann-filter-tab {{ $currentStatus === 'archived' ? 'active' : '' }}">
                <i class="bi bi-archive"></i>
                Archived
            </a>
        </div>

        {{-- Announcement Cards --}}
        @if($announcements->count() > 0)
            <div class="ann-cards-list">
                @foreach($announcements as $index => $ann)
                    <div class="ann-card ann-card-animate"
                         data-status="{{ $ann->status }}"
                         style="animation-delay: {{ $index * 0.06 }}s;">

                        <div class="ann-card-top">
                            <div class="ann-card-title-group">
                                @if($ann->is_pinned)
                                    <i class="bi bi-pin-angle-fill ann-pin-icon" title="Pinned"></i>
                                @endif
                                <h3 class="ann-card-title">{{ $ann->title }}</h3>
                            </div>
                            <div class="ann-card-actions">
                                <a href="{{ route('admin.announcements.edit', $ann) }}"
                                   class="ann-action-btn ann-action-edit"
                                   title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.announcements.destroy', $ann) }}"
                                      method="POST"
                                      class="ann-delete-form"
                                      onsubmit="return confirm('Are you sure you want to delete this announcement?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ann-action-btn ann-action-delete" title="Delete">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <p class="ann-card-content">{{ Str::limit(strip_tags($ann->content), 120) }}</p>

                        <div class="ann-card-footer">
                            <div class="ann-card-meta">
                                <span class="ann-badge ann-badge-{{ $ann->status }}">
                                    <span class="ann-badge-dot"></span>
                                    {{ $ann->status }}
                                </span>

                                <span class="ann-meta-divider"></span>

                                <span class="ann-meta-item">
                                    <i class="bi bi-person"></i>
                                    {{ $ann->creator->name }}
                                </span>

                                <span class="ann-meta-divider"></span>

                                <span class="ann-meta-item">
                                    <i class="bi bi-calendar3"></i>
                                    @if($ann->published_at)
                                        {{ $ann->published_at->format('M d, Y') }}
                                    @else
                                        {{ $ann->created_at->format('M d, Y') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($announcements->hasPages())
                <div class="ann-pagination">
                    {{ $announcements->links() }}
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="ann-empty">
                <div class="ann-empty-icon">
                    <i class="bi bi-megaphone"></i>
                </div>
                <h3>No announcements found</h3>
                <p>
                    @if($currentStatus !== 'all')
                        There are no {{ $currentStatus }} announcements. Try a different filter or create a new one.
                    @else
                        Get started by creating your first announcement to keep everyone informed.
                    @endif
                </p>
                <a href="{{ route('admin.announcements.create') }}" class="ann-btn-create">
                    <i class="bi bi-plus-lg"></i>
                    Create Announcement
                </a>
            </div>
        @endif

    </div>
</div>
@endsection
