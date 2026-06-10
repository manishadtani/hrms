@extends('layouts.app')

@section('content')
<style>
    .ann-page {
        --primary: #6366f1;
        --primary-light: #818cf8;
        --indigo: #4f46e5;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --text-muted: #94a3b8;
        --border: #f1f5f9;
        --card-bg: #ffffff;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* ── Banner ── */
    .ann-banner {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a78bfa 100%);
        border-radius: 20px;
        padding: 32px 36px;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
    }
    .ann-banner::before {
        content: '';
        position: absolute;
        right: -40px;
        top: -40px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .ann-banner::after {
        content: '';
        position: absolute;
        right: 60px;
        bottom: -60px;
        width: 160px;
        height: 160px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .ann-banner h2 {
        font-size: 1.75rem;
        font-weight: 700;
        letter-spacing: -0.5px;
        margin: 0;
        position: relative;
        z-index: 1;
    }
    .ann-banner p {
        opacity: 0.85;
        font-size: 0.92rem;
        margin: 6px 0 0;
        position: relative;
        z-index: 1;
    }
    .ann-banner-meta {
        display: flex;
        gap: 12px;
        margin-top: 14px;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }
    .ann-banner-meta .meta-chip {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.82rem;
        background: rgba(255,255,255,0.15);
        padding: 5px 14px;
        border-radius: 20px;
        font-weight: 500;
    }

    /* ── Announcement Card ── */
    .ann-card {
        background: var(--card-bg);
        border-radius: 16px;
        border: 1px solid var(--border);
        padding: 0;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        position: relative;
    }
    .ann-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    }
    .ann-card-inner {
        padding: 24px 28px;
    }
    .ann-card.pinned {
        border-left: 4px solid var(--indigo);
    }
    .ann-card.pinned .ann-card-inner {
        padding-left: 24px;
    }

    /* ── Pinned Strip ── */
    .ann-pinned-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        background: #eef2ff;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }

    /* ── Card Title ── */
    .ann-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 12px;
        line-height: 1.4;
    }

    /* ── Card Content ── */
    .ann-content {
        font-size: 0.88rem;
        line-height: 1.7;
        color: var(--text-secondary);
        margin: 0 0 20px;
        word-wrap: break-word;
    }

    /* ── Card Footer ── */
    .ann-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 16px;
        border-top: 1px solid var(--border);
        flex-wrap: wrap;
        gap: 10px;
    }
    .ann-footer-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        color: var(--text-muted);
    }
    .ann-footer-item i {
        font-size: 0.85rem;
    }
    .ann-creator-avatar {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: #eef2ff;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.7rem;
        flex-shrink: 0;
    }

    /* ── Empty State ── */
    .ann-empty {
        background: var(--card-bg);
        border-radius: 16px;
        border: 1px solid var(--border);
        text-align: center;
        padding: 60px 20px;
    }
    .ann-empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f8fafc;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }
    .ann-empty-icon i {
        font-size: 2rem;
        color: #cbd5e1;
    }
    .ann-empty h5 {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 6px;
    }
    .ann-empty p {
        font-size: 0.88rem;
        color: var(--text-muted);
        margin: 0;
    }

    /* ── Pagination ── */
    .ann-pagination {
        display: flex;
        justify-content: center;
        margin-top: 28px;
    }
    .ann-pagination .pagination {
        gap: 4px;
    }
    .ann-pagination .page-link {
        border: 1px solid var(--border);
        border-radius: 10px !important;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--text-secondary);
        padding: 8px 14px;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
    }
    .ann-pagination .page-link:hover {
        background: #eef2ff;
        color: var(--primary);
        border-color: #c7d2fe;
    }
    .ann-pagination .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
    }
    .ann-pagination .page-item.disabled .page-link {
        background: #f8fafc;
        color: #cbd5e1;
    }

    /* ── Animations ── */
    .fade-up {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.5s ease forwards;
    }
    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }
    .fade-up:nth-child(1)  { animation-delay: 0.05s; }
    .fade-up:nth-child(2)  { animation-delay: 0.10s; }
    .fade-up:nth-child(3)  { animation-delay: 0.15s; }
    .fade-up:nth-child(4)  { animation-delay: 0.20s; }
    .fade-up:nth-child(5)  { animation-delay: 0.25s; }
    .fade-up:nth-child(6)  { animation-delay: 0.30s; }
    .fade-up:nth-child(7)  { animation-delay: 0.35s; }
    .fade-up:nth-child(8)  { animation-delay: 0.40s; }
    .fade-up:nth-child(9)  { animation-delay: 0.45s; }
    .fade-up:nth-child(10) { animation-delay: 0.50s; }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .ann-banner { padding: 24px 20px; border-radius: 16px; }
        .ann-banner h2 { font-size: 1.3rem; }
        .ann-card-inner { padding: 20px; }
        .ann-title { font-size: 1rem; }
        .ann-footer { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="ann-page">

    {{-- ── Banner ── --}}
    <div class="ann-banner fade-up">
        <h2><i class="bi bi-megaphone-fill me-2"></i>Announcements</h2>
        <p>Stay up to date with the latest company news and updates</p>
        <div class="ann-banner-meta">
            <span class="meta-chip">
                <i class="bi bi-newspaper"></i> {{ $announcements->total() }} {{ Str::plural('Announcement', $announcements->total()) }}
            </span>
            <span class="meta-chip">
                <i class="bi bi-calendar3"></i> {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
        <div class="alert alert-dismissible fade show fade-up" role="alert" style="border-radius:12px;border:none;background:#ecfdf5;color:#166534;font-family:'Inter',sans-serif;font-size:0.88rem;font-weight:500;">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-dismissible fade show fade-up" role="alert" style="border-radius:12px;border:none;background:#fef2f2;color:#991b1b;font-family:'Inter',sans-serif;font-size:0.88rem;font-weight:500;">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ── Announcements List ── --}}
    @if($announcements->count() > 0)
        <div class="d-flex flex-column gap-3">
            @foreach($announcements as $announcement)
                <div class="ann-card {{ $announcement->is_pinned ? 'pinned' : '' }} fade-up">
                    <div class="ann-card-inner">
                        {{-- Pinned Badge --}}
                        @if($announcement->is_pinned)
                            <span class="ann-pinned-badge">
                                <i class="bi bi-pin-fill"></i> Pinned
                            </span>
                        @endif

                        {{-- Title --}}
                        <h5 class="ann-title">{{ $announcement->title }}</h5>

                        {{-- Content --}}
                        <div class="ann-content">
                            {!! nl2br(e($announcement->content)) !!}
                        </div>

                        {{-- Footer --}}
                        <div class="ann-footer">
                            <div class="ann-footer-item">
                                @php
                                    $creatorName = $announcement->creator->name ?? 'System';
                                    $initials = collect(explode(' ', $creatorName))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
                                @endphp
                                <span class="ann-creator-avatar">{{ $initials }}</span>
                                <span>{{ $creatorName }}</span>
                            </div>
                            <div class="ann-footer-item">
                                <i class="bi bi-clock"></i>
                                <span>{{ $announcement->published_at ? $announcement->published_at->diffForHumans() : 'Draft' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($announcements->hasPages())
            <div class="ann-pagination fade-up">
                {{ $announcements->links() }}
            </div>
        @endif

    @else
        {{-- Empty State --}}
        <div class="ann-empty fade-up">
            <div class="ann-empty-icon">
                <i class="bi bi-megaphone"></i>
            </div>
            <h5>No Announcements Yet</h5>
            <p>There are currently no announcements to display. Check back later!</p>
        </div>
    @endif

</div>
@endsection
