@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    :root {
        --primary: #4f46e5;
        --primary-light: #6366f1;
        --primary-dark: #4338ca;
        --success: #059669;
        --success-bg: #ecfdf5;
        --success-border: #a7f3d0;
        --danger: #dc2626;
        --danger-bg: #fef2f2;
        --danger-border: #fecaca;
        --warning: #d97706;
        --warning-bg: #fffbeb;
        --warning-border: #fde68a;
        --gray: #6b7280;
        --gray-bg: #f3f4f6;
        --gray-border: #e5e7eb;
        --gray-light: #f9fafb;
        --gray-dark: #374151;
        --text-primary: #111827;
        --text-secondary: #6b7280;
        --text-muted: #9ca3af;
        --white: #ffffff;
        --border: #e5e7eb;
        --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05);
        --shadow: 0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px -1px rgba(0,0,0,0.1);
        --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1);
        --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
        --radius: 12px;
        --radius-sm: 8px;
        --radius-xs: 6px;
    }

    .emp-page {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        padding: 32px 0;
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 50%, #f8fafc 100%);
        -webkit-font-smoothing: antialiased;
    }

    .emp-container {
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* Flash Messages */
    .emp-flash {
        padding: 14px 20px;
        border-radius: var(--radius-sm);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 500;
        animation: fadeUp 0.5s ease both;
        border: 1px solid;
    }

    .emp-flash-success {
        background: var(--success-bg);
        color: var(--success);
        border-color: var(--success-border);
    }

    .emp-flash-error {
        background: var(--danger-bg);
        color: var(--danger);
        border-color: var(--danger-border);
    }

    .emp-flash-warning {
        background: var(--warning-bg);
        color: var(--warning);
        border-color: var(--warning-border);
    }

    .emp-flash i {
        font-size: 18px;
    }

    /* Page Header */
    .emp-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        animation: fadeUp 0.5s ease both;
    }

    .emp-header-left h1 {
        font-size: 28px;
        font-weight: 800;
        color: var(--text-primary);
        margin: 0;
        letter-spacing: -0.5px;
    }

    .emp-header-left p {
        font-size: 14px;
        color: var(--text-secondary);
        margin: 4px 0 0;
    }

    .emp-btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: var(--white);
        border: none;
        border-radius: var(--radius-sm);
        font-size: 14px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
        box-shadow: 0 4px 14px rgba(79,70,229,0.35);
        position: relative;
        overflow: hidden;
    }

    .emp-btn-add::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 100%);
        opacity: 0;
        transition: opacity 0.25s;
    }

    .emp-btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(79,70,229,0.45);
        color: var(--white);
        text-decoration: none;
    }

    .emp-btn-add:hover::before {
        opacity: 1;
    }

    .emp-btn-add i {
        font-size: 16px;
    }

    /* Filter Card */
    .emp-filter-card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 20px 24px;
        margin-bottom: 24px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        animation: fadeUp 0.5s ease 0.1s both;
    }

    .emp-filter-form {
        display: flex;
        align-items: flex-end;
        gap: 16px;
        flex-wrap: wrap;
    }

    .emp-filter-group {
        flex: 1;
        min-width: 180px;
    }

    .emp-filter-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .emp-filter-input,
    .emp-filter-select {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-xs);
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        color: var(--text-primary);
        background: var(--gray-light);
        transition: all 0.2s ease;
        outline: none;
        appearance: none;
        -webkit-appearance: none;
    }

    .emp-filter-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M2.22 4.47a.75.75 0 0 1 1.06 0L6 7.19l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L2.22 5.53a.75.75 0 0 1 0-1.06z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
    }

    .emp-filter-input:focus,
    .emp-filter-select:focus {
        border-color: var(--primary-light);
        box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        background: var(--white);
    }

    .emp-filter-input::placeholder {
        color: var(--text-muted);
    }

    .emp-filter-actions {
        display: flex;
        gap: 10px;
        align-items: center;
        padding-bottom: 1px;
    }

    .emp-btn-filter {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 20px;
        background: var(--primary);
        color: var(--white);
        border: none;
        border-radius: var(--radius-xs);
        font-size: 14px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .emp-btn-filter:hover {
        background: var(--primary-dark);
        box-shadow: var(--shadow-md);
    }

    .emp-btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 16px;
        background: transparent;
        color: var(--text-secondary);
        border: 1.5px solid var(--border);
        border-radius: var(--radius-xs);
        font-size: 14px;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .emp-btn-reset:hover {
        background: var(--gray-bg);
        color: var(--text-primary);
        border-color: var(--gray);
        text-decoration: none;
    }

    /* Table Card */
    .emp-table-card {
        background: var(--white);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        overflow: hidden;
        animation: fadeUp 0.5s ease 0.2s both;
    }

    .emp-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
    }

    .emp-table-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .emp-table-header-left h2 {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .emp-count-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 2px 10px;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: var(--primary);
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .emp-table-wrap {
        overflow-x: auto;
    }

    .emp-table {
        width: 100%;
        border-collapse: collapse;
    }

    .emp-table thead {
        background: var(--gray-light);
    }

    .emp-table thead th {
        padding: 12px 16px;
        font-size: 11px;
        font-weight: 700;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.6px;
        text-align: left;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    .emp-table tbody tr {
        transition: background 0.15s ease;
        border-bottom: 1px solid var(--border);
    }

    .emp-table tbody tr:last-child {
        border-bottom: none;
    }

    .emp-table tbody tr:hover {
        background: rgba(79,70,229,0.02);
    }

    .emp-table tbody td {
        padding: 14px 16px;
        font-size: 14px;
        color: var(--text-primary);
        vertical-align: middle;
        white-space: nowrap;
    }

    .emp-table .row-num {
        font-weight: 600;
        color: var(--text-muted);
        font-size: 13px;
        width: 50px;
    }

    /* Employee Cell */
    .emp-employee-cell {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .emp-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 700;
        color: var(--white);
        flex-shrink: 0;
        text-transform: uppercase;
        position: relative;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    }

    .emp-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .emp-avatar-1 { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
    .emp-avatar-2 { background: linear-gradient(135deg, #ec4899, #f43f5e); }
    .emp-avatar-3 { background: linear-gradient(135deg, #14b8a6, #06b6d4); }
    .emp-avatar-4 { background: linear-gradient(135deg, #f59e0b, #f97316); }
    .emp-avatar-5 { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
    .emp-avatar-6 { background: linear-gradient(135deg, #10b981, #34d399); }
    .emp-avatar-7 { background: linear-gradient(135deg, #3b82f6, #60a5fa); }

    .emp-info h4 {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 2px;
    }

    .emp-info p {
        font-size: 12.5px;
        color: var(--text-secondary);
        margin: 0;
    }

    /* Code Badge */
    .emp-code-badge {
        display: inline-flex;
        padding: 4px 10px;
        background: var(--gray-light);
        border: 1px solid var(--border);
        border-radius: var(--radius-xs);
        font-size: 12.5px;
        font-weight: 600;
        color: var(--gray-dark);
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        letter-spacing: 0.3px;
    }

    /* Status Badges */
    .emp-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
        letter-spacing: 0.2px;
    }

    .emp-status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .emp-status-active {
        background: var(--success-bg);
        color: var(--success);
        border: 1px solid var(--success-border);
    }
    .emp-status-active::before { background: var(--success); }

    .emp-status-inactive {
        background: var(--gray-bg);
        color: var(--gray);
        border: 1px solid var(--gray-border);
    }
    .emp-status-inactive::before { background: var(--gray); }

    .emp-status-terminated {
        background: var(--danger-bg);
        color: var(--danger);
        border: 1px solid var(--danger-border);
    }
    .emp-status-terminated::before { background: var(--danger); }

    .emp-status-resigned {
        background: var(--warning-bg);
        color: var(--warning);
        border: 1px solid var(--warning-border);
    }
    .emp-status-resigned::before { background: var(--warning); }

    /* Action Buttons */
    .emp-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .emp-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: var(--radius-xs);
        border: 1px solid var(--border);
        background: var(--white);
        color: var(--text-secondary);
        font-size: 15px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        padding: 0;
    }

    .emp-action-btn:hover {
        text-decoration: none;
    }

    .emp-action-view:hover {
        background: #eef2ff;
        color: var(--primary);
        border-color: #c7d2fe;
    }

    .emp-action-edit:hover {
        background: #fffbeb;
        color: var(--warning);
        border-color: var(--warning-border);
    }

    .emp-action-delete:hover {
        background: var(--danger-bg);
        color: var(--danger);
        border-color: var(--danger-border);
    }

    .emp-action-delete-form {
        display: inline;
        margin: 0;
        padding: 0;
    }

    /* Pagination */
    .emp-pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 24px;
        border-top: 1px solid var(--border);
        background: var(--gray-light);
    }

    .emp-pagination-info {
        font-size: 13px;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .emp-pagination-links {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .emp-pagination-links .page-item .page-link,
    .emp-pagination-links > a,
    .emp-pagination-links > span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border-radius: var(--radius-xs);
        font-size: 13px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        text-decoration: none;
        border: 1px solid var(--border);
        background: var(--white);
        color: var(--text-secondary);
        transition: all 0.2s ease;
    }

    .emp-pagination-links .page-item.active .page-link,
    .emp-pagination-links > span.current {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
        box-shadow: 0 2px 8px rgba(79,70,229,0.3);
    }

    .emp-pagination-links .page-item .page-link:hover,
    .emp-pagination-links > a:hover {
        background: #eef2ff;
        color: var(--primary);
        border-color: #c7d2fe;
        text-decoration: none;
    }

    .emp-pagination-links .page-item.disabled .page-link {
        opacity: 0.4;
        pointer-events: none;
    }

    /* Empty State */
    .emp-empty-state {
        text-align: center;
        padding: 80px 24px;
    }

    .emp-empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .emp-empty-icon i {
        font-size: 32px;
        color: var(--primary-light);
    }

    .emp-empty-state h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 8px;
    }

    .emp-empty-state p {
        font-size: 14px;
        color: var(--text-secondary);
        margin: 0 0 24px;
        max-width: 360px;
        margin-left: auto;
        margin-right: auto;
    }

    .emp-empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        background: var(--primary);
        color: var(--white);
        border: none;
        border-radius: var(--radius-sm);
        font-size: 14px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .emp-empty-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
        color: var(--white);
        text-decoration: none;
    }

    /* Tooltip */
    .emp-tooltip {
        position: relative;
    }

    .emp-tooltip::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: calc(100% + 8px);
        left: 50%;
        transform: translateX(-50%) scale(0.9);
        background: var(--text-primary);
        color: var(--white);
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 500;
        white-space: nowrap;
        pointer-events: none;
        opacity: 0;
        transition: all 0.2s ease;
        z-index: 10;
    }

    .emp-tooltip:hover::after {
        opacity: 1;
        transform: translateX(-50%) scale(1);
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

    .fade-up {
        animation: fadeUp 0.5s ease both;
    }

    .fade-up-1 { animation-delay: 0.05s; }
    .fade-up-2 { animation-delay: 0.1s; }
    .fade-up-3 { animation-delay: 0.15s; }
    .fade-up-4 { animation-delay: 0.2s; }
    .fade-up-5 { animation-delay: 0.25s; }
    .fade-up-6 { animation-delay: 0.3s; }

    /* Responsive */
    @media (max-width: 768px) {
        .emp-page { padding: 20px 0; }
        .emp-header { flex-direction: column; align-items: flex-start; gap: 16px; }
        .emp-filter-form { flex-direction: column; }
        .emp-filter-group { min-width: 100%; }
        .emp-pagination-wrap { flex-direction: column; gap: 12px; text-align: center; }
        .emp-table tbody td { font-size: 13px; padding: 12px; }
        .emp-container { padding: 0 16px; }
    }
</style>

<div class="emp-page">
    <div class="emp-container">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="emp-flash emp-flash-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="emp-flash emp-flash-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="emp-flash emp-flash-warning">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('warning') }}
            </div>
        @endif

        {{-- Page Header --}}
        <div class="emp-header">
            <div class="emp-header-left">
                <h1>Employees</h1>
                <p>Manage and oversee your organization's workforce</p>
            </div>
            <a href="{{ route('admin.employees.create') }}" class="emp-btn-add">
                <i class="bi bi-plus-lg"></i>
                Add Employee
            </a>
        </div>

        {{-- Filter Card --}}
        <div class="emp-filter-card">
            <form method="GET" action="{{ route('admin.employees.index') }}" class="emp-filter-form">
                <div class="emp-filter-group">
                    <label for="filter-search">Search</label>
                    <input
                        type="text"
                        id="filter-search"
                        name="search"
                        class="emp-filter-input"
                        placeholder="Search by name, email, code..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="emp-filter-group">
                    <label for="filter-department">Department</label>
                    <select id="filter-department" name="department_id" class="emp-filter-select">
                        <option value="">All Departments</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="emp-filter-group">
                    <label for="filter-designation">Designation</label>
                    <select id="filter-designation" name="designation_id" class="emp-filter-select">
                        <option value="">All Designations</option>
                        @foreach($designations as $designation)
                            <option value="{{ $designation->id }}" {{ request('designation_id') == $designation->id ? 'selected' : '' }}>
                                {{ $designation->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="emp-filter-group">
                    <label for="filter-status">Status</label>
                    <select id="filter-status" name="status" class="emp-filter-select">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                        <option value="resigned" {{ request('status') == 'resigned' ? 'selected' : '' }}>Resigned</option>
                    </select>
                </div>

                <div class="emp-filter-actions">
                    <button type="submit" class="emp-btn-filter">
                        <i class="bi bi-funnel"></i>
                        Filter
                    </button>
                    <a href="{{ route('admin.employees.index') }}" class="emp-btn-reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Employee Table --}}
        <div class="emp-table-card">
            <div class="emp-table-header">
                <div class="emp-table-header-left">
                    <h2>Employee Directory</h2>
                    <span class="emp-count-badge">{{ $employees->total() }} total</span>
                </div>
            </div>

            @if($employees->count() > 0)
                <div class="emp-table-wrap">
                    <table class="emp-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Employee</th>
                                <th>Code</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $index => $emp)
                                <tr class="fade-up fade-up-{{ ($index % 6) + 1 }}">
                                    <td class="row-num">{{ $employees->firstItem() + $index }}</td>
                                    <td>
                                        <div class="emp-employee-cell">
                                            <div class="emp-avatar emp-avatar-{{ ($index % 7) + 1 }}">
                                                @if($emp->profile_photo)
                                                    <img src="{{ asset('storage/' . $emp->profile_photo) }}" alt="{{ $emp->full_name }}">
                                                @else
                                                    {{ strtoupper(substr($emp->first_name, 0, 1) . substr($emp->last_name, 0, 1)) }}
                                                @endif
                                            </div>
                                            <div class="emp-info">
                                                <h4>{{ $emp->full_name }}</h4>
                                                <p>{{ $emp->user->email ?? '—' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="emp-code-badge">{{ $emp->employee_code }}</span>
                                    </td>
                                    <td>{{ $emp->department->name ?? '—' }}</td>
                                    <td>{{ $emp->designation->name ?? '—' }}</td>
                                    <td>
                                        <span class="emp-status-badge emp-status-{{ $emp->employment_status }}">
                                            {{ $emp->employment_status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="emp-actions" style="justify-content:flex-end;">
                                            <a href="{{ route('admin.employees.show', $emp) }}"
                                               class="emp-action-btn emp-action-view emp-tooltip"
                                               data-tooltip="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.employees.edit', $emp) }}"
                                               class="emp-action-btn emp-action-edit emp-tooltip"
                                               data-tooltip="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.employees.destroy', $emp) }}"
                                                  method="POST"
                                                  class="emp-action-delete-form"
                                                  onsubmit="return confirm('Are you sure you want to delete this employee? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="emp-action-btn emp-action-delete emp-tooltip"
                                                        data-tooltip="Delete">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($employees->hasPages())
                    <div class="emp-pagination-wrap">
                        <div class="emp-pagination-info">
                            Showing <strong>{{ $employees->firstItem() }}</strong> to <strong>{{ $employees->lastItem() }}</strong> of <strong>{{ $employees->total() }}</strong> results
                        </div>
                        <div class="emp-pagination-links">
                            {{ $employees->links() }}
                        </div>
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="emp-empty-state fade-up">
                    <div class="emp-empty-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3>No employees found</h3>
                    <p>
                        @if(request()->hasAny(['search', 'department_id', 'designation_id', 'status']))
                            No employees match your current filters. Try adjusting your search criteria.
                        @else
                            Get started by adding your first employee to the system.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'department_id', 'designation_id', 'status']))
                        <a href="{{ route('admin.employees.index') }}" class="emp-empty-btn">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Clear Filters
                        </a>
                    @else
                        <a href="{{ route('admin.employees.create') }}" class="emp-empty-btn">
                            <i class="bi bi-plus-lg"></i>
                            Add First Employee
                        </a>
                    @endif
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
