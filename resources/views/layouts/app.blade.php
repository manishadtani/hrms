<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- jQuery (as per SOW tech stack) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --sb-width: 260px;
            --sb-bg: #ffffff;
            --sb-bg-hover: #f8fafc;
            --sb-text: #64748b;
            --sb-text-hover: #1e293b;
            --sb-active: #6366f1;
            --sb-active-bg: #eef2ff;
            --sb-border: #e2e8f0;
        }

        body { font-family: 'Inter', -apple-system, sans-serif; background: #f1f5f9; }

        /* ===== SIDEBAR ===== */
        .ems-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sb-width);
            height: 100vh;
            background: var(--sb-bg);
            border-right: 1px solid var(--sb-border);
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform .3s cubic-bezier(.4,0,.2,1);
            overflow: hidden;
        }

        /* Logo */
        .sb-logo {
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--sb-border);
            flex-shrink: 0;
        }
        .sb-logo-icon {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.1rem; font-weight: 800;
            box-shadow: 0 4px 15px rgba(99,102,241,.25);
        }
        .sb-logo-text { color: #1e1b4b; font-size: 1.15rem; font-weight: 800; letter-spacing: -.5px; }
        .sb-logo-text small { display: block; font-size: .65rem; font-weight: 500; color: #94a3b8; letter-spacing: .5px; text-transform: uppercase; }

        /* Nav */
        .sb-nav {
            flex: 1;
            overflow-y: auto;
            padding: 12px 0;
            scrollbar-width: thin;
            scrollbar-color: #e2e8f0 transparent;
        }
        .sb-nav::-webkit-scrollbar { width: 4px; }
        .sb-nav::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }

        .sb-section { padding: 0 14px; margin-bottom: 8px; }
        .sb-section-label {
            padding: 8px 12px 6px;
            font-size: .65rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        .sb-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 10px;
            color: var(--sb-text);
            text-decoration: none;
            font-size: .88rem;
            font-weight: 500;
            transition: all .2s ease;
            position: relative;
            margin-bottom: 2px;
        }
        .sb-link:hover {
            color: var(--sb-text-hover);
            background: var(--sb-bg-hover);
        }
        .sb-link.active {
            color: var(--sb-active);
            background: var(--sb-active-bg);
            font-weight: 600;
        }
        .sb-link.active::before {
            content: '';
            position: absolute;
            left: -14px;
            top: 8px; bottom: 8px;
            width: 3px;
            border-radius: 0 3px 3px 0;
            background: var(--sb-active);
        }
        .sb-link .sb-icon {
            width: 34px; height: 34px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            background: #f1f5f9;
            color: #64748b;
            transition: all .2s;
            flex-shrink: 0;
        }
        .sb-link:hover .sb-icon { background: #eef2ff; color: #6366f1; }
        .sb-link.active .sb-icon { background: #e0e7ff; color: #6366f1; }

        .sb-badge {
            margin-left: auto;
            background: #ef4444;
            color: #fff;
            font-size: .65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 10px;
            min-width: 20px;
            text-align: center;
        }

        /* User card */
        .sb-user {
            padding: 16px 20px;
            border-top: 1px solid var(--sb-border);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
            background: #f8fafc;
        }
        .sb-user-avatar {
            width: 38px; height: 38px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .85rem;
            flex-shrink: 0;
        }
        .sb-user-info { flex: 1; min-width: 0; }
        .sb-user-name { color: #1e293b; font-size: .85rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sb-user-role { font-size: .7rem; color: #94a3b8; font-weight: 500; text-transform: capitalize; }
        .sb-user-logout {
            width: 34px; height: 34px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #94a3b8;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all .2s;
            font-size: .9rem;
        }
        .sb-user-logout:hover { background: #fef2f2; border-color: #fecaca; color: #ef4444; }

        /* ===== TOPBAR ===== */
        .ems-topbar {
            position: fixed;
            top: 0;
            left: var(--sb-width);
            right: 0;
            height: 64px;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            padding: 0 28px;
            z-index: 1030;
            gap: 16px;
        }
        .topbar-toggle {
            display: none;
            width: 38px; height: 38px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #475569;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all .2s;
        }
        .topbar-toggle:hover { background: #f8fafc; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .topbar-breadcrumb { font-size: .85rem; color: #64748b; }
        .topbar-breadcrumb strong { color: #1e293b; font-weight: 700; }
        .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 12px; }
        .topbar-date { font-size: .82rem; color: #94a3b8; display: flex; align-items: center; gap: 6px; }
        .topbar-user-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 6px 14px 6px 6px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
            color: #334155;
            font-size: .85rem;
            font-weight: 600;
            position: relative;
        }
        .topbar-user-btn:hover { background: #eef2ff; border-color: #c7d2fe; color: #4f46e5; }
        .topbar-avatar-sm {
            width: 30px; height: 30px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .7rem; color: #fff;
        }
        .topbar-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 12px 40px rgba(0,0,0,.1);
            min-width: 200px;
            padding: 8px;
            display: none;
            z-index: 1050;
        }
        .topbar-user-btn:focus .topbar-dropdown,
        .topbar-user-btn.open .topbar-dropdown { display: block; }
        .topbar-dd-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            color: #475569;
            text-decoration: none;
            font-size: .85rem;
            font-weight: 500;
            transition: all .2s;
        }
        .topbar-dd-item:hover { background: #f8fafc; color: #6366f1; }
        .topbar-dd-item.danger:hover { background: #fef2f2; color: #dc2626; }
        .topbar-dd-divider { height: 1px; background: #f1f5f9; margin: 4px 0; }

        /* ===== MAIN CONTENT ===== */
        .ems-main {
            margin-left: var(--sb-width);
            padding: 88px 28px 28px;
            min-height: 100vh;
        }

        /* ===== OVERLAY ===== */
        .sb-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.4);
            z-index: 1035;
            backdrop-filter: blur(2px);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            .ems-sidebar { transform: translateX(-100%); }
            .ems-sidebar.open { transform: translateX(0); }
            .sb-overlay.open { display: block; }
            .ems-main { margin-left: 0; }
            .ems-topbar { left: 0; }
            .topbar-toggle { display: flex; }
        }

        /* ===== SCROLLBAR FIX ===== */
        @media (min-width: 992px) {
            body { overflow-x: hidden; }
        }

        /* ===== GLOBAL PAGINATION ===== */
        .pagination {
            display: flex;
            gap: 4px;
            list-style: none;
            padding: 0;
            margin: 16px 0;
            flex-wrap: wrap;
            justify-content: center;
        }
        .pagination .page-item .page-link,
        .pagination li a,
        .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #475569;
            font-family: 'Inter', sans-serif;
            font-size: .85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s ease;
            cursor: pointer;
        }
        .pagination .page-item .page-link:hover,
        .pagination li a:hover {
            background: #eef2ff;
            border-color: #c7d2fe;
            color: #6366f1;
            transform: translateY(-1px);
        }
        .pagination .page-item.active .page-link,
        .pagination li.active span,
        .pagination li span[aria-current="page"] {
            background: linear-gradient(135deg, #6366f1, #8b5cf6) !important;
            color: #fff !important;
            border-color: #6366f1 !important;
            box-shadow: 0 4px 12px rgba(99,102,241,.3);
        }
        .pagination .page-item.disabled .page-link,
        .pagination li.disabled span,
        .pagination li span:not([aria-current]) {
            color: #cbd5e1;
            background: #f8fafc;
            border-color: #f1f5f9;
            cursor: default;
            pointer-events: none;
        }
        .pagination li span[aria-current="page"] {
            pointer-events: auto;
            cursor: default;
        }
        /* Navigation arrows */
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            font-size: 1rem;
        }
        /* Wrap pagination nicely */
        nav[aria-label="Pagination Navigation"],
        nav .pagination,
        .d-flex.justify-content-center,
        div[role="navigation"] {
            display: flex;
            justify-content: center;
            padding: 12px 0;
        }
        /* Fix Laravel default pagination info text */
        .pagination + .d-flex,
        nav p.text-sm {
            font-family: 'Inter', sans-serif;
            font-size: .82rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div id="app">
        @auth
        {{-- ===== SIDEBAR ===== --}}
        <aside class="ems-sidebar" id="sidebar">
            <div class="sb-logo">
                <div class="sb-logo-icon"><i class="bi bi-building"></i></div>
                <div class="sb-logo-text">EMS<small>Management System</small></div>
            </div>

            <nav class="sb-nav">
                @role('admin')
                <div class="sb-section">
                    <div class="sb-section-label">Main</div>
                    <a href="{{ route('admin.dashboard') }}" class="sb-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-grid-1x2-fill"></i></span> Dashboard
                    </a>
                </div>
                <div class="sb-section">
                    <div class="sb-section-label">Organization</div>
                    <a href="{{ route('admin.employees.index') }}" class="sb-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-people-fill"></i></span> Employees
                    </a>
                    <a href="{{ route('admin.departments.index') }}" class="sb-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-diagram-3-fill"></i></span> Departments
                    </a>
                    <a href="{{ route('admin.designations.index') }}" class="sb-link {{ request()->routeIs('admin.designations.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-bookmark-star-fill"></i></span> Designations
                    </a>
                </div>
                <div class="sb-section">
                    <div class="sb-section-label">Workforce</div>
                    <a href="{{ route('admin.attendance.index') }}" class="sb-link {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-clock-fill"></i></span> Attendance
                    </a>
                    <a href="{{ route('admin.leaves.index') }}" class="sb-link {{ request()->routeIs('admin.leaves.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-calendar-check-fill"></i></span> Leave Requests
                    </a>
                    <a href="{{ route('admin.leave-types.index') }}" class="sb-link {{ request()->routeIs('admin.leave-types.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-gear-fill"></i></span> Leave Types
                    </a>
                    <a href="{{ route('admin.holidays.index') }}" class="sb-link {{ request()->routeIs('admin.holidays.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-calendar-event-fill"></i></span> Holidays
                    </a>
                    <a href="{{ route('admin.announcements.index') }}" class="sb-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-megaphone-fill"></i></span> Announcements
                    </a>
                </div>
                <div class="sb-section">
                    <div class="sb-section-label">Administration</div>
                    <a href="{{ route('admin.users.index') }}" class="sb-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-person-gear"></i></span> User Management
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="sb-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-bar-chart-fill"></i></span> Reports
                    </a>
                    <a href="{{ route('admin.roles.index') }}" class="sb-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-shield-lock-fill"></i></span> Roles & Permissions
                    </a>
                    <a href="{{ route('admin.activity-logs.index') }}" class="sb-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-clock-history"></i></span> Activity Logs
                    </a>
                </div>
                @endrole

                @role('manager')
                <div class="sb-section">
                    <div class="sb-section-label">Main</div>
                    <a href="{{ route('manager.dashboard') }}" class="sb-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-grid-1x2-fill"></i></span> Dashboard
                    </a>
                </div>
                <div class="sb-section">
                    <div class="sb-section-label">Team</div>
                    <a href="{{ route('manager.team.index') }}" class="sb-link {{ request()->routeIs('manager.team.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-people-fill"></i></span> My Team
                    </a>
                    <a href="{{ route('manager.attendance.index') }}" class="sb-link {{ request()->routeIs('manager.attendance.index') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-clock-fill"></i></span> Team Attendance
                    </a>
                    <a href="{{ route('manager.leaves.index') }}" class="sb-link {{ request()->routeIs('manager.leaves.index') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-calendar-check-fill"></i></span> Team Leaves
                    </a>
                </div>
                <div class="sb-section">
                    <div class="sb-section-label">Personal</div>
                    <a href="{{ route('manager.attendance.my') }}" class="sb-link {{ request()->routeIs('manager.attendance.my') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-person-check-fill"></i></span> My Attendance
                    </a>
                    <a href="{{ route('manager.leaves.my') }}" class="sb-link {{ request()->routeIs('manager.leaves.my') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-calendar-plus-fill"></i></span> My Leaves
                    </a>
                </div>
                <div class="sb-section">
                    <div class="sb-section-label">Info</div>
                    <a href="{{ route('holidays.calendar') }}" class="sb-link {{ request()->routeIs('holidays.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-calendar-event-fill"></i></span> Holidays
                    </a>
                    <a href="{{ route('announcements.public') }}" class="sb-link {{ request()->routeIs('announcements.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-megaphone-fill"></i></span> Announcements
                    </a>
                </div>
                @endrole

                @role('employee')
                <div class="sb-section">
                    <div class="sb-section-label">Main</div>
                    <a href="{{ route('employee.dashboard') }}" class="sb-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-grid-1x2-fill"></i></span> Dashboard
                    </a>
                </div>
                <div class="sb-section">
                    <div class="sb-section-label">My Work</div>
                    <a href="{{ route('employee.attendance.index') }}" class="sb-link {{ request()->routeIs('employee.attendance.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-clock-fill"></i></span> My Attendance
                    </a>
                    <a href="{{ route('employee.leaves.index') }}" class="sb-link {{ request()->routeIs('employee.leaves.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-calendar-check-fill"></i></span> My Leaves
                    </a>
                    <a href="{{ route('employee.profile.show') }}" class="sb-link {{ request()->routeIs('employee.profile.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-person-badge-fill"></i></span> My Profile
                    </a>
                </div>
                <div class="sb-section">
                    <div class="sb-section-label">Info</div>
                    <a href="{{ route('holidays.calendar') }}" class="sb-link {{ request()->routeIs('holidays.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-calendar-event-fill"></i></span> Holidays
                    </a>
                    <a href="{{ route('announcements.public') }}" class="sb-link {{ request()->routeIs('announcements.*') ? 'active' : '' }}">
                        <span class="sb-icon"><i class="bi bi-megaphone-fill"></i></span> Announcements
                    </a>
                </div>
                @endrole
            </nav>

            {{-- User Card --}}
            @php
                $role = Auth::user()->roles->first()->name ?? 'user';
                $initials = strtoupper(substr(Auth::user()->name, 0, 2));
                $avatarColors = ['admin'=>'#6366f1','manager'=>'#8b5cf6','employee'=>'#06b6d4'];
                $aColor = $avatarColors[$role] ?? '#64748b';
            @endphp
            <div class="sb-user">
                <div class="sb-user-avatar" style="background:{{ $aColor }};color:#fff;">{{ $initials }}</div>
                <div class="sb-user-info">
                    <div class="sb-user-name">{{ Auth::user()->name }}</div>
                    <div class="sb-user-role">{{ $role }}</div>
                </div>
                <button class="sb-user-logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();" title="Logout">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </aside>

        {{-- ===== OVERLAY ===== --}}
        <div class="sb-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        {{-- ===== TOPBAR ===== --}}
        <header class="ems-topbar">
            <button class="topbar-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <div class="topbar-left">
                <span class="topbar-breadcrumb"><strong>{{ config('app.name', 'EMS') }}</strong></span>
            </div>
            <div class="topbar-right">
                <span class="topbar-date"><i class="bi bi-calendar3"></i> {{ now()->format('D, d M Y') }}</span>
                <div class="topbar-user-btn" onclick="this.classList.toggle('open')" tabindex="0" onblur="setTimeout(()=>this.classList.remove('open'),200)">
                    <div class="topbar-avatar-sm" style="background:{{ $aColor }};">{{ $initials }}</div>
                    {{ Auth::user()->name }}
                    <i class="bi bi-chevron-down" style="font-size:.7rem;color:#94a3b8;"></i>
                    <div class="topbar-dropdown">
                        <a href="{{ route('change-password') }}" class="topbar-dd-item"><i class="bi bi-key-fill"></i> Change Password</a>
                    </div>
                </div>
            </div>
        </header>

        {{-- ===== MAIN ===== --}}
        <main class="ems-main">
            @yield('content')
        </main>

        @else
        {{-- Guest - no sidebar --}}
        <main class="col-12 py-4">
            @yield('content')
        </main>
        @endauth
    </div>

    <script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebarOverlay').classList.toggle('open');
    }
    </script>
</body>
</html>
