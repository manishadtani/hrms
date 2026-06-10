@extends('layouts.app')

@section('content')
<style>
    /* ── Base & Typography ── */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .desig-page * {
        font-family: 'Inter', sans-serif;
    }

    .desig-page {
        padding: 2rem 0 3rem;
        min-height: 80vh;
        background: linear-gradient(135deg, #f0f4ff 0%, #faf5ff 50%, #fdf2f8 100%);
    }

    /* ── Fade-Up Animation ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .desig-fade-up {
        animation: fadeUp .5s cubic-bezier(.22,1,.36,1) both;
    }

    .desig-fade-up-d1 { animation-delay: .08s; }
    .desig-fade-up-d2 { animation-delay: .16s; }
    .desig-fade-up-d3 { animation-delay: .24s; }

    /* ── Page Header ── */
    .desig-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .desig-header-left h1 {
        font-size: 1.85rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
        letter-spacing: -.5px;
    }

    .desig-header-left p {
        color: #64748b;
        font-size: .92rem;
        margin: .25rem 0 0;
        font-weight: 500;
    }

    .desig-btn-add {
        display: inline-flex;
        align-items: center;
        gap: .55rem;
        padding: .7rem 1.5rem;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: .9rem;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 16px rgba(99,102,241,.35);
        transition: all .25s cubic-bezier(.22,1,.36,1);
        cursor: pointer;
    }

    .desig-btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(99,102,241,.45);
        color: #fff;
        text-decoration: none;
        background: linear-gradient(135deg, #818cf8 0%, #6366f1 100%);
    }

    .desig-btn-add:active {
        transform: translateY(0);
    }

    /* ── Flash Messages ── */
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .desig-alert {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 1rem 1.25rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        font-size: .9rem;
        font-weight: 500;
        animation: slideDown .4s cubic-bezier(.22,1,.36,1) both;
        border: 1px solid transparent;
    }

    .desig-alert-success {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        color: #065f46;
        border-color: #a7f3d0;
    }

    .desig-alert-danger {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        color: #991b1b;
        border-color: #fca5a5;
    }

    .desig-alert-warning {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        color: #92400e;
        border-color: #fcd34d;
    }

    .desig-alert-icon {
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .desig-alert-close {
        margin-left: auto;
        background: none;
        border: none;
        font-size: 1.15rem;
        cursor: pointer;
        opacity: .6;
        transition: opacity .2s;
        color: inherit;
    }

    .desig-alert-close:hover {
        opacity: 1;
    }

    /* ── Premium Card ── */
    .desig-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 8px 32px rgba(0,0,0,.04);
        border: 1px solid rgba(0,0,0,.06);
        overflow: hidden;
        transition: box-shadow .3s;
    }

    .desig-card:hover {
        box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 12px 40px rgba(0,0,0,.07);
    }

    /* ── Card Header / Search ── */
    .desig-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        background: linear-gradient(to right, #fafaff, #fff);
    }

    .desig-card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #334155;
        display: flex;
        align-items: center;
        gap: .5rem;
        margin: 0;
    }

    .desig-card-title i {
        color: #6366f1;
        font-size: 1.1rem;
    }

    .desig-search-form {
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .desig-search-wrap {
        position: relative;
    }

    .desig-search-wrap i {
        position: absolute;
        left: .85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: .95rem;
        pointer-events: none;
    }

    .desig-search-input {
        padding: .6rem 1rem .6rem 2.5rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: .875rem;
        font-family: 'Inter', sans-serif;
        color: #334155;
        background: #f8fafc;
        width: 260px;
        transition: all .25s;
        outline: none;
    }

    .desig-search-input::placeholder {
        color: #94a3b8;
    }

    .desig-search-input:focus {
        border-color: #6366f1;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
    }

    .desig-search-btn {
        padding: .6rem 1.15rem;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: .875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s;
        display: inline-flex;
        align-items: center;
        gap: .35rem;
    }

    .desig-search-btn:hover {
        background: linear-gradient(135deg, #818cf8, #6366f1);
        transform: translateY(-1px);
    }

    .desig-clear-link {
        font-size: .82rem;
        color: #6366f1;
        text-decoration: none;
        font-weight: 600;
        transition: color .2s;
    }

    .desig-clear-link:hover {
        color: #4338ca;
        text-decoration: underline;
    }

    /* ── Table ── */
    .desig-table-wrap {
        overflow-x: auto;
    }

    .desig-table {
        width: 100%;
        border-collapse: collapse;
    }

    .desig-table thead th {
        padding: .85rem 1.25rem;
        text-align: left;
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    .desig-table tbody tr {
        transition: background .2s;
        border-bottom: 1px solid #f1f5f9;
    }

    .desig-table tbody tr:hover {
        background: #f8fafc;
    }

    .desig-table tbody tr:last-child {
        border-bottom: none;
    }

    .desig-table tbody td {
        padding: .9rem 1.25rem;
        font-size: .9rem;
        color: #334155;
        vertical-align: middle;
    }

    .desig-row-num {
        font-weight: 700;
        color: #94a3b8;
        font-size: .82rem;
    }

    .desig-name {
        font-weight: 600;
        color: #1e293b;
        font-size: .92rem;
    }

    .desig-desc {
        color: #64748b;
        font-size: .85rem;
        max-width: 260px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* ── Status Badge ── */
    .desig-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .3rem .75rem;
        border-radius: 20px;
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .2px;
    }

    .desig-badge-active {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        color: #065f46;
    }

    .desig-badge-active::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #10b981;
        display: inline-block;
        box-shadow: 0 0 6px rgba(16,185,129,.5);
    }

    .desig-badge-inactive {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        color: #991b1b;
    }

    .desig-badge-inactive::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #ef4444;
        display: inline-block;
    }

    /* ── Employees Count Badge ── */
    .desig-emp-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .3rem .7rem;
        border-radius: 20px;
        font-size: .78rem;
        font-weight: 600;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: #3730a3;
    }

    .desig-emp-badge i {
        font-size: .82rem;
    }

    /* ── Action Buttons ── */
    .desig-actions {
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .desig-btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: 1.5px solid transparent;
        background: #f8fafc;
        color: #64748b;
        font-size: .95rem;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
    }

    .desig-btn-edit {
        border-color: #e0e7ff;
        color: #4f46e5;
    }

    .desig-btn-edit:hover {
        background: #eef2ff;
        color: #4338ca;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99,102,241,.18);
    }

    .desig-btn-delete {
        border-color: #fee2e2;
        color: #dc2626;
        background: none;
    }

    .desig-btn-delete:hover {
        background: #fef2f2;
        color: #b91c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220,38,38,.15);
    }

    /* ── Pagination ── */
    .desig-pagination-wrap {
        padding: 1.25rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .75rem;
        background: #fafaff;
    }

    .desig-pagination-info {
        font-size: .84rem;
        color: #64748b;
        font-weight: 500;
    }

    .desig-pagination-links {
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    .desig-pagination-links .page-item .page-link,
    .desig-pagination-links > a,
    .desig-pagination-links > span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 .5rem;
        border-radius: 10px;
        font-size: .84rem;
        font-weight: 600;
        color: #475569;
        background: #fff;
        border: 1.5px solid #e2e8f0;
        text-decoration: none;
        transition: all .2s;
        cursor: pointer;
    }

    .desig-pagination-links .page-item.active .page-link {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        border-color: #6366f1;
        box-shadow: 0 3px 10px rgba(99,102,241,.3);
    }

    .desig-pagination-links .page-item.disabled .page-link {
        opacity: .45;
        cursor: not-allowed;
    }

    .desig-pagination-links .page-item .page-link:hover:not(.active) {
        background: #eef2ff;
        border-color: #c7d2fe;
        color: #4f46e5;
    }

    /* ── Empty State ── */
    .desig-empty {
        text-align: center;
        padding: 3.5rem 1.5rem;
    }

    .desig-empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
    }

    .desig-empty-icon i {
        font-size: 2rem;
        color: #6366f1;
    }

    .desig-empty h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #334155;
        margin: 0 0 .5rem;
    }

    .desig-empty p {
        color: #64748b;
        font-size: .9rem;
        margin: 0 0 1.25rem;
    }

    /* ── Delete Modal ── */
    .desig-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15,23,42,.45);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .desig-modal-overlay.active {
        display: flex;
    }

    .desig-modal {
        background: #fff;
        border-radius: 20px;
        padding: 2rem;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 24px 64px rgba(0,0,0,.18);
        text-align: center;
        animation: fadeUp .3s cubic-bezier(.22,1,.36,1) both;
    }

    .desig-modal-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .desig-modal-icon i {
        font-size: 1.75rem;
        color: #ef4444;
    }

    .desig-modal h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 .5rem;
    }

    .desig-modal p {
        color: #64748b;
        font-size: .9rem;
        margin: 0 0 1.5rem;
    }

    .desig-modal-actions {
        display: flex;
        gap: .75rem;
        justify-content: center;
    }

    .desig-modal-cancel {
        padding: .6rem 1.25rem;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        color: #475569;
        font-weight: 600;
        font-size: .88rem;
        cursor: pointer;
        transition: all .2s;
        font-family: 'Inter', sans-serif;
    }

    .desig-modal-cancel:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .desig-modal-confirm {
        padding: .6rem 1.25rem;
        border-radius: 10px;
        border: none;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #fff;
        font-weight: 600;
        font-size: .88rem;
        cursor: pointer;
        transition: all .2s;
        box-shadow: 0 4px 12px rgba(239,68,68,.3);
        font-family: 'Inter', sans-serif;
    }

    .desig-modal-confirm:hover {
        background: linear-gradient(135deg, #f87171, #ef4444);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(239,68,68,.35);
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .desig-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .desig-card-header {
            flex-direction: column;
            align-items: stretch;
        }
        .desig-search-input {
            width: 100%;
        }
        .desig-search-form {
            width: 100%;
        }
        .desig-search-wrap {
            flex: 1;
        }
        .desig-pagination-wrap {
            flex-direction: column;
            align-items: center;
        }
    }
</style>

<div class="desig-page">
    <div class="container">

        {{-- ── Flash Messages ── --}}
        @foreach(['success', 'danger', 'warning'] as $type)
            @if(session($type))
                <div class="desig-alert desig-alert-{{ $type }}">
                    <i class="bi desig-alert-icon
                        @if($type === 'success') bi-check-circle-fill
                        @elseif($type === 'danger') bi-x-circle-fill
                        @else bi-exclamation-triangle-fill @endif
                    "></i>
                    <span>{{ session($type) }}</span>
                    <button type="button" class="desig-alert-close" onclick="this.parentElement.style.display='none'">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            @endif
        @endforeach

        {{-- ── Page Header ── --}}
        <div class="desig-header desig-fade-up">
            <div class="desig-header-left">
                <h1><i class="bi bi-diagram-3-fill" style="color:#6366f1;margin-right:.35rem;"></i> Designations</h1>
                <p>Manage organizational designations &amp; roles</p>
            </div>
            <a href="{{ route('admin.designations.create') }}" class="desig-btn-add">
                <i class="bi bi-plus-lg"></i>
                Add Designation
            </a>
        </div>

        {{-- ── Main Card ── --}}
        <div class="desig-card desig-fade-up desig-fade-up-d1">

            {{-- Card Header / Search --}}
            <div class="desig-card-header">
                <h2 class="desig-card-title">
                    <i class="bi bi-table"></i>
                    All Designations
                    <span style="font-size:.78rem;font-weight:500;color:#94a3b8;margin-left:.25rem;">({{ $designations->total() }})</span>
                </h2>
                <form action="{{ route('admin.designations.index') }}" method="GET" class="desig-search-form">
                    <div class="desig-search-wrap">
                        <i class="bi bi-search"></i>
                        <input
                            type="text"
                            name="search"
                            class="desig-search-input"
                            placeholder="Search designations..."
                            value="{{ request('search') }}"
                        >
                    </div>
                    <button type="submit" class="desig-search-btn">
                        <i class="bi bi-search"></i>
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.designations.index') }}" class="desig-clear-link">Clear</a>
                    @endif
                </form>
            </div>

            {{-- Table --}}
            @if($designations->count())
                <div class="desig-table-wrap">
                    <table class="desig-table">
                        <thead>
                            <tr>
                                <th style="width:50px;">#</th>
                                <th>Designation Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Employees</th>
                                <th style="width:120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($designations as $index => $desig)
                                <tr>
                                    <td class="desig-row-num">{{ $designations->firstItem() + $index }}</td>
                                    <td class="desig-name">{{ $desig->name }}</td>
                                    <td>
                                        <div class="desig-desc" title="{{ $desig->description }}">
                                            {{ $desig->description ?? '—' }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($desig->is_active)
                                            <span class="desig-badge desig-badge-active">Active</span>
                                        @else
                                            <span class="desig-badge desig-badge-inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="desig-emp-badge">
                                            <i class="bi bi-people-fill"></i>
                                            {{ $desig->employees_count }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="desig-actions">
                                            <a href="{{ route('admin.designations.edit', $desig->id) }}" class="desig-btn-action desig-btn-edit" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="desig-btn-action desig-btn-delete" title="Delete"
                                                onclick="openDesigDeleteModal('{{ $desig->id }}', '{{ addslashes($desig->name) }}')">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($designations->hasPages())
                    <div class="desig-pagination-wrap desig-fade-up desig-fade-up-d2">
                        <div class="desig-pagination-info">
                            Showing {{ $designations->firstItem() }}–{{ $designations->lastItem() }} of {{ $designations->total() }} designations
                        </div>
                        <div class="desig-pagination-links">
                            {{ $designations->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="desig-empty desig-fade-up desig-fade-up-d2">
                    <div class="desig-empty-icon">
                        <i class="bi bi-diagram-3"></i>
                    </div>
                    @if(request('search'))
                        <h3>No designations found</h3>
                        <p>No designations match "<strong>{{ request('search') }}</strong>". Try a different search term.</p>
                        <a href="{{ route('admin.designations.index') }}" class="desig-btn-add" style="font-size:.85rem;padding:.55rem 1.25rem;">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Clear Search
                        </a>
                    @else
                        <h3>No designations yet</h3>
                        <p>Get started by creating your first designation.</p>
                        <a href="{{ route('admin.designations.create') }}" class="desig-btn-add" style="font-size:.85rem;padding:.55rem 1.25rem;">
                            <i class="bi bi-plus-lg"></i>
                            Add Designation
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ── Delete Confirmation Modal ── --}}
<div class="desig-modal-overlay" id="desigDeleteModal">
    <div class="desig-modal">
        <div class="desig-modal-icon">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <h3>Delete Designation</h3>
        <p>Are you sure you want to delete <strong id="desigDeleteName"></strong>? This action cannot be undone.</p>
        <div class="desig-modal-actions">
            <button type="button" class="desig-modal-cancel" onclick="closeDesigDeleteModal()">Cancel</button>
            <form id="desigDeleteForm" method="POST" style="margin:0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="desig-modal-confirm">
                    <i class="bi bi-trash3"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDesigDeleteModal(id, name) {
        document.getElementById('desigDeleteName').textContent = name;
        document.getElementById('desigDeleteForm').action = '{{ url("admin/designations") }}/' + id;
        document.getElementById('desigDeleteModal').classList.add('active');
    }

    function closeDesigDeleteModal() {
        document.getElementById('desigDeleteModal').classList.remove('active');
    }

    // Close modal on overlay click
    document.getElementById('desigDeleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDesigDeleteModal();
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDesigDeleteModal();
    });
</script>
@endsection
