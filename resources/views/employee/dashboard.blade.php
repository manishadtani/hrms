@extends('layouts.app')

@section('content')
<style>
    .emp-dash {
        --primary: #0891b2;
        --primary-light: #06b6d4;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #06b6d4;
        --indigo: #6366f1;
        --sky: #0ea5e9;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* ── Greeting Banner ── */
    .greeting-section {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 50%, #0e7490 100%);
        border-radius: 20px;
        padding: 32px 36px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
    }
    .greeting-section::before {
        content: '';
        position: absolute;
        right: -40px;
        top: -40px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .greeting-section::after {
        content: '';
        position: absolute;
        right: 60px;
        bottom: -60px;
        width: 160px;
        height: 160px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .greeting-section h2 {
        font-size: 1.75rem;
        font-weight: 700;
        letter-spacing: -0.5px;
        margin-bottom: 6px;
    }
    .greeting-section p {
        opacity: 0.85;
        font-size: 0.95rem;
        margin: 0;
    }
    .greeting-meta {
        display: flex;
        gap: 12px;
        margin-top: 16px;
        flex-wrap: wrap;
    }
    .greeting-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        opacity: 0.9;
        background: rgba(255,255,255,0.15);
        padding: 5px 14px;
        border-radius: 20px;
    }

    /* ── Clock In/Out Card ── */
    .clock-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        padding: 28px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        transition: box-shadow 0.3s;
    }
    .clock-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
    }
    .clock-card .clock-bar {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #06b6d4, #0891b2, #10b981);
    }
    .clock-status-row {
        display: flex;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
    }
    .clock-icon-wrap {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        flex-shrink: 0;
    }
    .clock-info { flex: 1; min-width: 180px; }
    .clock-info h5 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px;
    }
    .clock-info p {
        font-size: 0.85rem;
        color: #64748b;
        margin: 0;
    }
    .clock-times {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }
    .clock-time-item {
        text-align: center;
    }
    .clock-time-item .label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        color: #94a3b8;
        margin-bottom: 4px;
    }
    .clock-time-item .time {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.5px;
    }
    .clock-btn {
        padding: 12px 32px;
        border: none;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 700;
        color: #fff;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        flex-shrink: 0;
    }
    .clock-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }
    .clock-btn-in {
        background: linear-gradient(135deg, #10b981, #059669);
    }
    .clock-btn-out {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }
    .clock-btn-done {
        background: linear-gradient(135deg, #94a3b8, #64748b);
        cursor: default;
    }
    .clock-btn-done:hover {
        transform: none;
        box-shadow: none;
    }

    /* ── Stat Cards ── */
    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #f1f5f9;
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        position: relative;
        overflow: hidden;
        height: 100%;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    }
    .stat-card .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 16px;
    }
    .stat-card .stat-value {
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -1px;
        line-height: 1;
        margin-bottom: 4px;
    }
    .stat-card .stat-label {
        font-size: 0.82rem;
        color: #64748b;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-card .stat-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 0 0 16px 16px;
    }

    .icon-emerald { background: #ecfdf5; color: #10b981; }
    .icon-amber { background: #fffbeb; color: #f59e0b; }
    .icon-indigo { background: #eef2ff; color: #6366f1; }
    .icon-sky { background: #ecfeff; color: #06b6d4; }
    .icon-rose { background: #fff1f2; color: #f43f5e; }
    .icon-violet { background: #f5f3ff; color: #8b5cf6; }
    .icon-teal { background: #f0fdfa; color: #14b8a6; }

    .bar-emerald { background: linear-gradient(90deg, #10b981, #34d399); }
    .bar-amber { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .bar-indigo { background: linear-gradient(90deg, #6366f1, #818cf8); }
    .bar-sky { background: linear-gradient(90deg, #0ea5e9, #38bdf8); }

    /* ── Section Cards ── */
    .section-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        overflow: hidden;
        height: 100%;
        transition: box-shadow 0.3s;
    }
    .section-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
    }
    .section-header {
        padding: 20px 24px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .section-header h6 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-header .header-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
    }
    .section-header a {
        font-size: 0.8rem;
        color: #0891b2;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }
    .section-header a:hover { color: #0e7490; }
    .section-body { padding: 16px 24px 24px; }

    /* ── Leave Balance Cards ── */
    .leave-balance-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px 0;
        border-bottom: 1px solid #f8fafc;
        transition: background 0.2s;
    }
    .leave-balance-item:last-child { border-bottom: none; }
    .leave-balance-item:hover { background: #fafafe; margin: 0 -24px; padding-left: 24px; padding-right: 24px; }
    .leave-type-dot {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        flex-shrink: 0;
    }
    .leave-bal-info { flex: 1; min-width: 0; }
    .leave-bal-info h6 {
        font-size: 0.88rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 6px;
    }
    .leave-progress-wrap {
        width: 100%;
        height: 7px;
        background: #f1f5f9;
        border-radius: 4px;
        overflow: hidden;
    }
    .leave-progress-bar {
        height: 100%;
        border-radius: 4px;
        transition: width 1s ease;
    }
    .leave-bal-nums {
        display: flex;
        justify-content: space-between;
        margin-top: 4px;
    }
    .leave-bal-nums small {
        font-size: 0.72rem;
        color: #94a3b8;
        font-weight: 500;
    }
    .leave-bal-nums .remaining {
        font-weight: 700;
        color: #1e293b;
    }

    /* ── Holiday Item ── */
    .holiday-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #f8fafc;
        transition: background 0.2s;
    }
    .holiday-item:last-child { border-bottom: none; }
    .holiday-item:hover { background: #fafafe; margin: 0 -24px; padding-left: 24px; padding-right: 24px; }
    .holiday-date-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .holiday-date-box .day {
        font-size: 1.1rem;
        font-weight: 800;
        line-height: 1;
    }
    .holiday-date-box .month {
        font-size: 0.6rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .holiday-info h6 { font-size: 0.88rem; font-weight: 600; color: #1e293b; margin: 0; }
    .holiday-info small { font-size: 0.75rem; color: #94a3b8; }
    .holiday-type-badge {
        font-size: 0.65rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-left: auto;
        flex-shrink: 0;
    }

    /* ── Announcement ── */
    .announce-item {
        padding: 14px 0;
        border-bottom: 1px solid #f8fafc;
    }
    .announce-item:last-child { border-bottom: none; }
    .announce-item h6 { font-size: 0.88rem; font-weight: 600; color: #1e293b; margin: 0 0 4px; }
    .announce-item p { font-size: 0.8rem; color: #64748b; margin: 0 0 4px; }
    .announce-item .announce-meta {
        font-size: 0.72rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ── Quick Actions ── */
    .quick-action {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-radius: 14px;
        border: 1px solid #f1f5f9;
        text-decoration: none;
        color: #334155;
        transition: all 0.25s ease;
        font-size: 0.88rem;
        font-weight: 600;
    }
    .quick-action:hover {
        background: #f8fafc;
        border-color: #e2e8f0;
        transform: translateX(4px);
        color: #0891b2;
    }
    .quick-action .qa-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .quick-action .qa-arrow {
        margin-left: auto;
        color: #cbd5e1;
        transition: color 0.2s;
    }
    .quick-action:hover .qa-arrow { color: #0891b2; }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .greeting-section { padding: 24px 20px; border-radius: 16px; }
        .greeting-section h2 { font-size: 1.4rem; }
        .greeting-meta { flex-wrap: wrap; gap: 8px; }
        .stat-card { padding: 18px; }
        .stat-card .stat-value { font-size: 1.6rem; }
        .clock-status-row { gap: 16px; }
        .clock-card { padding: 20px; }
        .clock-times { gap: 16px; }
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
    .fade-up:nth-child(1) { animation-delay: 0.05s; }
    .fade-up:nth-child(2) { animation-delay: 0.1s; }
    .fade-up:nth-child(3) { animation-delay: 0.15s; }
    .fade-up:nth-child(4) { animation-delay: 0.2s; }
    .fade-up:nth-child(5) { animation-delay: 0.25s; }
    .fade-up:nth-child(6) { animation-delay: 0.3s; }
    .fade-up:nth-child(7) { animation-delay: 0.35s; }

    .count-up { display: inline-block; }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 1.5s ease-in-out infinite;
    }
</style>

<div class="emp-dash">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:12px;border:none;background:#ecfdf5;color:#166534;">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:12px;border:none;background:#fef2f2;color:#991b1b;">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════
         1. GREETING BANNER
    ═══════════════════════════════════════════════ --}}
    <div class="greeting-section fade-up">
        <h2>Welcome back, {{ $employee->first_name }}! 👋</h2>
        <p>Here's your workday overview at a glance.</p>
        <div class="greeting-meta">
            <span><i class="bi bi-calendar3"></i> {{ now()->format('l, d M Y') }}</span>
            <span><i class="bi bi-clock"></i> {{ now()->format('h:i A') }}</span>
            <span><i class="bi bi-person-badge"></i> {{ $employee->employee_code }}</span>
            @if($employee->department)
                <span><i class="bi bi-building"></i> {{ $employee->department->name ?? $employee->department }}</span>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         2. CLOCK IN / OUT SECTION
    ═══════════════════════════════════════════════ --}}
    <div class="clock-card fade-up">
        <div class="clock-bar"></div>
        <div class="clock-status-row">
            {{-- Status Icon --}}
            @if(!$todayAttendance)
                {{-- Not clocked in yet --}}
                <div class="clock-icon-wrap" style="background:#ecfdf5;color:#10b981;">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>
                <div class="clock-info">
                    <h5><span class="pulse-dot" style="background:#f59e0b;margin-right:8px;"></span> Not Clocked In</h5>
                    <p>You haven't started your workday yet. Clock in to begin.</p>
                </div>
                <form action="{{ route('employee.attendance.clock-in') }}" method="POST" class="gps-form">
                    @csrf
                    <input type="hidden" name="latitude" class="gps-lat">
                    <input type="hidden" name="longitude" class="gps-lng">
                    <button type="submit" class="clock-btn clock-btn-in">
                        <i class="bi bi-play-circle-fill"></i> Clock In
                    </button>
                </form>
            @elseif($todayAttendance && !$todayAttendance->clock_out)
                {{-- Clocked in, not yet clocked out --}}
                <div class="clock-icon-wrap" style="background:#ecfdf5;color:#10b981;">
                    <i class="bi bi-clock-fill"></i>
                </div>
                <div class="clock-info">
                    <h5><span class="pulse-dot" style="background:#10b981;margin-right:8px;"></span> Currently Working</h5>
                    <p>You are clocked in. Don't forget to clock out when you leave.</p>
                </div>
                <div class="clock-times">
                    <div class="clock-time-item">
                        <div class="label">Clock In</div>
                        <div class="time" style="color:#10b981;">{{ \Carbon\Carbon::parse($todayAttendance->clock_in)->format('h:i A') }}</div>
                    </div>
                </div>
                <form action="{{ route('employee.attendance.clock-out') }}" method="POST" class="gps-form">
                    @csrf
                    <input type="hidden" name="latitude" class="gps-lat">
                    <input type="hidden" name="longitude" class="gps-lng">
                    <button type="submit" class="clock-btn clock-btn-out">
                        <i class="bi bi-stop-circle-fill"></i> Clock Out
                    </button>
                </form>
            @else
                {{-- Fully clocked in and out --}}
                <div class="clock-icon-wrap" style="background:#f1f5f9;color:#64748b;">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="clock-info">
                    <h5><i class="bi bi-check-circle-fill" style="color:#10b981;margin-right:6px;font-size:0.9rem;"></i> Day Complete</h5>
                    <p>Your workday is recorded. See you tomorrow!</p>
                </div>
                <div class="clock-times">
                    <div class="clock-time-item">
                        <div class="label">Clock In</div>
                        <div class="time" style="color:#10b981;">{{ \Carbon\Carbon::parse($todayAttendance->clock_in)->format('h:i A') }}</div>
                    </div>
                    <div class="clock-time-item">
                        <div class="label">Clock Out</div>
                        <div class="time" style="color:#ef4444;">{{ \Carbon\Carbon::parse($todayAttendance->clock_out)->format('h:i A') }}</div>
                    </div>
                </div>
                <span class="clock-btn clock-btn-done">
                    <i class="bi bi-check2-all"></i> Done
                </span>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         3. STAT CARDS ROW
    ═══════════════════════════════════════════════ --}}
    @php
        $totalLeaveRemaining = $leaveBalances->sum('remaining');
        $currentMonthWorkingDays = (int) collect(range(1, now()->daysInMonth))->filter(function($day) {
            $date = now()->copy()->day($day);
            return !in_array($date->dayOfWeek, [0, 6]); // exclude Sat/Sun
        })->count();
    @endphp

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3 fade-up">
            <div class="stat-card">
                <div class="stat-icon icon-emerald"><i class="bi bi-calendar-check-fill"></i></div>
                <div class="stat-value count-up" data-target="{{ $monthlyPresent }}">0</div>
                <div class="stat-label">Present This Month</div>
                <div class="stat-bar bar-emerald"></div>
            </div>
        </div>
        <div class="col-6 col-lg-3 fade-up">
            <div class="stat-card">
                <div class="stat-icon icon-amber"><i class="bi bi-hourglass-split"></i></div>
                <div class="stat-value count-up" data-target="{{ $pendingLeaves }}">0</div>
                <div class="stat-label">Pending Leaves</div>
                <div class="stat-bar bar-amber"></div>
            </div>
        </div>
        <div class="col-6 col-lg-3 fade-up">
            <div class="stat-card">
                <div class="stat-icon icon-indigo"><i class="bi bi-calendar2-heart-fill"></i></div>
                <div class="stat-value count-up" data-target="{{ $totalLeaveRemaining }}">0</div>
                <div class="stat-label">Leave Balance</div>
                <div class="stat-bar bar-indigo"></div>
            </div>
        </div>
        <div class="col-6 col-lg-3 fade-up">
            <div class="stat-card">
                <div class="stat-icon icon-sky"><i class="bi bi-briefcase-fill"></i></div>
                <div class="stat-value count-up" data-target="{{ $currentMonthWorkingDays }}">0</div>
                <div class="stat-label">Working Days (Month)</div>
                <div class="stat-bar bar-sky"></div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         4. LEAVE BALANCES + QUICK ACTIONS
    ═══════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">
        {{-- Leave Balances --}}
        <div class="col-lg-8 fade-up">
            <div class="section-card">
                <div class="section-header">
                    <h6><span class="header-icon icon-indigo"><i class="bi bi-pie-chart-fill"></i></span> Leave Balances</h6>
                    <a href="{{ route('employee.leaves.index') }}">View All</a>
                </div>
                <div class="section-body">
                    @php
                        $leaveColors = ['#6366f1','#10b981','#f59e0b','#f43f5e','#06b6d4','#8b5cf6','#ec4899','#14b8a6','#0ea5e9','#d946ef'];
                    @endphp
                    @forelse($leaveBalances as $i => $balance)
                        @php
                            $color = $leaveColors[$i % count($leaveColors)];
                            $pct = $balance['total'] > 0 ? round(($balance['used'] / $balance['total']) * 100) : 0;
                            $initials = strtoupper(substr($balance['type']->name ?? 'L', 0, 2));
                        @endphp
                        <div class="leave-balance-item">
                            <div class="leave-type-dot" style="background:{{ $color }}15;color:{{ $color }};">
                                {{ $initials }}
                            </div>
                            <div class="leave-bal-info">
                                <h6>{{ $balance['type']->name ?? 'Leave' }}</h6>
                                <div class="leave-progress-wrap">
                                    <div class="leave-progress-bar" style="width:{{ $pct }}%;background:{{ $color }};"></div>
                                </div>
                                <div class="leave-bal-nums">
                                    <small>{{ $balance['used'] }} used of {{ $balance['total'] }}</small>
                                    <small class="remaining">{{ $balance['remaining'] }} remaining</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-inbox text-muted" style="font-size:2rem;"></i>
                            <p class="text-muted mb-0 mt-2" style="font-size:0.85rem;">No leave balances configured</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-lg-4 fade-up">
            <div class="section-card">
                <div class="section-header">
                    <h6><span class="header-icon icon-violet"><i class="bi bi-lightning-fill"></i></span> Quick Actions</h6>
                </div>
                <div class="section-body">
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('employee.attendance.index') }}" class="quick-action">
                            <span class="qa-icon icon-emerald"><i class="bi bi-clock-fill"></i></span>
                            My Attendance
                            <i class="bi bi-chevron-right qa-arrow"></i>
                        </a>
                        <a href="{{ route('employee.leaves.create') }}" class="quick-action">
                            <span class="qa-icon icon-amber"><i class="bi bi-plus-circle-fill"></i></span>
                            Apply Leave
                            <i class="bi bi-chevron-right qa-arrow"></i>
                        </a>
                        <a href="{{ route('employee.leaves.index') }}" class="quick-action">
                            <span class="qa-icon icon-indigo"><i class="bi bi-calendar2-check"></i></span>
                            My Leaves
                            @if($pendingLeaves > 0)
                                <span class="badge rounded-pill" style="background:#fef3c7;color:#92400e;margin-left:auto;margin-right:4px;">{{ $pendingLeaves }}</span>
                            @endif
                            <i class="bi bi-chevron-right qa-arrow"></i>
                        </a>
                        <a href="{{ route('employee.profile.show') }}" class="quick-action">
                            <span class="qa-icon icon-sky"><i class="bi bi-person-circle"></i></span>
                            My Profile
                            <i class="bi bi-chevron-right qa-arrow"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         5. UPCOMING HOLIDAYS + 6. ANNOUNCEMENTS
    ═══════════════════════════════════════════════ --}}
    <div class="row g-3 mb-4">
        {{-- Upcoming Holidays --}}
        <div class="col-lg-5 fade-up">
            <div class="section-card">
                <div class="section-header">
                    <h6><span class="header-icon icon-emerald"><i class="bi bi-calendar-event-fill"></i></span> Upcoming Holidays</h6>
                </div>
                <div class="section-body">
                    @forelse($upcomingHolidays as $holiday)
                        @php
                            $hColors = [
                                'national' => ['#dbeafe','#2563eb'],
                                'regional' => ['#fef3c7','#d97706'],
                                'company'  => ['#dcfce7','#16a34a'],
                                'optional' => ['#f3e8ff','#7c3aed'],
                            ];
                            $hc = $hColors[$holiday->type] ?? ['#f1f5f9','#475569'];
                        @endphp
                        <div class="holiday-item">
                            <div class="holiday-date-box" style="background:{{ $hc[0] }};color:{{ $hc[1] }};">
                                <span class="day">{{ $holiday->date->format('d') }}</span>
                                <span class="month">{{ $holiday->date->format('M') }}</span>
                            </div>
                            <div class="holiday-info">
                                <h6>{{ $holiday->name }}</h6>
                                <small>{{ $holiday->date->format('l') }}</small>
                            </div>
                            <span class="holiday-type-badge" style="background:{{ $hc[0] }};color:{{ $hc[1] }};">
                                {{ ucfirst($holiday->type) }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x text-muted" style="font-size:2rem;"></i>
                            <p class="text-muted mb-0 mt-2" style="font-size:0.85rem;">No upcoming holidays</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Recent Announcements --}}
        <div class="col-lg-7 fade-up">
            <div class="section-card">
                <div class="section-header">
                    <h6><span class="header-icon icon-sky"><i class="bi bi-megaphone-fill"></i></span> Announcements</h6>
                </div>
                <div class="section-body">
                    @forelse($recentAnnouncements as $announcement)
                        <div class="announce-item">
                            <h6>{{ Str::limit($announcement->title, 60) }}</h6>
                            <p>{{ Str::limit($announcement->content, 120) }}</p>
                            <div class="announce-meta">
                                <span><i class="bi bi-person-fill"></i> {{ $announcement->creator->name ?? 'System' }}</span>
                                <span>·</span>
                                <span><i class="bi bi-clock"></i> {{ $announcement->published_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-megaphone text-muted" style="font-size:2rem;"></i>
                            <p class="text-muted mb-0 mt-2" style="font-size:0.85rem;">No announcements</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Counter Animation Script (Pure JS, no libraries) --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.count-up').forEach(function(el) {
        var target = parseInt(el.getAttribute('data-target')) || 0;
        if (target === 0) { el.textContent = '0'; return; }
        var duration = 800;
        var step = Math.max(1, Math.floor(target / (duration / 16)));
        var current = 0;
        var timer = setInterval(function() {
            current += step;
            if (current >= target) { current = target; clearInterval(timer); }
            el.textContent = current;
        }, 16);
    });
});
</script>

<script>
// GPS Location for Clock In/Out
(function() {
    let userLat = null, userLng = null, gpsReady = false;

    // Try to get location on page load
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(pos) {
                userLat = pos.coords.latitude;
                userLng = pos.coords.longitude;
                gpsReady = true;
                // Fill all GPS fields
                document.querySelectorAll('.gps-lat').forEach(el => el.value = userLat);
                document.querySelectorAll('.gps-lng').forEach(el => el.value = userLng);
            },
            function(err) {
                console.log('GPS not available:', err.message);
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    }

    // On form submit, get fresh GPS if possible
    document.querySelectorAll('.gps-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (gpsReady) {
                form.querySelector('.gps-lat').value = userLat;
                form.querySelector('.gps-lng').value = userLng;
            } else if (navigator.geolocation) {
                e.preventDefault();
                navigator.geolocation.getCurrentPosition(
                    function(pos) {
                        form.querySelector('.gps-lat').value = pos.coords.latitude;
                        form.querySelector('.gps-lng').value = pos.coords.longitude;
                        form.submit();
                    },
                    function() {
                        // GPS failed — submit anyway, server will handle
                        form.submit();
                    },
                    { enableHighAccuracy: true, timeout: 5000 }
                );
            }
        });
    });
})();
</script>
@endsection
