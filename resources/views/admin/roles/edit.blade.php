@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .red-page {
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
    .red-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .red-header-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -.025em;
        margin: 0;
    }
    .red-header-title i {
        color: #6366f1;
        margin-right: .5rem;
        font-size: 1.5rem;
    }
    .red-header-sub {
        font-size: .875rem;
        color: #94a3b8;
        margin: .25rem 0 0;
        font-weight: 500;
    }
    .btn-back-red {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .6rem 1.25rem;
        font-size: .8125rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        color: #64748b;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .625rem;
        text-decoration: none;
        transition: all .25s ease;
        cursor: pointer;
    }
    .btn-back-red:hover {
        background: #f8fafc;
        color: #475569;
        border-color: #cbd5e1;
        transform: translateY(-1px);
        text-decoration: none;
    }

    /* ── Flash messages ── */
    .red-flash {
        padding: .85rem 1.25rem;
        border-radius: .625rem;
        font-size: .875rem;
        font-weight: 500;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .red-flash-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .red-flash-success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    /* ── Role info banner ── */
    .red-role-banner {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
        border-bottom: 1px solid #c7d2fe;
    }
    .red-role-icon {
        width: 48px;
        height: 48px;
        border-radius: .75rem;
        background: linear-gradient(135deg, #6366f1, #818cf8);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: #fff;
        flex-shrink: 0;
    }
    .red-role-name-banner {
        font-size: .95rem;
        font-weight: 700;
        color: #1e293b;
        text-transform: capitalize;
    }
    .red-role-meta {
        font-size: .78rem;
        color: #6366f1;
        font-weight: 500;
    }

    /* ── Card ── */
    .red-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 14px rgba(0,0,0,.04);
        overflow: hidden;
    }
    .red-card-header {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: 1.125rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        background: #fafbfc;
    }
    .red-card-header h5 {
        margin: 0;
        font-size: .9rem;
        font-weight: 700;
        color: #334155;
    }
    .red-card-header i {
        color: #6366f1;
        font-size: 1rem;
    }
    .red-card-body {
        padding: 1.5rem;
    }

    /* ── Form controls ── */
    .red-label {
        font-size: .8rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: .4rem;
        display: block;
    }
    .red-label .req {
        color: #ef4444;
        margin-left: .15rem;
    }
    .red-input {
        width: 100%;
        padding: .65rem 1rem;
        font-size: .8125rem;
        font-family: 'Inter', sans-serif;
        border: 1px solid #e2e8f0;
        border-radius: .5rem;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        color: #334155;
        background: #fff;
        box-sizing: border-box;
    }
    .red-input::placeholder {
        color: #94a3b8;
    }
    .red-input:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
    }
    .red-input.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,.1);
    }
    .red-invalid-feedback {
        font-size: .75rem;
        color: #ef4444;
        margin-top: .3rem;
        font-weight: 500;
    }
    .red-input-icon-wrap {
        position: relative;
    }
    .red-input-icon-wrap i {
        position: absolute;
        left: .85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: .85rem;
        pointer-events: none;
    }
    .red-input-icon-wrap .red-input {
        padding-left: 2.5rem;
    }

    /* ── Permission groups ── */
    .red-perm-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .75rem;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .red-perm-count {
        font-size: .78rem;
        color: #94a3b8;
        font-weight: 500;
    }
    .red-perm-count strong {
        color: #6366f1;
        font-weight: 700;
    }
    .red-perm-actions {
        display: flex;
        gap: .5rem;
    }
    .red-perm-btn {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .35rem .85rem;
        font-size: .7rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        border-radius: .4rem;
        cursor: pointer;
        transition: all .2s;
        border: 1px solid transparent;
    }
    .red-perm-btn-select {
        color: #6366f1;
        background: #eef2ff;
        border-color: #c7d2fe;
    }
    .red-perm-btn-select:hover {
        background: #e0e7ff;
    }
    .red-perm-btn-clear {
        color: #64748b;
        background: #fff;
        border-color: #e2e8f0;
    }
    .red-perm-btn-clear:hover {
        background: #f8fafc;
    }

    /* ── Collapsible permission group ── */
    .red-perm-group {
        border: 1px solid #e2e8f0;
        border-radius: .75rem;
        margin-bottom: .75rem;
        overflow: hidden;
        transition: all .2s;
    }
    .red-perm-group:last-child {
        margin-bottom: 0;
    }
    .red-perm-group:hover {
        border-color: #c7d2fe;
    }
    .red-perm-group-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .75rem 1rem;
        background: #fafbfc;
        cursor: pointer;
        transition: background .2s;
        user-select: none;
    }
    .red-perm-group-header:hover {
        background: #f1f5f9;
    }
    .red-perm-group-left {
        display: flex;
        align-items: center;
        gap: .65rem;
    }
    .red-perm-group-icon {
        width: 32px;
        height: 32px;
        border-radius: .5rem;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6366f1;
        font-size: .85rem;
        flex-shrink: 0;
    }
    .red-perm-group-name {
        font-size: .8125rem;
        font-weight: 700;
        color: #334155;
        text-transform: capitalize;
    }
    .red-perm-group-badge {
        font-size: .65rem;
        font-weight: 600;
        color: #94a3b8;
        background: #f1f5f9;
        padding: .15rem .5rem;
        border-radius: 9999px;
        margin-left: .5rem;
    }
    .red-perm-group-right {
        display: flex;
        align-items: center;
        gap: .75rem;
    }
    .red-select-all-wrap {
        display: flex;
        align-items: center;
        gap: .35rem;
    }
    .red-select-all-wrap label {
        font-size: .7rem;
        font-weight: 600;
        color: #6366f1;
        cursor: pointer;
        margin: 0;
    }
    .red-select-all-wrap input[type="checkbox"] {
        width: 15px;
        height: 15px;
        border-radius: .25rem;
        accent-color: #6366f1;
        cursor: pointer;
    }
    .red-perm-chevron {
        color: #94a3b8;
        font-size: .75rem;
        transition: transform .3s cubic-bezier(.22,1,.36,1);
    }
    .red-perm-group.collapsed .red-perm-chevron {
        transform: rotate(-90deg);
    }
    .red-perm-group-body {
        padding: .75rem 1rem 1rem;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: .5rem;
        border-top: 1px solid #f1f5f9;
        max-height: 500px;
        overflow: hidden;
        transition: max-height .35s cubic-bezier(.22,1,.36,1), padding .35s, opacity .25s;
        opacity: 1;
    }
    .red-perm-group.collapsed .red-perm-group-body {
        max-height: 0;
        padding-top: 0;
        padding-bottom: 0;
        opacity: 0;
        border-top-color: transparent;
    }

    /* ── Permission checkbox item ── */
    .red-perm-item {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .45rem .65rem;
        border-radius: .4rem;
        transition: background .15s;
        cursor: pointer;
    }
    .red-perm-item:hover {
        background: #f8fafc;
    }
    .red-perm-item input[type="checkbox"] {
        width: 15px;
        height: 15px;
        border-radius: .25rem;
        accent-color: #6366f1;
        cursor: pointer;
        flex-shrink: 0;
    }
    .red-perm-item label {
        font-size: .78rem;
        font-weight: 500;
        color: #475569;
        cursor: pointer;
        margin: 0;
        line-height: 1.3;
    }

    /* ── Empty state ── */
    .red-empty {
        text-align: center;
        padding: 2.5rem 1rem;
    }
    .red-empty-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #6366f1;
        margin-bottom: .75rem;
    }
    .red-empty h6 {
        font-size: .875rem;
        font-weight: 700;
        color: #334155;
        margin: 0 0 .25rem;
    }
    .red-empty p {
        font-size: .8rem;
        color: #94a3b8;
        margin: 0;
    }

    /* ── Actions ── */
    .red-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: .75rem;
        padding: 1.25rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        background: #fafbfc;
    }
    .btn-red-cancel {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .6rem 1.25rem;
        font-size: .8125rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        color: #64748b;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .5rem;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
    }
    .btn-red-cancel:hover {
        background: #f8fafc;
        color: #475569;
        text-decoration: none;
    }
    .btn-red-submit {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .6rem 1.5rem;
        font-size: .8125rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        color: #fff;
        background: linear-gradient(135deg, #6366f1, #818cf8);
        border: none;
        border-radius: .5rem;
        cursor: pointer;
        transition: all .25s;
        box-shadow: 0 2px 8px rgba(99,102,241,.3);
    }
    .btn-red-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99,102,241,.4);
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .red-header { flex-direction: column; align-items: flex-start; }
        .red-perm-group-body { grid-template-columns: 1fr; }
        .red-actions { flex-direction: column; }
        .btn-red-cancel, .btn-red-submit { width: 100%; justify-content: center; }
    }
