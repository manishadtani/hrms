@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    .reports-page {
        font-family: 'Inter', sans-serif;
        padding: 2rem 0 4rem;
        min-height: 100vh;
    }

    /* ── Animations ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(22px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulseRing {
        0%   { box-shadow: 0 0 0 0 rgba(99,102,241,.25); }
        70%  { box-shadow: 0 0 0 8px rgba(99,102,241,0); }
        100% { box-shadow: 0 0 0 0 rgba(99,102,241,0); }
    }
    @keyframes shimmer {
        0% { background-position: -400px 0; }
        100% { background-position: 400px 0; }
    }
    .fade-up { animation: fadeUp .5s cubic-bezier(.22,1,.36,1) both; }
    .fade-up-1 { animation-delay: .05s; }
    .fade-up-2 { animation-delay: .10s; }
    .fade-up-3 { animation-delay: .15s; }
    .fade-up-4 { animation-delay: .20s; }
    .fade-up-5 { animation-delay: .25s; }

    /* ── Page Header ── */
    .rpt-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 2.5rem;
    }
    .rpt-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .rpt-header-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.45rem;
        box-shadow: 0 4px 14px rgba(99,102,241,.3);
        animation: pulseRing 2.5s ease infinite;
    }
    .rpt-header h1 {
        font-size: 1.75rem;
        font-weight: 800;
        background: linear-gradient(135deg, #312e81 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -.025em;
        margin: 0;
    }
    .rpt-header h1 span {
        display: block;
        font-size: .82rem;
        font-weight: 500;
        -webkit-text-fill-color: #64748b;
        letter-spacing: .02em;
        margin-top: 2px;
    }

    /* ── Report Cards Grid ── */
    .rpt-cards-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .rpt-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 2rem 2rem 1.75rem;
        position: relative;
        overflow: hidden;
        transition: all .35s cubic-bezier(.22,1,.36,1);
        text-decoration: none;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .rpt-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 20px 20px 0 0;
    }
    .rpt-card::after {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        opacity: 0.05;
        transition: all .35s ease;
    }
    .rpt-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(0,0,0,.08);
        border-color: transparent;
    }
    .rpt-card:hover::after {
        opacity: 0.08;
        transform: scale(1.2);
    }

    .rpt-card-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    .rpt-card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    .rpt-card-desc {
        font-size: 0.855rem;
        color: #64748b;
        line-height: 1.6;
        margin: 0;
        flex: 1;
    }
    .rpt-card-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.3rem;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.82rem;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        transition: all .25s ease;
        align-self: flex-start;
    }
    .rpt-card-btn:hover {
        transform: translateY(-1px);
        text-decoration: none;
        color: #fff;
    }

    /* ── Card: Employee Directory – Indigo ── */
    .rpt-card-employees::before { background: linear-gradient(90deg, #6366f1, #818cf8); }
    .rpt-card-employees::after { background: #6366f1; }
    .rpt-card-employees .rpt-card-icon { background: #eef2ff; color: #6366f1; }
    .rpt-card-employees .rpt-card-btn {
        background: linear-gradient(135deg, #6366f1, #818cf8);
        box-shadow: 0 4px 12px rgba(99,102,241,.3);
    }
    .rpt-card-employees .rpt-card-btn:hover {
        box-shadow: 0 6px 18px rgba(99,102,241,.45);
    }
    .rpt-card-employees:hover { border-color: #c7d2fe; }

    /* ── Card: Attendance – Emerald ── */
    .rpt-card-attendance::before { background: linear-gradient(90deg, #10b981, #34d399); }
    .rpt-card-attendance::after { background: #10b981; }
    .rpt-card-attendance .rpt-card-icon { background: #ecfdf5; color: #10b981; }
    .rpt-card-attendance .rpt-card-btn {
        background: linear-gradient(135deg, #10b981, #34d399);
        box-shadow: 0 4px 12px rgba(16,185,129,.3);
    }
    .rpt-card-attendance .rpt-card-btn:hover {
        box-shadow: 0 6px 18px rgba(16,185,129,.45);
    }
    .rpt-card-attendance:hover { border-color: #a7f3d0; }

    /* ── Card: Leave – Amber ── */
    .rpt-card-leaves::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .rpt-card-leaves::after { background: #f59e0b; }
    .rpt-card-leaves .rpt-card-icon { background: #fffbeb; color: #f59e0b; }
    .rpt-card-leaves .rpt-card-btn {
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        box-shadow: 0 4px 12px rgba(245,158,11,.3);
    }
    .rpt-card-leaves .rpt-card-btn:hover {
        box-shadow: 0 6px 18px rgba(245,158,11,.45);
    }
    .rpt-card-leaves:hover { border-color: #fde68a; }

    /* ── Card: Holiday – Rose ── */
    .rpt-card-holidays::before { background: linear-gradient(90deg, #f43f5e, #fb7185); }
    .rpt-card-holidays::after { background: #f43f5e; }
    .rpt-card-holidays .rpt-card-icon { background: #fff1f2; color: #f43f5e; }
    .rpt-card-holidays .rpt-card-btn {
        background: linear-gradient(135deg, #f43f5e, #fb7185);
        box-shadow: 0 4px 12px rgba(244,63,94,.3);
    }
    .rpt-card-holidays .rpt-card-btn:hover {
        box-shadow: 0 6px 18px rgba(244,63,94,.45);
    }
    .rpt-card-holidays:hover { border-color: #fecdd3; }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .rpt-cards-grid { grid-template-columns: 1fr; }
        .rpt-header { flex-direction: column; align-items: flex-start; }
        .reports-page { padding: 1.25rem 0 3rem; }
    }
</style>

<div class="reports-page">
    <div class="container">

        {{-- ── Page Header ── --}}
        <div class="rpt-header fade-up fade-up-1">
            <div class="rpt-header-left">
                <div class="rpt-header-icon">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                </div>
                <h1>
                    Reports
                    <span>Generate & export detailed organizational reports</span>
                </h1>
            </div>
        </div>

        {{-- ── Report Cards ── --}}
        <div class="rpt-cards-grid">

            {{-- Employee Directory --}}
            <div class="rpt-card rpt-card-employees fade-up fade-up-2">
                <div class="rpt-card-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h3 class="rpt-card-title">Employee Directory</h3>
                <p class="rpt-card-desc">
                    Complete directory of all employees with details including department, designation, manager, joining date, and current status. Export to Excel or PDF.
                </p>
                <a href="{{ route('admin.reports.employees') }}" class="rpt-card-btn">
                    <i class="bi bi-arrow-right-circle"></i> View Report
                </a>
            </div>

            {{-- Attendance Report --}}
            <div class="rpt-card rpt-card-attendance fade-up fade-up-3">
                <div class="rpt-card-icon">
                    <i class="bi bi-calendar2-check"></i>
                </div>
                <h3 class="rpt-card-title">Attendance Report</h3>
                <p class="rpt-card-desc">
                    Monthly attendance summary showing present days, absences, leaves, and attendance percentage for each employee across departments.
                </p>
                <a href="{{ route('admin.reports.attendance') }}" class="rpt-card-btn">
                    <i class="bi bi-arrow-right-circle"></i> View Report
                </a>
            </div>

            {{-- Leave Report --}}
            <div class="rpt-card rpt-card-leaves fade-up fade-up-4">
                <div class="rpt-card-icon">
                    <i class="bi bi-calendar2-week"></i>
                </div>
                <h3 class="rpt-card-title">Leave Report</h3>
                <p class="rpt-card-desc">
                    Comprehensive leave balance report showing used vs total allocation for each leave type per employee. Track utilization across the year.
                </p>
                <a href="{{ route('admin.reports.leaves') }}" class="rpt-card-btn">
                    <i class="bi bi-arrow-right-circle"></i> View Report
                </a>
            </div>

            {{-- Holiday Report --}}
            <div class="rpt-card rpt-card-holidays fade-up fade-up-5">
                <div class="rpt-card-icon">
                    <i class="bi bi-calendar2-heart"></i>
                </div>
                <h3 class="rpt-card-title">Holiday Report</h3>
                <p class="rpt-card-desc">
                    Annual holiday calendar with type-based breakdown including national, regional, company, and optional holidays. Summary statistics at a glance.
                </p>
                <a href="{{ route('admin.reports.holidays') }}" class="rpt-card-btn">
                    <i class="bi bi-arrow-right-circle"></i> View Report
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
