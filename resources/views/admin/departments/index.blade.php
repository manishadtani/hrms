@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .dept-page {
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

    /* ── Page header ── */
    .dept-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .dept-header-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -.025em;
        margin: 0;
    }
    .dept-header-title i {
        color: #6366f1;
        margin-right: .5rem;
        font-size: 1.5rem;
    }
    .btn-add-dept {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .65rem 1.5rem;
        font-size: .875rem;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
        border: none;
        border-radius: .625rem;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(99,102,241,.35);
        transition: all .25s ease;
        cursor: pointer;
    }
    .btn-add-dept:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99,102,241,.45);
        color: #fff;
        text-decoration: none;
    }

    /* ── Flash messages ── */
    .dept-flash {
        padding: .85rem 1.25rem;
        border-radius: .625rem;
        font-size: .875rem;
        font-weight: 500;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .dept-flash-success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .dept-flash-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* ── Card ── */
    .dept-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 14px rgba(0,0,0,.04);
        overflow: hidden;
    }

    /* ── Search bar ── */
    .dept-search-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .75rem;
        padding: 1.125rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        background: #fafbfc;
    }
    .dept-search-header h6 {
        margin: 0;
        font-weight: 700;
        font-size: .9rem;
        color: #334155;
    }
    .dept-search-form {
        display: flex;
        gap: .5rem;
    }
    .dept-search-input {
        padding: .5rem 1rem;
        font-size: .8125rem;
        font-family: 'Inter', sans-serif;
        border: 1px solid #e2e8f0;
        border-radius: .5rem;
        outline: none;
        min-width: 240px;
        transition: border-color .2s, box-shadow .2s;
        color: #334155;
        background: #fff;
    }
    .dept-search-input::placeholder {
        color: #94a3b8;
    }
    .dept-search-input:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
    }
    .dept-search-btn {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .5rem 1rem;
        font-size: .8125rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        color: #6366f1;
        background: #eef2ff;
        border: 1px solid #c7d2fe;
        border-radius: .5rem;
        cursor: pointer;
        transition: all .2s;
    }
    .dept-search-btn:hover {
        background: #e0e7ff;
    }

    /* ── Table ── */
    .dept-table {
        width: 100%;
        border-collapse: collapse;
    }
    .dept-table thead th {
        padding: .85rem 1.25rem;
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .dept-table tbody tr {
        transition: background .2s;
    }
    .dept-table tbody tr:hover {
        background: #f8fafc;
    }
    .dept-table tbody td {
        padding: .85rem 1.25rem;
        font-size: .8125rem;
        color: #475569;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .dept-table tbody tr:last-child td {
        border-bottom: none;
    }
    .dept-name {
        font-weight: 700;
        color: #1e293b;
    }
    .dept-desc {
        max-width: 260px;
        color: #64748b;
        font-size: .8rem;
        line-height: 1.5;
    }

    /* ── Badges ── */
    .badge-active {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .275rem .7rem;
        font-size: .7rem;
        font-weight: 600;
        border-radius: 9999px;
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }
    .badge-inactive {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .275rem .7rem;
        font-size: .7rem;
        font-weight: 600;
        border-radius: 9999px;
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .badge-emp-count {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .3rem .75rem;
        font-size: .75rem;
        font-weight: 600;
        border-radius: 9999px;
        background: #eef2ff;
        color: #4f46e5;
        border: 1px solid #c7d2fe;
    }

    /* ── Actions ── */
    .dept-actions {
        display: flex;
        align-items: center;
        gap: .35rem;
    }
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        font-size: .85rem;
        border-radius: .5rem;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
    }
    .btn-action-edit {
        color: #6366f1;
        background: #eef2ff;
        border-color: #e0e7ff;
    }
    .btn-action-edit:hover {
        background: #e0e7ff;
        color: #4f46e5;
    }
    .btn-action-delete {
        color: #ef4444;
        background: #fef2f2;
        border-color: #fecaca;
        font-family: inherit;
    }
    .btn-action-delete:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    /* ── Empty state ── */
    .dept-empty {
        padding: 3.5rem 1rem;
        text-align: center;
    }
    .dept-empty-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        color: #6366f1;
        margin-bottom: 1rem;
    }
    .dept-empty h5 {
        font-size: 1rem;
        font-weight: 700;
        color: #334155;
        margin: 0 0 .35rem;
    }
    .dept-empty p {
        font-size: .8125rem;
        color: #94a3b8;
        margin: 0;
    }

    /* ── Pagination ── */
    .dept-pagination {
        padding: 1rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .75rem;
    }
    .dept-pagination-info {
        font-size: .775rem;
        color: #94a3b8;
        font-weight: 500;
    }
    .dept-pagination .pagination {
        margin: 0;
        gap: .25rem;
    }
    .dept-pagination .page-link {
        font-family: 'Inter', sans-serif;
        font-size: .775rem;
        font-weight: 600;
        padding: .35rem .7rem;
        border-radius: .45rem;
        border: 1px solid #e2e8f0;
        color: #475569;
        background: #fff;
        transition: all .2s;
    }
    .dept-pagination .page-link:hover {
        background: #eef2ff;
        color: #4f46e5;
        border-color: #c7d2fe;
    }
    .dept-pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #6366f1, #818cf8);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 2px 8px rgba(99,102,241,.3);
    }
    .dept-pagination .page-item.disabled .page-link {
        color: #cbd5e1;
        background: #f8fafc;
        border-color: #e2e8f0;
    }

    /* ── Row serial number ── */
    .row-num {
        font-weight: 600;
        color: #94a3b8;
        font-size: .75rem;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .dept-header { flex-direction: column; align-items: flex-start; }
        .dept-search-form { width: 100%; }
        .dept-search-input { min-width: 0; flex: 1; }
        .dept-table thead { display: none; }
        .dept-table tbody tr {
            display: block;
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .dept-table tbody td {
            display: flex;
            justify-content: space-between;
            padding: .4rem 0;
            border: none;
        }
        .dept-table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            color: #64748b;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
    }
</style>

<div class="dept-page">
    <div class="container">

        {{-- ── Flash Messages ── --}}
        @if(session('success'))
            <div class="dept-flash dept-flash-success fade-up">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="dept-flash dept-flash-error fade-up">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- ── Page Header ── --}}
        <div class="dept-header fade-up">
            <h1 class="dept-header-title">
                <i class="bi bi-diagram-3-fill"></i>Departments
            </h1>
            <a href="{{ route('admin.departments.create') }}" class="btn-add-dept">
                <i class="bi bi-plus-lg"></i>
                Add Department
            </a>
        </div>

        {{-- ── Main Card ── --}}
        <div class="dept-card fade-up fade-up-d1">

            {{-- Search Header --}}
            <div class="dept-search-header">
                <h6><i class="bi bi-funnel-fill" style="margin-right:.4rem;color:#6366f1;"></i>Filter Departments</h6>
                <form action="{{ route('admin.departments.index') }}" method="GET" class="dept-search-form">
                    <input
                        type="text"
                        name="search"
                        class="dept-search-input"
                        placeholder="Search by department name…"
                        value="{{ request('search') }}"
                    />
                    <button type="submit" class="dept-search-btn">
                        <i class="bi bi-search"></i> Search
                    </button>
                </form>
            </div>

            {{-- Table --}}
            @if($departments->count())
                <div style="overflow-x:auto;">
                    <table class="dept-table">
                        <thead>
                            <tr>
                                <th style="width:50px;">#</th>
                                <th>Department Name</th>
                                <th>Description</th>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:center;">Employees</th>
                                <th style="text-align:center;width:110px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $index => $dept)
                                <tr class="fade-up" style="animation-delay:{{ 0.18 + ($index * 0.04) }}s;">
                                    <td data-label="#">
                                        <span class="row-num">{{ $departments->firstItem() + $index }}</span>
                                    </td>
                                    <td data-label="Name">
                                        <span class="dept-name">{{ $dept->name }}</span>
                                    </td>
                                    <td data-label="Description">
                                        <span class="dept-desc">{{ Str::limit($dept->description, 60) }}</span>
                                    </td>
                                    <td data-label="Status" style="text-align:center;">
                                        @if($dept->is_active)
                                            <span class="badge-active">
                                                <i class="bi bi-check-circle-fill"></i> Active
                                            </span>
                                        @else
                                            <span class="badge-inactive">
                                                <i class="bi bi-x-circle-fill"></i> Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td data-label="Employees" style="text-align:center;">
                                        <span class="badge-emp-count">
                                            <i class="bi bi-people-fill"></i>
                                            {{ $dept->employees_count }}
                                        </span>
                                    </td>
                                    <td data-label="Actions" style="text-align:center;">
                                        <div class="dept-actions" style="justify-content:center;">
                                            <a href="{{ route('admin.departments.edit', $dept) }}" class="btn-action btn-action-edit" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('admin.departments.destroy', $dept) }}" method="POST" style="margin:0;" onsubmit="return confirm('Are you sure you want to delete this department?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-action-delete" title="Delete">
                                                    <i class="bi bi-trash3-fill"></i>
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
                @if($departments->hasPages())
                    <div class="dept-pagination fade-up fade-up-d2">
                        <span class="dept-pagination-info">
                            Showing {{ $departments->firstItem() }}–{{ $departments->lastItem() }} of {{ $departments->total() }} departments
                        </span>
                        {{ $departments->appends(request()->query())->links() }}
                    </div>
                @endif

            @else
                {{-- Empty State --}}
                <div class="dept-empty fade-up fade-up-d2">
                    <div class="dept-empty-icon">
                        <i class="bi bi-diagram-3"></i>
                    </div>
                    <h5>No departments found</h5>
                    <p>
                        @if(request('search'))
                            No results for "<strong>{{ request('search') }}</strong>". Try a different search term.
                        @else
                            Get started by creating your first department.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
