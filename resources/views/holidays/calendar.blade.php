@extends('layouts.app')

@section('content')
<style>
    .hol-calendar {
        --primary: #6366f1;
        --primary-light: #818cf8;
        --blue: #2563eb;
        --blue-bg: #dbeafe;
        --amber: #d97706;
        --amber-bg: #fef3c7;
        --green: #16a34a;
        --green-bg: #dcfce7;
        --purple: #7c3aed;
        --purple-bg: #f3e8ff;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --text-muted: #94a3b8;
        --border: #f1f5f9;
        --card-bg: #ffffff;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* ── Banner ── */
    .cal-banner {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a78bfa 100%);
        border-radius: 20px;
        padding: 32px 36px;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
    }
    .cal-banner::before {
        content: '';
        position: absolute;
        right: -40px;
        top: -40px;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .cal-banner::after {
        content: '';
        position: absolute;
        right: 60px;
        bottom: -60px;
        width: 160px;
        height: 160px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .cal-banner-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        position: relative;
        z-index: 1;
    }
    .cal-banner h2 {
        font-size: 1.75rem;
        font-weight: 700;
        letter-spacing: -0.5px;
        margin: 0;
    }
    .cal-banner p {
        opacity: 0.85;
        font-size: 0.92rem;
        margin: 6px 0 0;
    }
    .cal-banner-meta {
        display: flex;
        gap: 12px;
        margin-top: 14px;
        flex-wrap: wrap;
    }
    .cal-banner-meta .meta-chip {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.82rem;
        background: rgba(255,255,255,0.15);
        padding: 5px 14px;
        border-radius: 20px;
        font-weight: 500;
    }

    /* ── Year Nav ── */
    .year-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }
    .year-nav a {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.15);
        color: #fff;
        text-decoration: none;
        font-size: 1.1rem;
        transition: all 0.25s ease;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .year-nav a:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.08);
        color: #fff;
    }
    .year-nav .year-display {
        font-size: 1.6rem;
        font-weight: 800;
        min-width: 80px;
        text-align: center;
        letter-spacing: -1px;
    }

    /* ── Month Card ── */
    .month-card {
        background: var(--card-bg);
        border-radius: 16px;
        border: 1px solid var(--border);
        overflow: hidden;
        height: 100%;
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    }
    .month-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    }
    .month-header {
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--border);
    }
    .month-header h6 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .month-header .month-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #eef2ff;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
    }
    .month-header .month-count {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        background: #f1f5f9;
        color: var(--text-secondary);
    }
    .month-body {
        padding: 12px 20px 16px;
    }

    /* ── Holiday Row ── */
    .hol-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f8fafc;
        transition: background 0.2s;
    }
    .hol-row:last-child { border-bottom: none; }
    .hol-row:hover {
        background: #fafafe;
        margin: 0 -20px;
        padding-left: 20px;
        padding-right: 20px;
    }
    .hol-date-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .hol-date-box .hol-day {
        font-size: 1.1rem;
        font-weight: 800;
        line-height: 1;
    }
    .hol-date-box .hol-dayname {
        font-size: 0.55rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 2px;
    }
    .hol-info {
        flex: 1;
        min-width: 0;
    }
    .hol-info h6 {
        font-size: 0.86rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .hol-type-badge {
        font-size: 0.65rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .badge-national { background: var(--blue-bg); color: var(--blue); }
    .badge-regional { background: var(--amber-bg); color: var(--amber); }
    .badge-company  { background: var(--green-bg); color: var(--green); }
    .badge-optional { background: var(--purple-bg); color: var(--purple); }

    .datebox-national { background: var(--blue-bg); color: var(--blue); }
    .datebox-regional { background: var(--amber-bg); color: var(--amber); }
    .datebox-company  { background: var(--green-bg); color: var(--green); }
    .datebox-optional { background: var(--purple-bg); color: var(--purple); }

    /* ── Empty State ── */
    .month-empty {
        text-align: center;
        padding: 24px 0;
    }
    .month-empty i {
        font-size: 1.6rem;
        color: #e2e8f0;
    }
    .month-empty p {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 6px 0 0;
    }

    /* ── Legend ── */
    .legend-strip {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 24px;
        padding: 14px 20px;
        background: var(--card-bg);
        border-radius: 14px;
        border: 1px solid var(--border);
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        color: var(--text-secondary);
    }
    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* ── Inactive Holiday ── */
    .hol-inactive {
        opacity: 0.45;
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
    .fade-up:nth-child(1)  { animation-delay: 0.03s; }
    .fade-up:nth-child(2)  { animation-delay: 0.06s; }
    .fade-up:nth-child(3)  { animation-delay: 0.09s; }
    .fade-up:nth-child(4)  { animation-delay: 0.12s; }
    .fade-up:nth-child(5)  { animation-delay: 0.15s; }
    .fade-up:nth-child(6)  { animation-delay: 0.18s; }
    .fade-up:nth-child(7)  { animation-delay: 0.21s; }
    .fade-up:nth-child(8)  { animation-delay: 0.24s; }
    .fade-up:nth-child(9)  { animation-delay: 0.27s; }
    .fade-up:nth-child(10) { animation-delay: 0.30s; }
    .fade-up:nth-child(11) { animation-delay: 0.33s; }
    .fade-up:nth-child(12) { animation-delay: 0.36s; }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .cal-banner { padding: 24px 20px; border-radius: 16px; }
        .cal-banner h2 { font-size: 1.3rem; }
        .cal-banner-content { flex-direction: column; align-items: flex-start; }
        .year-nav .year-display { font-size: 1.3rem; }
        .hol-date-box { width: 42px; height: 42px; }
        .hol-date-box .hol-day { font-size: 0.95rem; }
    }
</style>

<div class="hol-calendar">

    {{-- ── Banner ── --}}
    @php
        $totalHolidays = 0;
        foreach ($holidays as $monthHolidays) {
            $totalHolidays += $monthHolidays->count();
        }
        $monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    @endphp

    <div class="cal-banner fade-up">
        <div class="cal-banner-content">
            <div>
                <h2><i class="bi bi-calendar-event me-2"></i>Holiday Calendar — {{ $year }}</h2>
                <p>Overview of all scheduled holidays for the year</p>
                <div class="cal-banner-meta">
                    <span class="meta-chip">
                        <i class="bi bi-calendar-check"></i> {{ $totalHolidays }} {{ Str::plural('Holiday', $totalHolidays) }}
                    </span>
                    <span class="meta-chip">
                        <i class="bi bi-calendar3"></i> {{ $year }}
                    </span>
                </div>
            </div>
            <div class="year-nav">
                <a href="{{ route('holidays.calendar', ['year' => $year - 1]) }}" title="{{ $year - 1 }}">
                    <i class="bi bi-chevron-left"></i>
                </a>
                <span class="year-display">{{ $year }}</span>
                <a href="{{ route('holidays.calendar', ['year' => $year + 1]) }}" title="{{ $year + 1 }}">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- ── Legend Strip ── --}}
    <div class="legend-strip fade-up">
        <div class="legend-item">
            <span class="legend-dot" style="background: var(--blue);"></span> National
        </div>
        <div class="legend-item">
            <span class="legend-dot" style="background: var(--amber);"></span> Regional
        </div>
        <div class="legend-item">
            <span class="legend-dot" style="background: var(--green);"></span> Company
        </div>
        <div class="legend-item">
            <span class="legend-dot" style="background: var(--purple);"></span> Optional
        </div>
    </div>

    {{-- ── Month Grid ── --}}
    <div class="row g-3">
        @for ($m = 1; $m <= 12; $m++)
            @php
                $monthHols = $holidays->get($m, collect());
            @endphp
            <div class="col-12 col-md-6 col-xl-4 fade-up">
                <div class="month-card">
                    <div class="month-header">
                        <h6>
                            <span class="month-icon"><i class="bi bi-calendar3"></i></span>
                            {{ $monthNames[$m - 1] }}
                        </h6>
                        @if($monthHols->count() > 0)
                            <span class="month-count">{{ $monthHols->count() }} {{ Str::plural('holiday', $monthHols->count()) }}</span>
                        @endif
                    </div>
                    <div class="month-body">
                        @forelse($monthHols as $holiday)
                            <div class="hol-row {{ !$holiday->is_active ? 'hol-inactive' : '' }}">
                                <div class="hol-date-box datebox-{{ $holiday->type }}">
                                    <span class="hol-day">{{ $holiday->date->format('d') }}</span>
                                    <span class="hol-dayname">{{ $holiday->date->format('D') }}</span>
                                </div>
                                <div class="hol-info">
                                    <h6>{{ $holiday->name }}</h6>
                                </div>
                                <span class="hol-type-badge badge-{{ $holiday->type }}">{{ $holiday->type }}</span>
                            </div>
                        @empty
                            <div class="month-empty">
                                <i class="bi bi-calendar-x"></i>
                                <p>No holidays</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endfor
    </div>

</div>
@endsection
