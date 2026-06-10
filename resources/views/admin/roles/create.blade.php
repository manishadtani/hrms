@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .rcr-page {
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
    .rcr-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .rcr-header-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -.025em;
        margin: 0;
    }
    .rcr-header-title i {
        color: #6366f1;
        margin-right: .5rem;
        font-size: 1.5rem;
    }
    .rcr-header-sub {
        font-size: .875rem;
        color: #94a3b8;
        margin: .25rem 0 0;
        font-weight: 500;
    }
    .btn-back-rcr {
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
    .btn-back-rcr:hover {
        background: #f8fafc;
        color: #475569;
        border-color: #cbd5e1;
        transform: translateY(-1px);
        text-decoration: none;
    }

    /* ── Flash messages ── */
    .rcr-flash {
        padding: .85rem 1.25rem;
        border-radius: .625rem;
        font-size: .875rem;
        font-weight: 500;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .rcr-flash-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* ── Card ── */
    .rcr-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 14px rgba(0,0,0,.04);
        overflow: hidden;
    }
    .rcr-card-header {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: 1.125rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        background: #fafbfc;
    }
    .rcr-card-header h5 {
        margin: 0;
        font-size: .9rem;
        font-weight: 700;
        color: #334155;
    }
    .rcr-card-header i {
        color: #6366f1;
        font-size: 1rem;
    }
    .rcr-card-body {
        padding: 1.5rem;
    }

    /* ── Form controls ── */
    .rcr-label {
        font-size: .8rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: .4rem;
        display: block;
    }
    .rcr-label .req {
        color: #ef4444;
        margin-left: .15rem;
    }
    .rcr-input {
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
    .rcr-input::placeholder {
        color: #94a3b8;
    }
    .rcr-input:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
    }
    .rcr-input.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,.1);
    }
    .rcr-invalid-feedback {
        font-size: .75rem;
        color: #ef4444;
        margin-top: .3rem;
        font-weight: 500;
    }
    .rcr-input-icon-wrap {
        position: relative;
    }
    .rcr-input-icon-wrap i {
        position: absolute;
        left: .85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: .85rem;
        pointer-events: none;
    }
    .rcr-input-icon-wrap .rcr-input {
        padding-left: 2.5rem;
    }

    /* ── Permission groups ── */
    .rcr-perm-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .75rem;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .rcr-perm-count {
        font-size: .78rem;
        color: #94a3b8;
        font-weight: 500;
    }
    .rcr-perm-count strong {
        color: #6366f1;
        font-weight: 700;
    }
    .rcr-perm-actions {
        display: flex;
        gap: .5rem;
    }
    .rcr-perm-btn {
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
    .rcr-perm-btn-select {
        color: #6366f1;
        background: #eef2ff;
        border-color: #c7d2fe;
    }
    .rcr-perm-btn-select:hover {
        background: #e0e7ff;
    }
    .rcr-perm-btn-clear {
        color: #64748b;
        background: #fff;
        border-color: #e2e8f0;
    }
    .rcr-perm-btn-clear:hover {
        background: #f8fafc;
    }

    /* ── Collapsible permission group ── */
    .rcr-perm-group {
        border: 1px solid #e2e8f0;
        border-radius: .75rem;
        margin-bottom: .75rem;
        overflow: hidden;
        transition: all .2s;
    }
    .rcr-perm-group:last-child {
        margin-bottom: 0;
    }
    .rcr-perm-group:hover {
        border-color: #c7d2fe;
    }
    .rcr-perm-group-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .75rem 1rem;
        background: #fafbfc;
        cursor: pointer;
        transition: background .2s;
        user-select: none;
    }
    .rcr-perm-group-header:hover {
        background: #f1f5f9;
    }
    .rcr-perm-group-left {
        display: flex;
        align-items: center;
        gap: .65rem;
    }
    .rcr-perm-group-icon {
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
    .rcr-perm-group-name {
        font-size: .8125rem;
        font-weight: 700;
        color: #334155;
        text-transform: capitalize;
    }
    .rcr-perm-group-badge {
        font-size: .65rem;
        font-weight: 600;
        color: #94a3b8;
        background: #f1f5f9;
        padding: .15rem .5rem;
        border-radius: 9999px;
        margin-left: .5rem;
    }
    .rcr-perm-group-right {
        display: flex;
        align-items: center;
        gap: .75rem;
    }
    .rcr-select-all-wrap {
        display: flex;
        align-items: center;
        gap: .35rem;
    }
    .rcr-select-all-wrap label {
        font-size: .7rem;
        font-weight: 600;
        color: #6366f1;
        cursor: pointer;
        margin: 0;
    }
    .rcr-select-all-wrap input[type="checkbox"] {
        width: 15px;
        height: 15px;
        border-radius: .25rem;
        accent-color: #6366f1;
        cursor: pointer;
    }
    .rcr-perm-chevron {
        color: #94a3b8;
        font-size: .75rem;
        transition: transform .3s cubic-bezier(.22,1,.36,1);
    }
    .rcr-perm-group.collapsed .rcr-perm-chevron {
        transform: rotate(-90deg);
    }
    .rcr-perm-group-body {
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
    .rcr-perm-group.collapsed .rcr-perm-group-body {
        max-height: 0;
        padding-top: 0;
        padding-bottom: 0;
        opacity: 0;
        border-top-color: transparent;
    }

    /* ── Permission checkbox item ── */
    .rcr-perm-item {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .45rem .65rem;
        border-radius: .4rem;
        transition: background .15s;
        cursor: pointer;
    }
    .rcr-perm-item:hover {
        background: #f8fafc;
    }
    .rcr-perm-item input[type="checkbox"] {
        width: 15px;
        height: 15px;
        border-radius: .25rem;
        accent-color: #6366f1;
        cursor: pointer;
        flex-shrink: 0;
    }
    .rcr-perm-item label {
        font-size: .78rem;
        font-weight: 500;
        color: #475569;
        cursor: pointer;
        margin: 0;
        line-height: 1.3;
    }

    /* ── Empty state ── */
    .rcr-empty {
        text-align: center;
        padding: 2.5rem 1rem;
    }
    .rcr-empty-icon {
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
    .rcr-empty h6 {
        font-size: .875rem;
        font-weight: 700;
        color: #334155;
        margin: 0 0 .25rem;
    }
    .rcr-empty p {
        font-size: .8rem;
        color: #94a3b8;
        margin: 0;
    }

    /* ── Actions ── */
    .rcr-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: .75rem;
        padding: 1.25rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        background: #fafbfc;
    }
    .btn-rcr-cancel {
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
    .btn-rcr-cancel:hover {
        background: #f8fafc;
        color: #475569;
        text-decoration: none;
    }
    .btn-rcr-submit {
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
    .btn-rcr-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99,102,241,.4);
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .rcr-header { flex-direction: column; align-items: flex-start; }
        .rcr-perm-group-body { grid-template-columns: 1fr; }
        .rcr-actions { flex-direction: column; }
        .btn-rcr-cancel, .btn-rcr-submit { width: 100%; justify-content: center; }
    }
</style>

<div class="rcr-page">
    <div class="container" style="max-width: 900px;">

        {{-- ── Validation Errors ── --}}
        @if ($errors->any())
            <div class="rcr-flash rcr-flash-error fade-up">
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
        <div class="rcr-header fade-up">
            <div>
                <h1 class="rcr-header-title">
                    <i class="bi bi-shield-plus"></i>Create Role
                </h1>
                <p class="rcr-header-sub">Define a new role and assign granular permissions</p>
            </div>
            <a href="{{ route('admin.roles.index') }}" class="btn-back-rcr">
                <i class="bi bi-arrow-left"></i> Back to Roles
            </a>
        </div>

        {{-- ── Form ── --}}
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            {{-- Role Name Card --}}
            <div class="rcr-card fade-up fade-up-d1" style="margin-bottom: 1.25rem;">
                <div class="rcr-card-header">
                    <i class="bi bi-tag"></i>
                    <h5>Role Details</h5>
                </div>
                <div class="rcr-card-body">
                    <div>
                        <label class="rcr-label" for="name">
                            Role Name <span class="req">*</span>
                        </label>
                        <div class="rcr-input-icon-wrap">
                            <i class="bi bi-shield"></i>
                            <input type="text" name="name" id="name"
                                   class="rcr-input @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="e.g. supervisor, manager, hr" required>
                        </div>
                        @error('name')
                            <div class="rcr-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Permissions Card --}}
            <div class="rcr-card fade-up fade-up-d2">
                <div class="rcr-card-header">
                    <i class="bi bi-key"></i>
                    <h5>Assign Permissions</h5>
                </div>
                <div class="rcr-card-body">
                    @if (count($groupedPermissions) > 0)
                        {{-- Toolbar --}}
                        <div class="rcr-perm-toolbar">
                            <div class="rcr-perm-count">
                                <strong id="rcrCheckedCount">0</strong> of <strong id="rcrTotalCount">0</strong> permissions selected
                            </div>
                            <div class="rcr-perm-actions">
                                <button type="button" class="rcr-perm-btn rcr-perm-btn-select" onclick="rcrSelectAll()">
                                    <i class="bi bi-check-all"></i> Select All
                                </button>
                                <button type="button" class="rcr-perm-btn rcr-perm-btn-clear" onclick="rcrClearAll()">
                                    <i class="bi bi-x-lg"></i> Clear All
                                </button>
                            </div>
                        </div>

                        {{-- Permission Groups --}}
                        @foreach ($groupedPermissions as $group => $permissions)
                            <div class="rcr-perm-group" data-group="{{ Str::slug($group) }}">
                                <div class="rcr-perm-group-header" onclick="togglePermGroup(this)">
                                    <div class="rcr-perm-group-left">
                                        <div class="rcr-perm-group-icon">
                                            <i class="bi bi-folder2"></i>
                                        </div>
                                        <span class="rcr-perm-group-name">{{ ucwords(str_replace('-', ' ', $group)) }}</span>
                                        <span class="rcr-perm-group-badge">{{ count($permissions) }}</span>
                                    </div>
                                    <div class="rcr-perm-group-right">
                                        <div class="rcr-select-all-wrap" onclick="event.stopPropagation();">
                                            <input type="checkbox" class="rcr-group-select-all"
                                                   id="selectAll_{{ Str::slug($group) }}"
                                                   data-group="{{ Str::slug($group) }}"
                                                   onchange="toggleGroupAll(this)">
                                            <label for="selectAll_{{ Str::slug($group) }}">All</label>
                                        </div>
                                        <i class="bi bi-chevron-down rcr-perm-chevron"></i>
                                    </div>
                                </div>
                                <div class="rcr-perm-group-body">
                                    @foreach ($permissions as $perm)
                                        <div class="rcr-perm-item">
                                            <input type="checkbox"
                                                   class="rcr-perm-cb rcr-perm-group-{{ Str::slug($group) }}"
                                                   name="permissions[]"
                                                   value="{{ $perm->id }}"
                                                   id="perm_{{ $perm->id }}"
                                                   {{ in_array($perm->id, old('permissions', [])) ? 'checked' : '' }}
                                                   onchange="updatePermCounts()">
                                            <label for="perm_{{ $perm->id }}">
                                                {{ ucwords(str_replace('-', ' ', $perm->name)) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="rcr-empty">
                            <div class="rcr-empty-icon">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <h6>No Permissions Available</h6>
                            <p>Please create permissions before setting up roles.</p>
                        </div>
                    @endif
                </div>

                {{-- ── Form Actions ── --}}
                <div class="rcr-actions">
                    <a href="{{ route('admin.roles.index') }}" class="btn-rcr-cancel">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                    <button type="submit" class="btn-rcr-submit">
                        <i class="bi bi-check-lg"></i> Create Role
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
// Toggle collapsible permission group
function togglePermGroup(headerEl) {
    var group = headerEl.closest('.rcr-perm-group');
    group.classList.toggle('collapsed');
}

// Select all in a group
function toggleGroupAll(checkbox) {
    var group = checkbox.dataset.group;
    var checked = checkbox.checked;
    document.querySelectorAll('.rcr-perm-group-' + group).forEach(function(cb) {
        cb.checked = checked;
    });
    updatePermCounts();
}

// Select all permissions globally
function rcrSelectAll() {
    document.querySelectorAll('.rcr-perm-cb').forEach(function(cb) { cb.checked = true; });
    document.querySelectorAll('.rcr-group-select-all').forEach(function(cb) { cb.checked = true; });
    updatePermCounts();
}

// Clear all permissions globally
function rcrClearAll() {
    document.querySelectorAll('.rcr-perm-cb').forEach(function(cb) { cb.checked = false; });
    document.querySelectorAll('.rcr-group-select-all').forEach(function(cb) { cb.checked = false; });
    updatePermCounts();
}

// Update count display + group select-all state
function updatePermCounts() {
    var total = document.querySelectorAll('.rcr-perm-cb').length;
    var checked = document.querySelectorAll('.rcr-perm-cb:checked').length;
    var totalEl = document.getElementById('rcrTotalCount');
    var checkedEl = document.getElementById('rcrCheckedCount');
    if (totalEl) totalEl.textContent = total;
    if (checkedEl) checkedEl.textContent = checked;

    // Update group select-all checkboxes
    document.querySelectorAll('.rcr-group-select-all').forEach(function(selectAllCb) {
        var group = selectAllCb.dataset.group;
        var groupTotal = document.querySelectorAll('.rcr-perm-group-' + group).length;
        var groupChecked = document.querySelectorAll('.rcr-perm-group-' + group + ':checked').length;
        selectAllCb.checked = groupTotal > 0 && groupTotal === groupChecked;
    });
}

// Initialize counts on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePermCounts();
});
</script>
@endsection
