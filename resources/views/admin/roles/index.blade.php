@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .roles-page {
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
        background: linear-gradient(135deg, #f0f4ff 0%, #faf5ff 50%, #f0fdf4 100%);
        padding: 2.5rem 2rem 4rem;
    }

    /* ── Flash Messages ── */
    .flash-toast {
        max-width: 720px;
        margin: 0 auto 1.75rem;
        padding: 1rem 1.25rem;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        animation: fadeUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }
    .flash-toast.success {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .flash-toast.error {
        background: linear-gradient(135deg, #fef2f2, #fecaca);
        color: #991b1b;
        border: 1px solid #fca5a5;
    }
    .flash-toast.warning {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        color: #92400e;
        border: 1px solid #fde68a;
    }
    .flash-toast i {
        font-size: 1.15rem;
    }

    /* ── Page Header ── */
    .roles-header {
        max-width: 1200px;
        margin: 0 auto 2.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        animation: fadeUp 0.45s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }
    .roles-header-left {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }
    .roles-header-title {
        font-size: 1.85rem;
        font-weight: 800;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.03em;
        margin: 0;
    }
    .roles-header-subtitle {
        font-size: 0.92rem;
        color: #6b7280;
        font-weight: 400;
    }
    .btn-add-role {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.7rem 1.5rem;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
    }
    .btn-add-role:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(79, 70, 229, 0.45);
        color: #fff;
        text-decoration: none;
    }
    .btn-add-role:active {
        transform: translateY(0);
    }
    .btn-add-role i {
        font-size: 1.05rem;
    }

    /* ── Cards Grid ── */
    .roles-grid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    /* ── Role Card ── */
    .role-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.04);
        transition: all 0.35s cubic-bezier(0.22, 1, 0.36, 1);
        display: flex;
        flex-direction: column;
        position: relative;
        opacity: 0;
        animation: fadeUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }
    .role-card:nth-child(1) { animation-delay: 0.08s; }
    .role-card:nth-child(2) { animation-delay: 0.16s; }
    .role-card:nth-child(3) { animation-delay: 0.24s; }
    .role-card:nth-child(4) { animation-delay: 0.32s; }
    .role-card:nth-child(5) { animation-delay: 0.40s; }
    .role-card:nth-child(6) { animation-delay: 0.48s; }
    .role-card:nth-child(7) { animation-delay: 0.56s; }
    .role-card:nth-child(8) { animation-delay: 0.64s; }
    .role-card:nth-child(9) { animation-delay: 0.72s; }

    .role-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.10), 0 2px 8px rgba(0,0,0,0.04);
    }

    .role-card-topbar {
        height: 5px;
        width: 100%;
    }
    .role-card-topbar.admin    { background: linear-gradient(90deg, #dc2626, #ef4444); }
    .role-card-topbar.manager  { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .role-card-topbar.employee { background: linear-gradient(90deg, #10b981, #34d399); }
    .role-card-topbar.default  { background: linear-gradient(90deg, #6366f1, #818cf8); }

    .role-card-body {
        padding: 1.5rem 1.5rem 1rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .role-icon-name {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.15rem;
    }
    .role-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .role-icon-wrap.admin    { background: linear-gradient(135deg, #fef2f2, #fee2e2); color: #dc2626; }
    .role-icon-wrap.manager  { background: linear-gradient(135deg, #fffbeb, #fef3c7); color: #d97706; }
    .role-icon-wrap.employee { background: linear-gradient(135deg, #ecfdf5, #d1fae5); color: #059669; }
    .role-icon-wrap.default  { background: linear-gradient(135deg, #eef2ff, #e0e7ff); color: #4f46e5; }

    .role-icon-wrap i {
        font-size: 1.35rem;
    }
    .role-name {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e1b4b;
        text-transform: capitalize;
        letter-spacing: -0.01em;
    }

    /* ── Metric Pills ── */
    .role-metrics {
        display: flex;
        gap: 0.6rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }
    .metric-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.01em;
    }
    .metric-pill.indigo {
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: #4338ca;
    }
    .metric-pill.emerald {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        color: #047857;
    }
    .metric-pill i {
        font-size: 0.82rem;
    }

    /* ── Created Date ── */
    .role-created {
        font-size: 0.8rem;
        color: #9ca3af;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        margin-top: auto;
        padding-top: 0.5rem;
    }
    .role-created i {
        font-size: 0.85rem;
    }

    /* ── Card Footer / Actions ── */
    .role-card-footer {
        padding: 0.85rem 1.5rem;
        border-top: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        background: #fafbfc;
    }
    .btn-role-action {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 0.95rem;
        border-radius: 9px;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
        text-decoration: none;
        border: none;
    }
    .btn-edit {
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: #4338ca;
    }
    .btn-edit:hover {
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        color: #3730a3;
        text-decoration: none;
        transform: translateY(-1px);
    }
    .btn-delete {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        color: #dc2626;
    }
    .btn-delete:hover {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #b91c1c;
        transform: translateY(-1px);
    }
    .btn-role-action i {
        font-size: 0.85rem;
    }

    /* ── Empty State ── */
    .roles-empty {
        max-width: 1200px;
        margin: 0 auto;
        text-align: center;
        padding: 5rem 2rem;
        animation: fadeUp 0.55s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }
    .empty-icon-wrap {
        width: 96px;
        height: 96px;
        border-radius: 28px;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }
    .empty-icon-wrap i {
        font-size: 2.5rem;
        color: #6366f1;
    }
    .empty-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: #1e1b4b;
        margin-bottom: 0.5rem;
    }
    .empty-desc {
        font-size: 0.92rem;
        color: #6b7280;
        margin-bottom: 1.75rem;
        max-width: 380px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    /* ── Delete Confirm Modal ── */
    .delete-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 15, 35, 0.45);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .delete-modal-overlay.active {
        display: flex;
        animation: fadeIn 0.2s ease;
    }
    .delete-modal {
        background: #fff;
        border-radius: 20px;
        padding: 2rem 2rem 1.5rem;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 24px 64px rgba(0,0,0,0.18);
        animation: scaleIn 0.25s cubic-bezier(0.22, 1, 0.36, 1);
        text-align: center;
    }
    .delete-modal-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }
    .delete-modal-icon i {
        font-size: 1.6rem;
        color: #dc2626;
    }
    .delete-modal h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e1b4b;
        margin-bottom: 0.4rem;
    }
    .delete-modal p {
        font-size: 0.88rem;
        color: #6b7280;
        line-height: 1.55;
        margin-bottom: 1.5rem;
    }
    .delete-modal-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }
    .btn-modal-cancel {
        padding: 0.6rem 1.3rem;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #4b5563;
        transition: all 0.2s ease;
    }
    .btn-modal-cancel:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }
    .btn-modal-confirm {
        padding: 0.6rem 1.3rem;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        background: linear-gradient(135deg, #dc2626, #ef4444);
        color: #fff;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }
    .btn-modal-confirm:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(220, 38, 38, 0.4);
    }

    /* ── Animations ── */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(18px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.92);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* ── Responsive ── */
    @media (max-width: 992px) {
        .roles-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 640px) {
        .roles-page {
            padding: 1.5rem 1rem 3rem;
        }
        .roles-grid {
            grid-template-columns: 1fr;
        }
        .roles-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .roles-header-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="roles-page">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flash-toast success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="flash-toast error">
            <i class="bi bi-x-circle-fill"></i>
            {{ session('error') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="flash-toast warning">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ session('warning') }}
        </div>
    @endif

    {{-- Page Header --}}
    <div class="roles-header">
        <div class="roles-header-left">
            <h1 class="roles-header-title">Roles & Permissions</h1>
            <span class="roles-header-subtitle">Manage access control and role assignments</span>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="btn-add-role">
            <i class="bi bi-plus-lg"></i>
            Add Role
        </a>
    </div>

    {{-- Roles Grid --}}
    @if($roles->count())
        <div class="roles-grid">
            @foreach($roles as $role)
                @php
                    $roleSlug = strtolower($role->name);
                    $coreRoles = ['admin', 'manager', 'employee'];
                    $isCoreRole = in_array($roleSlug, $coreRoles);

                    if ($roleSlug === 'admin') {
                        $colorClass = 'admin';
                        $icon = 'bi-shield-lock-fill';
                    } elseif ($roleSlug === 'manager') {
                        $colorClass = 'manager';
                        $icon = 'bi-briefcase-fill';
                    } elseif ($roleSlug === 'employee') {
                        $colorClass = 'employee';
                        $icon = 'bi-person-badge-fill';
                    } else {
                        $colorClass = 'default';
                        $icon = 'bi-shield-fill';
                    }
                @endphp

                <div class="role-card">
                    <div class="role-card-topbar {{ $colorClass }}"></div>
                    <div class="role-card-body">
                        <div class="role-icon-name">
                            <div class="role-icon-wrap {{ $colorClass }}">
                                <i class="bi {{ $icon }}"></i>
                            </div>
                            <span class="role-name">{{ $role->name }}</span>
                        </div>
                        <div class="role-metrics">
                            <span class="metric-pill indigo">
                                <i class="bi bi-key-fill"></i>
                                {{ $role->permissions_count }} {{ Str::plural('Permission', $role->permissions_count) }}
                            </span>
                            <span class="metric-pill emerald">
                                <i class="bi bi-people-fill"></i>
                                {{ $role->users_count }} {{ Str::plural('User', $role->users_count) }}
                            </span>
                        </div>
                        <div class="role-created">
                            <i class="bi bi-calendar3"></i>
                            Created {{ $role->created_at->format('M d, Y') }}
                        </div>
                    </div>
                    <div class="role-card-footer">
                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn-role-action btn-edit">
                            <i class="bi bi-pencil-square"></i>
                            Edit
                        </a>
                        @unless($isCoreRole)
                            <button type="button" class="btn-role-action btn-delete"
                                    onclick="openDeleteModal('{{ $role->name }}', '{{ route('admin.roles.destroy', $role) }}')">
                                <i class="bi bi-trash3-fill"></i>
                                Delete
                            </button>
                        @endunless
                    </div>
                </div>
            @endforeach
        </div>
    @else
        {{-- Empty State --}}
        <div class="roles-empty">
            <div class="empty-icon-wrap">
                <i class="bi bi-shield-plus"></i>
            </div>
            <div class="empty-title">No roles found</div>
            <p class="empty-desc">
                Get started by creating your first role to manage user access and permissions across the system.
            </p>
            <a href="{{ route('admin.roles.create') }}" class="btn-add-role">
                <i class="bi bi-plus-lg"></i>
                Create First Role
            </a>
        </div>
    @endif
</div>

{{-- Delete Confirmation Modal --}}
<div class="delete-modal-overlay" id="deleteModal">
    <div class="delete-modal">
        <div class="delete-modal-icon">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <h3>Delete Role</h3>
        <p>Are you sure you want to delete <strong id="deleteRoleName"></strong>? This action cannot be undone and will remove all associated permissions.</p>
        <div class="delete-modal-actions">
            <button class="btn-modal-cancel" onclick="closeDeleteModal()">Cancel</button>
            <form id="deleteForm" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-modal-confirm">
                    <i class="bi bi-trash3-fill"></i>
                    Delete Role
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(name, action) {
        document.getElementById('deleteRoleName').textContent = name;
        document.getElementById('deleteForm').action = action;
        document.getElementById('deleteModal').classList.add('active');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }

    // Close modal on overlay click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });

    // Auto-dismiss flash messages
    document.querySelectorAll('.flash-toast').forEach(function(toast) {
        setTimeout(function() {
            toast.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            setTimeout(function() { toast.remove(); }, 400);
        }, 4500);
    });
</script>
@endsection
