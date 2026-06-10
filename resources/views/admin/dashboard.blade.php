@extends('layouts.app')

@section('content')
<style>
    .admin-dash {
        --primary: #6366f1;
        --primary-light: #818cf8;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #06b6d4;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Greeting Section */
    .greeting-section {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a78bfa 100%);
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
        gap: 20px;
        margin-top: 16px;
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

    /* Stat Cards */
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
    .stat-card .stat-trend {
        position: absolute;
        right: 20px;
        bottom: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 3px;
        padding: 3px 10px;
        border-radius: 20px;
    }
    .stat-card .stat-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 0 0 16px 16px;
    }

    .icon-indigo { background: #eef2ff; color: #6366f1; }
    .icon-emerald { background: #ecfdf5; color: #10b981; }
    .icon-amber { background: #fffbeb; color: #f59e0b; }
    .icon-rose { background: #fff1f2; color: #f43f5e; }
    .icon-sky { background: #ecfeff; color: #06b6d4; }
    .icon-violet { background: #f5f3ff; color: #8b5cf6; }

    .bar-indigo { background: linear-gradient(90deg, #6366f1, #818cf8); }
    .bar-emerald { background: linear-gradient(90deg, #10b981, #34d399); }
    .bar-amber { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .bar-rose { background: linear-gradient(90deg, #f43f5e, #fb7185); }
    .bar-sky { background: linear-gradient(90deg, #06b6d4, #22d3ee); }

    /* Section Cards */
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
        color: #6366f1;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }
    .section-header a:hover { color: #4f46e5; }

    .section-body { padding: 16px 24px 24px; }

    /* Department Progress */
    .dept-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f8fafc;
        transition: background 0.2s;
    }
    .dept-item:last-child { border-bottom: none; }
    .dept-item:hover { background: #fafafe; margin: 0 -24px; padding-left: 24px; padding-right: 24px; }
    .dept-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .dept-name {
        flex: 1;
        font-size: 0.88rem;
        font-weight: 500;
        color: #334155;
    }
    .dept-bar-wrap {
        width: 100px;
        height: 6px;
        background: #f1f5f9;
        border-radius: 3px;
        overflow: hidden;
    }
    .dept-bar {
        height: 100%;
        border-radius: 3px;
        transition: width 1s ease;
    }
    .dept-count {
        font-size: 0.82rem;
        font-weight: 700;
        color: #1e293b;
        min-width: 28px;
        text-align: right;
    }

    /* Holiday Item */
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

    /* Leave Request Item */
    .leave-item {
        display: flex;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #f8fafc;
        gap: 14px;
    }
    .leave-item:last-child { border-bottom: none; }
    .leave-avatar {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .leave-info { flex: 1; }
    .leave-info h6 { font-size: 0.88rem; font-weight: 600; color: #1e293b; margin: 0 0 2px; }
    .leave-info small { font-size: 0.75rem; color: #94a3b8; }
    .leave-badge {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .badge-pending { background: #fef3c7; color: #92400e; }
    .badge-approved { background: #dcfce7; color: #166534; }
    .badge-rejected { background: #fee2e2; color: #991b1b; }
    .badge-cancelled { background: #f1f5f9; color: #475569; }

    /* Announcement */
    .announce-item {
        padding: 14px 0;
        border-bottom: 1px solid #f8fafc;
    }
    .announce-item:last-child { border-bottom: none; }
    .announce-item h6 { font-size: 0.88rem; font-weight: 600; color: #1e293b; margin: 0 0 4px; }
    .announce-item p { font-size: 0.8rem; color: #64748b; margin: 0; }

    /* Quick Actions */
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
        color: #6366f1;
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

    /* Donut chart */
    .donut-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 24px;
        padding: 8px 0;
    }
    .donut-chart {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .donut-center {
        position: absolute;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .donut-center .val { font-size: 1.5rem; font-weight: 800; color: #1e293b; line-height: 1; }
    .donut-center .lbl { font-size: 0.65rem; color: #94a3b8; text-transform: uppercase; font-weight: 600; }
    .donut-legend { display: flex; flex-direction: column; gap: 8px; }
    .legend-item { display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #475569; }
    .legend-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .legend-val { font-weight: 700; margin-left: auto; min-width: 20px; text-align: right; }

    /* Responsive */
    @media (max-width: 768px) {
        .greeting-section { padding: 24px 20px; border-radius: 16px; }
        .greeting-section h2 { font-size: 1.4rem; }
        .greeting-meta { flex-wrap: wrap; gap: 8px; }
        .stat-card { padding: 18px; }
        .stat-card .stat-value { font-size: 1.6rem; }
        .donut-container { flex-direction: column; }
    }

    /* Animations */
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

    /* Counter Animation */
    .count-up { display: inline-block; }
</style>

<div class="admin-dash">

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

    {{-- Greeting Banner --}}
    <div class="greeting-section fade-up">
        <h2>Welcome back, {{ Auth::user()->name }}! 👋</h2>
        <p>Here's what's happening in your organization today.</p>
        <div class="greeting-meta">
            <span><i class="bi bi-calendar3"></i> {{ now()->format('l, d M Y') }}</span>
            <span><i class="bi bi-clock"></i> {{ now()->format('h:i A') }}</span>
            <span><i class="bi bi-shield-check"></i> Admin</span>
        </div>
    </div>

    {{-- Stat Cards Row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3 fade-up">
            <div class="stat-card">
                <div class="stat-icon icon-indigo"><i class="bi bi-people-fill"></i></div>
                <div class="stat-value count-up" data-target="{{ $totalEmployees }}">0</div>
                <div class="stat-label">Total Employees</div>
                <div class="stat-trend" style="background:#ecfdf5;color:#10b981;">
                    <i class="bi bi-check-circle-fill"></i> {{ $activeEmployees }} active
                </div>
                <div class="stat-bar bar-indigo"></div>
            </div>
        </div>
        <div class="col-6 col-lg-3 fade-up">
            <div class="stat-card">
                <div class="stat-icon icon-emerald"><i class="bi bi-person-check-fill"></i></div>
                <div class="stat-value count-up" data-target="{{ $presentToday }}">0</div>
                <div class="stat-label">Present Today</div>
                <div class="stat-trend" style="background:#fee2e2;color:#ef4444;">
                    <i class="bi bi-person-x"></i> {{ $absentToday }} absent
                </div>
                <div class="stat-bar bar-emerald"></div>
            </div>
        </div>
        <div class="col-6 col-lg-3 fade-up">
            <div class="stat-card">
                <div class="stat-icon icon-amber"><i class="bi bi-hourglass-split"></i></div>
                <div class="stat-value count-up" data-target="{{ $pendingLeaves }}">0</div>
                <div class="stat-label">Pending Leaves</div>
                <div class="stat-trend" style="background:#fffbeb;color:#f59e0b;">
                    <i class="bi bi-arrow-right"></i> Action needed
                </div>
                <div class="stat-bar bar-amber"></div>
            </div>
        </div>
        <div class="col-6 col-lg-3 fade-up">
            <div class="stat-card">
                <div class="stat-icon icon-rose"><i class="bi bi-calendar-x-fill"></i></div>
                <div class="stat-value count-up" data-target="{{ $onLeaveToday }}">0</div>
                <div class="stat-label">On Leave Today</div>
                <div class="stat-trend" style="background:#f1f5f9;color:#475569;">
                    <i class="bi bi-calendar-check"></i> {{ $monthlyAttendance }} this month
                </div>
                <div class="stat-bar bar-rose"></div>
            </div>
        </div>
    </div>

    {{-- Row 2: Attendance Donut + Department Stats + Quick Actions --}}
    <div class="row g-3 mb-4">
        {{-- Attendance Overview Donut --}}
        <div class="col-lg-4 fade-up">
            <div class="section-card">
                <div class="section-header">
                    <h6><span class="header-icon icon-emerald"><i class="bi bi-pie-chart-fill"></i></span> Today's Overview</h6>
                </div>
                <div class="section-body">
                    <div class="donut-container">
                        @php
                            $total = $activeEmployees ?: 1;
                            $pPct = round(($presentToday / $total) * 100);
                            $lPct = round(($onLeaveToday / $total) * 100);
                            $aPct = 100 - $pPct - $lPct;
                            $pDeg = $pPct * 3.6;
                            $lDeg = $lPct * 3.6;
                        @endphp
                        <div class="donut-chart" style="background: conic-gradient(#10b981 0deg {{ $pDeg }}deg, #f59e0b {{ $pDeg }}deg {{ $pDeg + $lDeg }}deg, #e2e8f0 {{ $pDeg + $lDeg }}deg 360deg);">
                            <div class="donut-center" style="width:76px;height:76px;background:#fff;border-radius:50%;">
                                <span class="val">{{ $pPct }}%</span>
                                <span class="lbl">Present</span>
                            </div>
                        </div>
                        <div class="donut-legend">
                            <div class="legend-item">
                                <span class="legend-dot" style="background:#10b981;"></span>
                                Present <span class="legend-val">{{ $presentToday }}</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-dot" style="background:#f59e0b;"></span>
                                On Leave <span class="legend-val">{{ $onLeaveToday }}</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-dot" style="background:#e2e8f0;"></span>
                                Absent <span class="legend-val">{{ $absentToday }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Department Stats --}}
        <div class="col-lg-4 fade-up">
            <div class="section-card">
                <div class="section-header">
                    <h6><span class="header-icon icon-indigo"><i class="bi bi-diagram-3-fill"></i></span> Departments</h6>
                    <a href="{{ route('admin.departments.index') }}">View All</a>
                </div>
                <div class="section-body">
                    @php
                        $deptColors = ['#6366f1','#10b981','#f59e0b','#f43f5e','#06b6d4','#8b5cf6','#ec4899','#14b8a6'];
                        $maxDept = $departmentStats->max('employees_count') ?: 1;
                    @endphp
                    @forelse($departmentStats as $i => $dept)
                        <div class="dept-item">
                            <span class="dept-dot" style="background:{{ $deptColors[$i % count($deptColors)] }};"></span>
                            <span class="dept-name">{{ $dept->name }}</span>
                            <div class="dept-bar-wrap">
                                <div class="dept-bar" style="width:{{ ($dept->employees_count / $maxDept) * 100 }}%;background:{{ $deptColors[$i % count($deptColors)] }};"></div>
                            </div>
                            <span class="dept-count">{{ $dept->employees_count }}</span>
                        </div>
                    @empty
                        <p class="text-muted text-center py-3 mb-0"><i class="bi bi-inbox"></i> No departments yet</p>
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
                        <a href="{{ route('admin.employees.create') }}" class="quick-action">
                            <span class="qa-icon icon-indigo"><i class="bi bi-person-plus-fill"></i></span>
                            Add New Employee
                        </a>
                        <a href="{{ route('admin.leaves.index') }}?status=pending" class="quick-action">
                            <span class="qa-icon icon-amber"><i class="bi bi-hourglass-split"></i></span>
                            Review Pending Leaves
                            @if($pendingLeaves > 0)
                                <span class="badge rounded-pill" style="background:#fef3c7;color:#92400e;margin-left:auto;">{{ $pendingLeaves }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.attendance.index') }}" class="quick-action">
                            <span class="qa-icon icon-emerald"><i class="bi bi-clock-fill"></i></span>
                            Mark Attendance
                        </a>
                        <a href="{{ route('admin.reports.index') }}" class="quick-action">
                            <span class="qa-icon icon-sky"><i class="bi bi-bar-chart-fill"></i></span>
                            Generate Reports
                        </a>
                        <a href="{{ route('admin.activity-logs.index') }}" class="quick-action">
                            <span class="qa-icon icon-rose"><i class="bi bi-clock-history"></i></span>
                            Activity Logs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Row 3: Recent Leaves + Holidays + Announcements --}}
    <div class="row g-3 mb-4">
        {{-- Recent Leave Requests --}}
        <div class="col-lg-5 fade-up">
            <div class="section-card">
                <div class="section-header">
                    <h6><span class="header-icon icon-amber"><i class="bi bi-calendar-check-fill"></i></span> Recent Leave Requests</h6>
                    <a href="{{ route('admin.leaves.index') }}">View All</a>
                </div>
                <div class="section-body">
                    @forelse($recentLeaves as $leave)
                        @php
                            $avatarColors = ['#6366f1','#10b981','#f59e0b','#f43f5e','#06b6d4'];
                            $initials = strtoupper(substr($leave->employee->first_name ?? 'U', 0, 1) . substr($leave->employee->last_name ?? '', 0, 1));
                            $color = $avatarColors[$loop->index % count($avatarColors)];
                        @endphp
                        <div class="leave-item">
                            <div class="leave-avatar" style="background:{{ $color }}15;color:{{ $color }};">{{ $initials }}</div>
                            <div class="leave-info">
                                <h6>{{ $leave->employee->full_name }}</h6>
                                <small>{{ $leave->leaveType->name }} · {{ $leave->start_date->format('d M') }} - {{ $leave->end_date->format('d M') }} · {{ $leave->total_days }}d</small>
                            </div>
                            <span class="leave-badge badge-{{ $leave->status }}">{{ $leave->status }}</span>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-inbox text-muted" style="font-size:2rem;"></i>
                            <p class="text-muted mb-0 mt-2" style="font-size:0.85rem;">No leave requests yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Upcoming Holidays --}}
        <div class="col-lg-3 fade-up">
            <div class="section-card">
                <div class="section-header">
                    <h6><span class="header-icon icon-emerald"><i class="bi bi-calendar-event-fill"></i></span> Holidays</h6>
                    <a href="{{ route('admin.holidays.index') }}">All</a>
                </div>
                <div class="section-body">
                    @forelse($upcomingHolidays as $holiday)
                        @php
                            $hColors = ['national'=>['#dbeafe','#2563eb'],'regional'=>['#fef3c7','#d97706'],'company'=>['#dcfce7','#16a34a'],'optional'=>['#f3e8ff','#7c3aed']];
                            $hc = $hColors[$holiday->type] ?? ['#f1f5f9','#475569'];
                        @endphp
                        <div class="holiday-item">
                            <div class="holiday-date-box" style="background:{{ $hc[0] }};color:{{ $hc[1] }};">
                                <span class="day">{{ $holiday->date->format('d') }}</span>
                                <span class="month">{{ $holiday->date->format('M') }}</span>
                            </div>
                            <div class="holiday-info">
                                <h6>{{ $holiday->name }}</h6>
                                <small>{{ $holiday->date->format('l') }} · {{ ucfirst($holiday->type) }}</small>
                            </div>
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
        <div class="col-lg-4 fade-up">
            <div class="section-card">
                <div class="section-header">
                    <h6><span class="header-icon icon-sky"><i class="bi bi-megaphone-fill"></i></span> Announcements</h6>
                    <a href="{{ route('admin.announcements.index') }}">Manage</a>
                </div>
                <div class="section-body">
                    @forelse($recentAnnouncements as $announcement)
                        <div class="announce-item">
                            <h6>
                                @if($announcement->is_pinned)<i class="bi bi-pin-fill text-danger me-1" style="font-size:0.75rem;"></i>@endif
                                {{ Str::limit($announcement->title, 40) }}
                            </h6>
                            <p>
                                <i class="bi bi-person-fill"></i> {{ $announcement->creator->name ?? 'System' }}
                                <span class="mx-1">·</span>
                                <i class="bi bi-clock"></i> {{ $announcement->published_at->diffForHumans() }}
                            </p>
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
        const target = parseInt(el.getAttribute('data-target')) || 0;
        if (target === 0) { el.textContent = '0'; return; }
        const duration = 800;
        const step = Math.max(1, Math.floor(target / (duration / 16)));
        let current = 0;
        const timer = setInterval(function() {
            current += step;
            if (current >= target) { current = target; clearInterval(timer); }
            el.textContent = current;
        }, 16);
    });
});
</script>
@endsection
