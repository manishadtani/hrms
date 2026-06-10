@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .esh-page {
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
    .fade-up-d4 { animation-delay: .28s; }

    /* ── Page header ── */
    .esh-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .esh-header-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -.025em;
        margin: 0;
    }
    .esh-header-title i {
        color: #6366f1;
        margin-right: .5rem;
        font-size: 1.5rem;
    }
    .esh-header-sub {
        font-size: .875rem;
        color: #94a3b8;
        margin: .25rem 0 0;
        font-weight: 500;
    }
    .esh-header-actions {
        display: flex;
        gap: .5rem;
    }
    .btn-esh-edit {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .65rem 1.5rem;
        font-size: .8125rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        color: #fff;
        background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
        border: none;
        border-radius: .625rem;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(99,102,241,.35);
        transition: all .25s ease;
        cursor: pointer;
    }
    .btn-esh-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99,102,241,.45);
        color: #fff;
        text-decoration: none;
    }
    .btn-esh-back {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .6rem 1.25rem;
        font-size: .8125rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        color: #64748b;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .625rem;
        text-decoration: none;
        transition: all .25s ease;
        cursor: pointer;
    }
    .btn-esh-back:hover {
        background: #f8fafc;
        color: #475569;
        border-color: #cbd5e1;
        transform: translateY(-1px);
        text-decoration: none;
    }

    /* ── Flash messages ── */
    .esh-flash {
        padding: .85rem 1.25rem;
        border-radius: .625rem;
        font-size: .875rem;
        font-weight: 500;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .esh-flash-success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    /* ── Card ── */
    .esh-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 14px rgba(0,0,0,.04);
        overflow: hidden;
    }
    .esh-card-header {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        background: #fafbfc;
    }
    .esh-card-header h5 {
        margin: 0;
        font-size: .9rem;
        font-weight: 700;
        color: #334155;
    }
    .esh-card-header i {
        color: #6366f1;
        font-size: 1rem;
    }

    /* ── Profile Card (Left) ── */
    .esh-profile-card {
        text-align: center;
        padding: 2rem 1.5rem;
    }
    .esh-avatar {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        margin: 0 auto 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 2rem;
        color: #fff;
        letter-spacing: .04em;
        background: linear-gradient(135deg, #6366f1, #818cf8);
        box-shadow: 0 8px 24px rgba(99,102,241,.3);
        position: relative;
        overflow: hidden;
    }
    .esh-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }
    .esh-profile-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 .25rem;
        letter-spacing: -.02em;
    }
    .esh-profile-code {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        font-size: .75rem;
        font-weight: 600;
        color: #6366f1;
        background: #eef2ff;
        padding: .25rem .75rem;
        border-radius: 9999px;
        font-family: 'SF Mono', 'Fira Code', monospace;
        margin-bottom: 1rem;
        border: 1px solid #c7d2fe;
    }
    .esh-profile-designation {
        font-size: .8125rem;
        font-weight: 500;
        color: #64748b;
        margin-bottom: .25rem;
    }
    .esh-profile-department {
        font-size: .78rem;
        color: #94a3b8;
        font-weight: 500;
    }

    .esh-profile-divider {
        height: 1px;
        background: #f1f5f9;
        margin: 1.25rem 0;
    }

    /* ── Status badge ── */
    .esh-status-badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .4rem 1rem;
        font-size: .75rem;
        font-weight: 600;
        border-radius: 9999px;
    }
    .esh-status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .esh-status-active {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }
    .esh-status-active .esh-status-dot {
        background: #22c55e;
        box-shadow: 0 0 0 3px rgba(34,197,94,.2);
    }
    .esh-status-inactive {
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }
    .esh-status-inactive .esh-status-dot {
        background: #94a3b8;
        box-shadow: 0 0 0 3px rgba(148,163,184,.2);
    }
    .esh-status-terminated {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .esh-status-terminated .esh-status-dot {
        background: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,.2);
    }
    .esh-status-resigned {
        background: #fffbeb;
        color: #d97706;
        border: 1px solid #fde68a;
    }
    .esh-status-resigned .esh-status-dot {
        background: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245,158,11,.2);
    }

    /* ── Quick contact info in profile card ── */
    .esh-contact-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .esh-contact-item {
        display: flex;
        align-items: center;
        gap: .65rem;
        padding: .5rem .75rem;
        border-radius: .5rem;
        transition: background .15s;
        margin-bottom: .25rem;
    }
    .esh-contact-item:hover {
        background: #f8fafc;
    }
    .esh-contact-item:last-child {
        margin-bottom: 0;
    }
    .esh-contact-icon {
        width: 32px;
        height: 32px;
        border-radius: .5rem;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6366f1;
        font-size: .8rem;
        flex-shrink: 0;
    }
    .esh-contact-text {
        font-size: .78rem;
        color: #475569;
        font-weight: 500;
        word-break: break-all;
    }
    .esh-contact-label {
        font-size: .65rem;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    /* ── Details Card (Right) ── */
    .esh-detail-section {
        padding: 0;
    }
    .esh-detail-row {
        display: flex;
        align-items: flex-start;
        padding: .85rem 1.5rem;
        transition: background .15s;
    }
    .esh-detail-row:hover {
        background: #fafaff;
    }
    .esh-detail-row:nth-child(even) {
        background: #fafbfc;
    }
    .esh-detail-row:nth-child(even):hover {
        background: #f5f5ff;
    }
    .esh-detail-icon {
        width: 32px;
        height: 32px;
        border-radius: .5rem;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6366f1;
        font-size: .8rem;
        flex-shrink: 0;
        margin-right: 1rem;
    }
    .esh-detail-content {
        flex: 1;
    }
    .esh-detail-label {
        font-size: .65rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: .15rem;
    }
    .esh-detail-value {
        font-size: .8125rem;
        font-weight: 600;
        color: #1e293b;
    }
    .esh-detail-value .text-muted {
        color: #cbd5e1 !important;
        font-weight: 500;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .esh-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .esh-header-actions {
            width: 100%;
        }
        .btn-esh-edit, .btn-esh-back {
            flex: 1;
            justify-content: center;
        }
    }
</style>

@php
    $initials = strtoupper(collect(explode(' ', $employee->full_name))->map(fn($w) => substr($w, 0, 1))->take(2)->join(''));
    $statusClass = match($employee->employment_status) {
        'active' => 'esh-status-active',
        'inactive' => 'esh-status-inactive',
        'terminated' => 'esh-status-terminated',
        'resigned' => 'esh-status-resigned',
        default => 'esh-status-inactive',
    };
@endphp

<div class="esh-page">
    <div class="container">

        {{-- ── Flash Messages ── --}}
        @if (session('success'))
            <div class="esh-flash esh-flash-success fade-up">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- ── Page Header ── --}}
        <div class="esh-header fade-up">
            <div>
                <h1 class="esh-header-title">
                    <i class="bi bi-person-badge"></i>Employee Profile
                </h1>
                <p class="esh-header-sub">View complete employee details and information</p>
            </div>
            <div class="esh-header-actions">
                <a href="{{ route('admin.employees.edit', $employee) }}" class="btn-esh-edit">
                    <i class="bi bi-pencil-square"></i> Edit Employee
                </a>
                <a href="{{ route('admin.employees.index') }}" class="btn-esh-back">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row g-4">
            {{-- ══════════ Left Column: Profile Card ══════════ --}}
            <div class="col-lg-4">
                <div class="esh-card fade-up fade-up-d1">
                    <div class="esh-profile-card">
                        {{-- Avatar --}}
                        <div class="esh-avatar">
                            @if ($employee->photo)
                                <img src="{{ asset('storage/' . $employee->photo) }}" alt="{{ $employee->full_name }}">
                            @else
                                {{ $initials }}
                            @endif
                        </div>

                        {{-- Name & Code --}}
                        <h2 class="esh-profile-name">{{ $employee->full_name }}</h2>
                        <div class="esh-profile-code">
                            <i class="bi bi-hash" style="font-size: .65rem;"></i>
                            {{ $employee->employee_code }}
                        </div>

                        <div class="esh-profile-designation">
                            {{ $employee->designation->name ?? 'No Designation' }}
                        </div>
                        <div class="esh-profile-department">
                            <i class="bi bi-building" style="font-size: .7rem; margin-right: .2rem;"></i>
                            {{ $employee->department->name ?? 'No Department' }}
                        </div>

                        <div class="esh-profile-divider"></div>

                        {{-- Status --}}
                        <div style="margin-bottom: 1.25rem;">
                            <span class="esh-status-badge {{ $statusClass }}">
                                <span class="esh-status-dot"></span>
                                {{ ucfirst($employee->employment_status) }}
                            </span>
                        </div>

                        {{-- Quick Contact --}}
                        <ul class="esh-contact-list">
                            <li class="esh-contact-item">
                                <div class="esh-contact-icon">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div>
                                    <div class="esh-contact-label">Email</div>
                                    <div class="esh-contact-text">{{ $employee->user->email ?? 'N/A' }}</div>
                                </div>
                            </li>
                            <li class="esh-contact-item">
                                <div class="esh-contact-icon">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <div>
                                    <div class="esh-contact-label">Phone</div>
                                    <div class="esh-contact-text">{{ $employee->phone ?? 'N/A' }}</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- ══════════ Right Column: Details Card ══════════ --}}
            <div class="col-lg-8">
                {{-- Personal Information --}}
                <div class="esh-card fade-up fade-up-d2" style="margin-bottom: 1.25rem;">
                    <div class="esh-card-header">
                        <i class="bi bi-person"></i>
                        <h5>Personal Information</h5>
                    </div>
                    <div class="esh-detail-section">
                        <div class="esh-detail-row">
                            <div class="esh-detail-icon">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div class="esh-detail-content">
                                <div class="esh-detail-label">Full Name</div>
                                <div class="esh-detail-value">{{ $employee->full_name }}</div>
                            </div>
                        </div>
                        <div class="esh-detail-row">
                            <div class="esh-detail-icon">
                                <i class="bi bi-gender-ambiguous"></i>
                            </div>
                            <div class="esh-detail-content">
                                <div class="esh-detail-label">Gender</div>
                                <div class="esh-detail-value">{{ ucfirst($employee->gender ?? 'N/A') }}</div>
                            </div>
                        </div>
                        <div class="esh-detail-row">
                            <div class="esh-detail-icon">
                                <i class="bi bi-calendar-heart"></i>
                            </div>
                            <div class="esh-detail-content">
                                <div class="esh-detail-label">Date of Birth</div>
                                <div class="esh-detail-value">
                                    @if ($employee->date_of_birth)
                                        {{ $employee->date_of_birth->format('d M Y') }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="esh-detail-row">
                            <div class="esh-detail-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="esh-detail-content">
                                <div class="esh-detail-label">Address</div>
                                <div class="esh-detail-value">{{ $employee->address ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Employment Information --}}
                <div class="esh-card fade-up fade-up-d3">
                    <div class="esh-card-header">
                        <i class="bi bi-briefcase"></i>
                        <h5>Employment Information</h5>
                    </div>
                    <div class="esh-detail-section">
                        <div class="esh-detail-row">
                            <div class="esh-detail-icon">
                                <i class="bi bi-hash"></i>
                            </div>
                            <div class="esh-detail-content">
                                <div class="esh-detail-label">Employee Code</div>
                                <div class="esh-detail-value" style="font-family: 'SF Mono', 'Fira Code', monospace;">{{ $employee->employee_code }}</div>
                            </div>
                        </div>
                        <div class="esh-detail-row">
                            <div class="esh-detail-icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="esh-detail-content">
                                <div class="esh-detail-label">Department</div>
                                <div class="esh-detail-value">{{ $employee->department->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="esh-detail-row">
                            <div class="esh-detail-icon">
                                <i class="bi bi-award"></i>
                            </div>
                            <div class="esh-detail-content">
                                <div class="esh-detail-label">Designation</div>
                                <div class="esh-detail-value">{{ $employee->designation->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="esh-detail-row">
                            <div class="esh-detail-icon">
                                <i class="bi bi-person-check"></i>
                            </div>
                            <div class="esh-detail-content">
                                <div class="esh-detail-label">Reporting Manager</div>
                                <div class="esh-detail-value">
                                    @if ($employee->manager)
                                        {{ $employee->manager->name }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="esh-detail-row">
                            <div class="esh-detail-icon">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div class="esh-detail-content">
                                <div class="esh-detail-label">Joining Date</div>
                                <div class="esh-detail-value">
                                    @if ($employee->joining_date)
                                        {{ $employee->joining_date->format('d M Y') }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="esh-detail-row">
                            <div class="esh-detail-icon">
                                <i class="bi bi-activity"></i>
                            </div>
                            <div class="esh-detail-content">
                                <div class="esh-detail-label">Employment Status</div>
                                <div class="esh-detail-value">
                                    <span class="esh-status-badge {{ $statusClass }}" style="font-size: .7rem;">
                                        <span class="esh-status-dot"></span>
                                        {{ ucfirst($employee->employment_status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Bottom Action Bar ── --}}
        <div class="fade-up fade-up-d4" style="display: flex; justify-content: space-between; margin-top: 1.5rem;">
            <a href="{{ route('admin.employees.index') }}" class="btn-esh-back">
                <i class="bi bi-arrow-left"></i> Back to Employees
            </a>
            <a href="{{ route('admin.employees.edit', $employee) }}" class="btn-esh-edit">
                <i class="bi bi-pencil-square"></i> Edit Employee
            </a>
        </div>

    </div>
</div>
@endsection
