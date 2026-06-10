@extends('layouts.app')

@section('content')
<style>
    .profile-page {
        --primary: #0891b2;
        --primary-light: #06b6d4;
        --teal-dark: #0e7490;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --indigo: #6366f1;
        --sky: #0ea5e9;
        --violet: #8b5cf6;
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-700: #334155;
        --slate-800: #1e293b;
        --slate-900: #0f172a;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* ── Profile Header Banner ── */
    .profile-header {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 40%, #0e7490 100%);
        border-radius: 20px;
        padding: 0;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
    }
    .profile-header::before {
        content: '';
        position: absolute;
        right: -60px;
        top: -60px;
        width: 240px;
        height: 240px;
        background: rgba(255,255,255,0.07);
        border-radius: 50%;
        pointer-events: none;
    }
    .profile-header::after {
        content: '';
        position: absolute;
        right: 80px;
        bottom: -80px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
        pointer-events: none;
    }
    .profile-header-inner {
        display: flex;
        align-items: center;
        gap: 28px;
        padding: 36px 40px;
        position: relative;
        z-index: 1;
        flex-wrap: wrap;
    }

    /* ── Avatar ── */
    .profile-avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.4rem;
        font-weight: 800;
        letter-spacing: 1px;
        background: rgba(255,255,255,0.2);
        border: 4px solid rgba(255,255,255,0.35);
        color: #fff;
        text-transform: uppercase;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    }
    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ── Header Text ── */
    .profile-header-info {
        flex: 1;
        min-width: 200px;
    }
    .profile-header-info h1 {
        font-size: 1.85rem;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin: 0 0 6px;
        line-height: 1.2;
    }
    .profile-header-info .profile-role {
        font-size: 1rem;
        font-weight: 500;
        opacity: 0.9;
        margin: 0 0 4px;
    }
    .profile-header-info .profile-dept {
        font-size: 0.9rem;
        opacity: 0.75;
        margin: 0 0 14px;
    }
    .profile-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.18);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        backdrop-filter: blur(4px);
    }

    /* ── Header Actions ── */
    .profile-header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        z-index: 1;
        flex-shrink: 0;
    }
    .btn-edit-profile {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 700;
        text-decoration: none;
        border: 2px solid rgba(255,255,255,0.45);
        color: #fff;
        background: rgba(255,255,255,0.1);
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        backdrop-filter: blur(4px);
        letter-spacing: 0.3px;
    }
    .btn-edit-profile:hover {
        background: rgba(255,255,255,0.25);
        border-color: rgba(255,255,255,0.7);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    /* ── Info Section Cards ── */
    .info-section {
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--slate-100);
        overflow: hidden;
        height: 100%;
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        position: relative;
    }
    .info-section:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    }
    .info-section-bar {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }
    .bar-teal { background: linear-gradient(90deg, #06b6d4, #14b8a6); }
    .bar-indigo { background: linear-gradient(90deg, #6366f1, #818cf8); }
    .bar-emerald { background: linear-gradient(90deg, #10b981, #34d399); }
    .bar-violet { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }

    .info-section-header {
        padding: 22px 24px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .info-section-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .icon-teal-bg { background: #f0fdfa; color: #0d9488; }
    .icon-indigo-bg { background: #eef2ff; color: #6366f1; }
    .icon-emerald-bg { background: #ecfdf5; color: #10b981; }
    .icon-violet-bg { background: #f5f3ff; color: #8b5cf6; }

    .info-section-header h5 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--slate-800);
        margin: 0;
    }
    .info-section-body {
        padding: 16px 24px 24px;
    }

    /* ── Info Items ── */
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid var(--slate-50);
        transition: background 0.2s;
    }
    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .info-item:hover {
        background: var(--slate-50);
        margin: 0 -24px;
        padding-left: 24px;
        padding-right: 24px;
        border-radius: 8px;
    }
    .info-item-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
        background: var(--slate-50);
        color: var(--slate-500);
    }
    .info-item-content {
        flex: 1;
        min-width: 0;
    }
    .info-item-label {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        font-weight: 600;
        color: var(--slate-400);
        margin-bottom: 3px;
    }
    .info-item-value {
        font-size: 0.92rem;
        font-weight: 600;
        color: var(--slate-800);
        word-break: break-word;
    }
    .info-item-value.text-muted-light {
        color: var(--slate-400);
        font-weight: 500;
        font-style: italic;
    }

    /* ── Flash Messages ── */
    .profile-alert {
        border-radius: 12px;
        border: none;
        padding: 14px 20px;
        font-size: 0.88rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }
    .profile-alert-success {
        background: #ecfdf5;
        color: #166534;
    }
    .profile-alert-error {
        background: #fef2f2;
        color: #991b1b;
    }

    /* ── Animations ── */
    .fade-up {
        opacity: 0;
        transform: translateY(20px);
        animation: profileFadeUp 0.5s ease forwards;
    }
    @keyframes profileFadeUp {
        to { opacity: 1; transform: translateY(0); }
    }
    .fade-up:nth-child(1) { animation-delay: 0.05s; }
    .fade-up:nth-child(2) { animation-delay: 0.1s; }
    .fade-up:nth-child(3) { animation-delay: 0.15s; }
    .fade-up:nth-child(4) { animation-delay: 0.2s; }
    .fade-up:nth-child(5) { animation-delay: 0.25s; }
    .fade-up:nth-child(6) { animation-delay: 0.3s; }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .profile-header-inner {
            padding: 24px 20px;
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }
        .profile-avatar {
            width: 90px;
            height: 90px;
            font-size: 1.8rem;
        }
        .profile-header-info h1 {
            font-size: 1.4rem;
        }
        .profile-header-actions {
            width: 100%;
            justify-content: center;
        }
        .info-section-body {
            padding: 12px 16px 16px;
        }
        .info-item:hover {
            margin: 0 -16px;
            padding-left: 16px;
            padding-right: 16px;
        }
    }
</style>

<div class="profile-page">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="profile-alert profile-alert-success alert alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="profile-alert profile-alert-error alert alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════
         1. PROFILE HEADER BANNER
    ═══════════════════════════════════════════════ --}}
    <div class="profile-header fade-up">
        <div class="profile-header-inner">
            {{-- Avatar --}}
            <div class="profile-avatar">
                @if($employee->profile_photo)
                    <img src="{{ Storage::url($employee->profile_photo) }}" alt="{{ $employee->first_name }}">
                @else
                    {{ strtoupper(substr($employee->first_name, 0, 1)) }}{{ strtoupper(substr($employee->last_name, 0, 1)) }}
                @endif
            </div>

            {{-- Header Info --}}
            <div class="profile-header-info">
                <h1>{{ $employee->first_name }} {{ $employee->last_name }}</h1>
                <p class="profile-role">
                    <i class="bi bi-bookmark-star-fill" style="margin-right:4px;opacity:0.8;"></i>
                    {{ $employee->designation->name ?? 'N/A' }}
                </p>
                <p class="profile-dept">
                    <i class="bi bi-building" style="margin-right:4px;"></i>
                    {{ $employee->department->name ?? 'N/A' }}
                </p>
                <span class="profile-badge">
                    <i class="bi bi-person-badge-fill"></i> {{ $employee->employee_code }}
                </span>
            </div>

            {{-- Edit Button --}}
            <div class="profile-header-actions">
                <a href="{{ route('employee.profile.edit') }}" class="btn-edit-profile">
                    <i class="bi bi-pencil-square"></i> Edit Profile
                </a>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         2. INFO CARDS - TWO COLUMN GRID
    ═══════════════════════════════════════════════ --}}
    <div class="row g-4">

        {{-- ── Personal Information ── --}}
        <div class="col-lg-6 fade-up">
            <div class="info-section">
                <div class="info-section-bar bar-teal"></div>
                <div class="info-section-header">
                    <div class="info-section-icon icon-teal-bg">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <h5>Personal Information</h5>
                </div>
                <div class="info-section-body">
                    {{-- Full Name --}}
                    <div class="info-item">
                        <div class="info-item-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="info-item-content">
                            <div class="info-item-label">Full Name</div>
                            <div class="info-item-value">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="info-item">
                        <div class="info-item-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="info-item-content">
                            <div class="info-item-label">Email Address</div>
                            <div class="info-item-value">{{ $employee->user->email ?? 'N/A' }}</div>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="info-item">
                        <div class="info-item-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div class="info-item-content">
                            <div class="info-item-label">Phone Number</div>
                            <div class="info-item-value {{ !$employee->phone ? 'text-muted-light' : '' }}">
                                {{ $employee->phone ?? 'Not provided' }}
                            </div>
                        </div>
                    </div>

                    {{-- Date of Birth --}}
                    <div class="info-item">
                        <div class="info-item-icon">
                            <i class="bi bi-cake2"></i>
                        </div>
                        <div class="info-item-content">
                            <div class="info-item-label">Date of Birth</div>
                            <div class="info-item-value {{ !$employee->date_of_birth ? 'text-muted-light' : '' }}">
                                {{ $employee->date_of_birth ? \Carbon\Carbon::parse($employee->date_of_birth)->format('d M Y') : 'Not provided' }}
                            </div>
                        </div>
                    </div>

                    {{-- Gender --}}
                    <div class="info-item">
                        <div class="info-item-icon">
                            <i class="bi bi-gender-ambiguous"></i>
                        </div>
                        <div class="info-item-content">
                            <div class="info-item-label">Gender</div>
                            <div class="info-item-value {{ !$employee->gender ? 'text-muted-light' : '' }}">
                                {{ $employee->gender ? ucfirst($employee->gender) : 'Not provided' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Work Information ── --}}
        <div class="col-lg-6 fade-up">
            <div class="info-section">
                <div class="info-section-bar bar-indigo"></div>
                <div class="info-section-header">
                    <div class="info-section-icon icon-indigo-bg">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                    <h5>Work Information</h5>
                </div>
                <div class="info-section-body">
                    {{-- Employee Code --}}
                    <div class="info-item">
                        <div class="info-item-icon">
                            <i class="bi bi-hash"></i>
                        </div>
                        <div class="info-item-content">
                            <div class="info-item-label">Employee Code</div>
                            <div class="info-item-value">{{ $employee->employee_code }}</div>
                        </div>
                    </div>

                    {{-- Department --}}
                    <div class="info-item">
                        <div class="info-item-icon">
                            <i class="bi bi-diagram-3"></i>
                        </div>
                        <div class="info-item-content">
                            <div class="info-item-label">Department</div>
                            <div class="info-item-value">{{ $employee->department->name ?? 'N/A' }}</div>
                        </div>
                    </div>

                    {{-- Designation --}}
                    <div class="info-item">
                        <div class="info-item-icon">
                            <i class="bi bi-bookmark-star"></i>
                        </div>
                        <div class="info-item-content">
                            <div class="info-item-label">Designation</div>
                            <div class="info-item-value">{{ $employee->designation->name ?? 'N/A' }}</div>
                        </div>
                    </div>

                    {{-- Date of Joining --}}
                    <div class="info-item">
                        <div class="info-item-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div class="info-item-content">
                            <div class="info-item-label">Date of Joining</div>
                            <div class="info-item-value {{ !$employee->date_of_joining ? 'text-muted-light' : '' }}">
                                {{ $employee->date_of_joining ? \Carbon\Carbon::parse($employee->date_of_joining)->format('d M Y') : 'Not provided' }}
                            </div>
                        </div>
                    </div>

                    {{-- Reporting Manager --}}
                    <div class="info-item">
                        <div class="info-item-icon">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <div class="info-item-content">
                            <div class="info-item-label">Reporting Manager</div>
                            <div class="info-item-value {{ !$employee->manager ? 'text-muted-light' : '' }}">
                                @if($employee->manager)
                                    {{ $employee->manager->first_name }} {{ $employee->manager->last_name }}
                                @else
                                    Not assigned
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Contact / Address ── --}}
        <div class="col-12 fade-up">
            <div class="info-section">
                <div class="info-section-bar bar-emerald"></div>
                <div class="info-section-header">
                    <div class="info-section-icon icon-emerald-bg">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h5>Contact &amp; Address</h5>
                </div>
                <div class="info-section-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-item-icon">
                                    <i class="bi bi-envelope-at"></i>
                                </div>
                                <div class="info-item-content">
                                    <div class="info-item-label">Email Address</div>
                                    <div class="info-item-value">{{ $employee->user->email ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-item-icon">
                                    <i class="bi bi-phone"></i>
                                </div>
                                <div class="info-item-content">
                                    <div class="info-item-label">Phone Number</div>
                                    <div class="info-item-value {{ !$employee->phone ? 'text-muted-light' : '' }}">
                                        {{ $employee->phone ?? 'Not provided' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-item">
                                <div class="info-item-icon">
                                    <i class="bi bi-house-door"></i>
                                </div>
                                <div class="info-item-content">
                                    <div class="info-item-label">Residential Address</div>
                                    <div class="info-item-value {{ !$employee->address ? 'text-muted-light' : '' }}">
                                        {{ $employee->address ?? 'Not provided' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /row --}}

    {{-- Bottom spacing --}}
    <div style="height: 40px;"></div>
</div>
@endsection
