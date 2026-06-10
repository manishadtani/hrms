@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    .team-page {
        font-family: 'Inter', sans-serif;
        padding: 2rem 0 4rem;
        background: linear-gradient(135deg, #f0f4ff 0%, #faf5ff 50%, #fff1f2 100%);
        min-height: 100vh;
    }

    /* ── Page Header ── */
    .team-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .team-page-header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .team-page-header-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.5rem;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
    }

    .team-page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
        letter-spacing: -0.025em;
    }

    .team-page-subtitle {
        font-size: 0.85rem;
        color: #94a3b8;
        margin: 0;
        font-weight: 400;
    }

    .team-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.45rem 1rem;
        border-radius: 50px;
        box-shadow: 0 2px 10px rgba(99, 102, 241, 0.3);
    }

    /* ── Flash Messages ── */
    .team-flash {
        padding: 1rem 1.25rem;
        border-radius: 14px;
        font-size: 0.88rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        animation: fadeUp 0.5s ease-out;
    }

    .team-flash-success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .team-flash-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .team-flash-warning {
        background: #fffbeb;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    /* ── Status Summary Cards ── */
    .status-summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2.5rem;
    }

    .status-summary-card {
        background: #fff;
        border-radius: 18px;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.03);
        border: 1px solid rgba(0,0,0,0.04);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        animation: fadeUp 0.5s ease-out both;
    }

    .status-summary-card:nth-child(1) { animation-delay: 0.05s; }
    .status-summary-card:nth-child(2) { animation-delay: 0.1s; }
    .status-summary-card:nth-child(3) { animation-delay: 0.15s; }
    .status-summary-card:nth-child(4) { animation-delay: 0.2s; }

    .status-summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .status-summary-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .status-summary-icon.working {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #16a34a;
    }

    .status-summary-icon.completed {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #2563eb;
    }

    .status-summary-icon.on-leave {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #d97706;
    }

    .status-summary-icon.absent {
        background: linear-gradient(135deg, #ffe4e6, #fecdd3);
        color: #e11d48;
    }

    .status-summary-info h4 {
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0;
        color: #1e293b;
        line-height: 1;
    }

    .status-summary-info span {
        font-size: 0.78rem;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .pulse-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #22c55e;
        animation: pulse 1.8s ease-in-out infinite;
        margin-right: 4px;
        vertical-align: middle;
    }

    .pulse-dot-amber {
        background: #f59e0b;
    }

    .pulse-dot-blue {
        background: #3b82f6;
    }

    .pulse-dot-rose {
        background: #f43f5e;
    }

    /* ── Team Cards Grid ── */
    .team-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .team-member-card {
        background: #fff;
        border-radius: 20px;
        padding: 0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04), 0 6px 20px rgba(0,0,0,0.03);
        border: 1px solid rgba(0,0,0,0.04);
        transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.3s ease;
        overflow: hidden;
        position: relative;
        animation: fadeUp 0.5s ease-out both;
    }

    .team-member-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.1);
    }

    .team-card-body {
        padding: 1.75rem 1.5rem 1.25rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .team-card-avatar {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 1rem;
        position: relative;
        box-shadow: 0 4px 14px rgba(0,0,0,0.12);
        overflow: hidden;
    }

    .team-card-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .team-card-avatar.status-working {
        background: linear-gradient(135deg, #22c55e, #16a34a);
    }

    .team-card-avatar.status-completed {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }

    .team-card-avatar.status-on-leave {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .team-card-avatar.status-absent {
        background: linear-gradient(135deg, #f43f5e, #e11d48);
    }

    .team-card-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .team-card-designation {
        font-size: 0.8rem;
        color: #94a3b8;
        font-weight: 500;
        margin: 0.15rem 0 0.75rem;
    }

    .team-card-dept-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        background: #f1f5f9;
        color: #475569;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.3rem 0.75rem;
        border-radius: 50px;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
    }

    .team-card-contact {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        width: 100%;
        margin-bottom: 1rem;
    }

    .team-card-contact-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 400;
        justify-content: center;
    }

    .team-card-contact-item i {
        color: #94a3b8;
        font-size: 0.82rem;
        width: 16px;
        text-align: center;
    }

    .team-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 0.9rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        background: #fafbfc;
    }

    .team-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.73rem;
        font-weight: 600;
        padding: 0.3rem 0.7rem;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .team-status-badge.working {
        background: #dcfce7;
        color: #15803d;
    }

    .team-status-badge.completed {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .team-status-badge.on-leave {
        background: #fef3c7;
        color: #b45309;
    }

    .team-status-badge.absent {
        background: #ffe4e6;
        color: #be123c;
    }

    .team-clock-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.72rem;
        color: #94a3b8;
        font-weight: 500;
    }

    .team-clock-info i {
        font-size: 0.78rem;
    }

    .team-clock-info .clock-time {
        color: #64748b;
        font-weight: 600;
    }

    /* ── Bottom Color Bar ── */
    .team-card-bar {
        height: 4px;
        width: 100%;
        border-radius: 0 0 20px 20px;
    }

    .team-card-bar.working {
        background: linear-gradient(90deg, #22c55e, #4ade80);
    }

    .team-card-bar.completed {
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
    }

    .team-card-bar.on-leave {
        background: linear-gradient(90deg, #f59e0b, #fbbf24);
    }

    .team-card-bar.absent {
        background: linear-gradient(90deg, #f43f5e, #fb7185);
    }

    /* ── Empty State ── */
    .team-empty-state {
        text-align: center;
        padding: 5rem 2rem;
        animation: fadeUp 0.6s ease-out;
    }

    .team-empty-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2.5rem;
        color: #94a3b8;
    }

    .team-empty-state h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #334155;
        margin: 0 0 0.5rem;
    }

    .team-empty-state p {
        font-size: 0.9rem;
        color: #94a3b8;
        margin: 0;
    }

    /* ── Animations ── */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.4); }
    }

    /* ── Responsive ── */
    @media (max-width: 1199px) {
        .team-cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 991px) {
        .status-summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .team-cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 767px) {
        .status-summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .team-cards-grid {
            grid-template-columns: 1fr;
        }

        .team-page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .team-page {
            padding: 1.25rem 0 3rem;
        }
    }

    @media (max-width: 480px) {
        .status-summary-grid {
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .status-summary-card {
            padding: 1rem;
        }
    }
</style>

<div class="team-page">
    <div class="container">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="team-flash team-flash-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="team-flash team-flash-error">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="team-flash team-flash-warning">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('warning') }}
            </div>
        @endif

        {{-- Page Header --}}
        <div class="team-page-header">
            <div class="team-page-header-left">
                <div class="team-page-header-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <h1 class="team-page-title">My Team</h1>
                    <p class="team-page-subtitle">Team overview & daily attendance</p>
                </div>
            </div>
            <div class="team-count-badge">
                <i class="bi bi-person-badge"></i>
                {{ $team->count() }} {{ Str::plural('member', $team->count()) }}
            </div>
        </div>

        @if($team->count() > 0)

            {{-- Status Summary Cards --}}
            @php
                $workingCount   = $team->where('status', 'Working')->count();
                $completedCount = $team->where('status', 'Completed')->count();
                $onLeaveCount   = $team->where('status', 'On Leave')->count();
                $absentCount    = $team->where('status', 'Absent')->count();
            @endphp

            <div class="status-summary-grid">
                {{-- Working --}}
                <div class="status-summary-card">
                    <div class="status-summary-icon working">
                        <i class="bi bi-laptop"></i>
                    </div>
                    <div class="status-summary-info">
                        <h4>{{ $workingCount }}</h4>
                        <span><span class="pulse-dot"></span> Working</span>
                    </div>
                </div>

                {{-- Completed --}}
                <div class="status-summary-card">
                    <div class="status-summary-icon completed">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="status-summary-info">
                        <h4>{{ $completedCount }}</h4>
                        <span>Completed</span>
                    </div>
                </div>

                {{-- On Leave --}}
                <div class="status-summary-card">
                    <div class="status-summary-icon on-leave">
                        <i class="bi bi-calendar-x"></i>
                    </div>
                    <div class="status-summary-info">
                        <h4>{{ $onLeaveCount }}</h4>
                        <span>On Leave</span>
                    </div>
                </div>

                {{-- Absent --}}
                <div class="status-summary-card">
                    <div class="status-summary-icon absent">
                        <i class="bi bi-person-x"></i>
                    </div>
                    <div class="status-summary-info">
                        <h4>{{ $absentCount }}</h4>
                        <span>Absent</span>
                    </div>
                </div>
            </div>

            {{-- Team Cards Grid --}}
            <div class="team-cards-grid">
                @foreach($team as $index => $item)
                    @php
                        $employee  = $item['employee'];
                        $status    = $item['status'];
                        $clockIn   = $item['clock_in'];
                        $clockOut  = $item['clock_out'];

                        $nameParts = explode(' ', trim($employee->full_name));
                        $initials  = strtoupper(substr($nameParts[0] ?? '', 0, 1) . substr(end($nameParts) !== $nameParts[0] ? end($nameParts) : '', 0, 1));
                        if (strlen($initials) < 2) {
                            $initials = strtoupper(substr($employee->full_name, 0, 2));
                        }

                        $statusClass = match($status) {
                            'Working'  => 'working',
                            'Completed'=> 'completed',
                            'On Leave' => 'on-leave',
                            'Absent'   => 'absent',
                            default    => 'working',
                        };
                    @endphp

                    <div class="team-member-card" style="animation-delay: {{ 0.05 * ($index + 1) }}s;">
                        <div class="team-card-body">
                            {{-- Avatar --}}
                            <div class="team-card-avatar status-{{ $statusClass }}">
                                @if($employee->profile_photo)
                                    <img src="{{ asset('storage/' . $employee->profile_photo) }}" alt="{{ $employee->full_name }}">
                                @else
                                    {{ $initials }}
                                @endif
                            </div>

                            {{-- Name & Designation --}}
                            <h3 class="team-card-name">{{ $employee->full_name }}</h3>
                            <p class="team-card-designation">{{ $employee->designation->name ?? '—' }}</p>

                            {{-- Department Badge --}}
                            <div class="team-card-dept-badge">
                                <i class="bi bi-building"></i>
                                {{ $employee->department->name ?? '—' }}
                            </div>

                            {{-- Contact Info --}}
                            <div class="team-card-contact">
                                @if($employee->user->email ?? null)
                                    <div class="team-card-contact-item">
                                        <i class="bi bi-envelope"></i>
                                        <span>{{ $employee->user->email }}</span>
                                    </div>
                                @endif
                                @if($employee->phone)
                                    <div class="team-card-contact-item">
                                        <i class="bi bi-telephone"></i>
                                        <span>{{ $employee->phone }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Footer: Status + Clock --}}
                        <div class="team-card-footer">
                            <div class="team-status-badge {{ $statusClass }}">
                                @if($status === 'Working')
                                    <span class="pulse-dot"></span>
                                @endif
                                {{ $status }}
                            </div>
                            <div class="team-clock-info">
                                @if($clockIn)
                                    <i class="bi bi-box-arrow-in-right" style="color: #22c55e;"></i>
                                    <span class="clock-time">{{ $clockIn }}</span>
                                @endif
                                @if($clockOut)
                                    <i class="bi bi-box-arrow-right" style="color: #f43f5e; margin-left: 4px;"></i>
                                    <span class="clock-time">{{ $clockOut }}</span>
                                @endif
                                @if(!$clockIn && !$clockOut)
                                    <span>—</span>
                                @endif
                            </div>
                        </div>

                        {{-- Bottom Color Bar --}}
                        <div class="team-card-bar {{ $statusClass }}"></div>
                    </div>
                @endforeach
            </div>

        @else
            {{-- Empty State --}}
            <div class="team-empty-state">
                <div class="team-empty-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3>No team members found</h3>
                <p>Your team roster will appear here once members are assigned.</p>
            </div>
        @endif

    </div>
</div>
@endsection