</style>

<div class="red-page">
    <div class="container" style="max-width: 900px;">

        {{-- ── Flash Messages ── --}}
        @if (session('success'))
            <div class="red-flash red-flash-success fade-up">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- ── Validation Errors ── --}}
        @if ($errors->any())
            <div class="red-flash red-flash-error fade-up">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin: .35rem 0 0; padding-left: 1.1rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- ── Page Header ── --}}
        <div class="red-header fade-up">
            <div>
                <h1 class="red-header-title">
                    <i class="bi bi-pencil-square"></i>Edit Role
                </h1>
                <p class="red-header-sub">Modify role details and update permission assignments</p>
            </div>
            <a href="{{ route('admin.roles.index') }}" class="btn-back-red">
                <i class="bi bi-arrow-left"></i> Back to Roles
            </a>
        </div>

        {{-- ── Form ── --}}
        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Role Name Card --}}
            <div class="red-card fade-up fade-up-d1" style="margin-bottom: 1.25rem;">
                {{-- Role banner --}}
                <div class="red-role-banner">
                    <div class="red-role-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div>
                        <div class="red-role-name-banner">{{ ucfirst($role->name) }}</div>
                        <div class="red-role-meta">
                            <i class="bi bi-key" style="font-size: .7rem;"></i>
                            {{ count($rolePermissions) }} permissions assigned
                        </div>
                    </div>
                </div>

                <div class="red-card-header">
                    <i class="bi bi-tag"></i>
                    <h5>Role Details</h5>
                </div>
                <div class="red-card-body">
                    <div>
                        <label class="red-label" for="name">
                            Role Name <span class="req">*</span>
                        </label>
                        <div class="red-input-icon-wrap">
                            <i class="bi bi-shield"></i>
                            <input type="text" name="name" id="name"
                                   class="red-input @error('name') is-invalid @enderror"
                                   value="{{ old('name', $role->name) }}"
                                   placeholder="e.g. supervisor, manager, hr" required>
                        </div>
                        @error('name')
                            <div class="red-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Permissions Card --}}
            <div class="red-card fade-up fade-up-d2">
                <div class="red-card-header">
                    <i class="bi bi-key"></i>
                    <h5>Assign Permissions</h5>
                </div>
                <div class="red-card-body">
                    @if (count($groupedPermissions) > 0)
                        {{-- Toolbar --}}
                        <div class="red-perm-toolbar">
                            <div class="red-perm-count">
                                <strong id="redCheckedCount">0</strong> of <strong id="redTotalCount">0</strong> permissions selected
                            </div>
                            <div class="red-perm-actions">
                                <button type="button" class="red-perm-btn red-perm-btn-select" onclick="redSelectAll()">
                                    <i class="bi bi-check-all"></i> Select All
                                </button>
                                <button type="button" class="red-perm-btn red-perm-btn-clear" onclick="redClearAll()">
                                    <i class="bi bi-x-lg"></i> Clear All
                                </button>
                            </div>
                        </div>

                        {{-- Permission Groups --}}
                        @foreach ($groupedPermissions as $group => $permissions)
                            <div class="red-perm-group" data-group="{{ Str::slug($group) }}">
                                <div class="red-perm-group-header" onclick="toggleRedPermGroup(this)">
                                    <div class="red-perm-group-left">
                                        <div class="red-perm-group-icon">
                                            <i class="bi bi-folder2"></i>
                                        </div>
                                        <span class="red-perm-group-name">{{ ucwords(str_replace('-', ' ', $group)) }}</span>
                                        <span class="red-perm-group-badge">{{ count($permissions) }}</span>
                                    </div>
                                    <div class="red-perm-group-right">
                                        <div class="red-select-all-wrap" onclick="event.stopPropagation();">
                                            <input type="checkbox" class="red-group-select-all"
                                                   id="redSelectAll_{{ Str::slug($group) }}"
                                                   data-group="{{ Str::slug($group) }}"
                                                   onchange="toggleRedGroupAll(this)">
                                            <label for="redSelectAll_{{ Str::slug($group) }}">All</label>
                                        </div>
                                        <i class="bi bi-chevron-down red-perm-chevron"></i>
                                    </div>
                                </div>
                                <div class="red-perm-group-body">
                                    @foreach ($permissions as $perm)
                                        <div class="red-perm-item">
                                            <input type="checkbox"
                                                   class="red-perm-cb red-perm-group-{{ Str::slug($group) }}"
                                                   name="permissions[]"
                                                   value="{{ $perm->id }}"
                                                   id="redperm_{{ $perm->id }}"
                                                   {{ in_array($perm->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}
                                                   onchange="updateRedPermCounts()">
                                            <label for="redperm_{{ $perm->id }}">
                                                {{ ucwords(str_replace('-', ' ', $perm->name)) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="red-empty">
                            <div class="red-empty-icon">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <h6>No Permissions Available</h6>
                            <p>Please create permissions before setting up roles.</p>
                        </div>
                    @endif
                </div>

                {{-- ── Form Actions ── --}}
                <div class="red-actions">
                    <a href="{{ route('admin.roles.index') }}" class="btn-red-cancel">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                    <button type="submit" class="btn-red-submit">
                        <i class="bi bi-check-lg"></i> Update Role
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
// Toggle collapsible permission group
function toggleRedPermGroup(headerEl) {
    var group = headerEl.closest('.red-perm-group');
    group.classList.toggle('collapsed');
}

// Select all in a group
function toggleRedGroupAll(checkbox) {
    var group = checkbox.dataset.group;
    var checked = checkbox.checked;
    document.querySelectorAll('.red-perm-group-' + group).forEach(function(cb) {
        cb.checked = checked;
    });
    updateRedPermCounts();
}

// Select all permissions globally
function redSelectAll() {
    document.querySelectorAll('.red-perm-cb').forEach(function(cb) { cb.checked = true; });
    document.querySelectorAll('.red-group-select-all').forEach(function(cb) { cb.checked = true; });
    updateRedPermCounts();
}

// Clear all permissions globally
function redClearAll() {
    document.querySelectorAll('.red-perm-cb').forEach(function(cb) { cb.checked = false; });
    document.querySelectorAll('.red-group-select-all').forEach(function(cb) { cb.checked = false; });
    updateRedPermCounts();
}

// Update count display + group select-all state
function updateRedPermCounts() {
    var total = document.querySelectorAll('.red-perm-cb').length;
    var checked = document.querySelectorAll('.red-perm-cb:checked').length;
    var totalEl = document.getElementById('redTotalCount');
    var checkedEl = document.getElementById('redCheckedCount');
    if (totalEl) totalEl.textContent = total;
    if (checkedEl) checkedEl.textContent = checked;

    // Update group select-all checkboxes
    document.querySelectorAll('.red-group-select-all').forEach(function(selectAllCb) {
        var group = selectAllCb.dataset.group;
        var groupTotal = document.querySelectorAll('.red-perm-group-' + group).length;
        var groupChecked = document.querySelectorAll('.red-perm-group-' + group + ':checked').length;
        selectAllCb.checked = groupTotal > 0 && groupTotal === groupChecked;
    });
}

// Initialize counts on page load
document.addEventListener('DOMContentLoaded', function() {
    updateRedPermCounts();
});
</script>
@endsection
