@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .ued-page {
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
    .ued-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .ued-header-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -.025em;
        margin: 0;
    }
    .ued-header-title i {
        color: #6366f1;
        margin-right: .5rem;
        font-size: 1.5rem;
    }
    .ued-header-sub {
        font-size: .875rem;
        color: #94a3b8;
        margin: .25rem 0 0;
        font-weight: 500;
    }
    .btn-back-ued {
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
    .btn-back-ued:hover {
        background: #f8fafc;
        color: #475569;
        border-color: #cbd5e1;
        transform: translateY(-1px);
        text-decoration: none;
    }

    /* ── Flash messages ── */
    .ued-flash {
        padding: .85rem 1.25rem;
        border-radius: .625rem;
        font-size: .875rem;
        font-weight: 500;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .ued-flash-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .ued-flash-success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    /* ── User info banner ── */
    .ued-user-banner {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
        border-bottom: 1px solid #c7d2fe;
    }
    .ued-user-avatar {
        width: 48px;
        height: 48px;
        border-radius: .75rem;
        background: linear-gradient(135deg, #6366f1, #818cf8);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: .95rem;
        color: #fff;
        flex-shrink: 0;
        letter-spacing: .02em;
    }
    .ued-user-name {
        font-size: .95rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.3;
    }
    .ued-user-email {
        font-size: .78rem;
        color: #6366f1;
        line-height: 1.3;
        font-weight: 500;
    }

    /* ── Card ── */
    .ued-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 14px rgba(0,0,0,.04);
        overflow: hidden;
    }
    .ued-card-header {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: 1.125rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        background: #fafbfc;
    }
    .ued-card-header h5 {
        margin: 0;
        font-size: .9rem;
        font-weight: 700;
        color: #334155;
    }
    .ued-card-header i {
        color: #6366f1;
        font-size: 1rem;
    }
    .ued-card-body {
        padding: 1.5rem;
    }

    /* ── Form controls ── */
    .ued-label {
        font-size: .8rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: .4rem;
        display: block;
    }
    .ued-label .req {
        color: #ef4444;
        margin-left: .15rem;
    }
    .ued-input,
    .ued-select {
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
    .ued-input::placeholder {
        color: #94a3b8;
    }
    .ued-input:focus,
    .ued-select:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
    }
    .ued-input.is-invalid,
    .ued-select.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,.1);
    }
    .ued-select {
        cursor: pointer;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .75rem center;
        padding-right: 2.25rem;
    }
    .ued-invalid-feedback {
        font-size: .75rem;
        color: #ef4444;
        margin-top: .3rem;
        font-weight: 500;
    }
    .ued-input-icon-wrap {
        position: relative;
    }
    .ued-input-icon-wrap i {
        position: absolute;
        left: .85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: .85rem;
        pointer-events: none;
    }
    .ued-input-icon-wrap .ued-input {
        padding-left: 2.5rem;
    }
    .ued-field {
        margin-bottom: 1.25rem;
    }
    .ued-field:last-child {
        margin-bottom: 0;
    }

    /* ── Role selector card ── */
    .ued-role-option {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: .625rem;
        cursor: pointer;
        transition: all .2s;
        margin-bottom: .5rem;
    }
    .ued-role-option:last-child {
        margin-bottom: 0;
    }
    .ued-role-option:hover {
        border-color: #c7d2fe;
        background: #fafaff;
    }
    .ued-role-option.selected {
        border-color: #818cf8;
        background: #eef2ff;
        box-shadow: 0 0 0 3px rgba(99,102,241,.1);
    }
    .ued-role-option input[type="radio"] {
        display: none;
    }
    .ued-role-radio {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all .2s;
    }
    .ued-role-option.selected .ued-role-radio {
        border-color: #6366f1;
    }
    .ued-role-radio-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #6366f1;
        transform: scale(0);
        transition: transform .2s;
    }
    .ued-role-option.selected .ued-role-radio-dot {
        transform: scale(1);
    }
    .ued-role-name {
        font-size: .8125rem;
        font-weight: 600;
        color: #334155;
        text-transform: capitalize;
    }

    /* ── Actions ── */
    .ued-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: .75rem;
        padding: 1.25rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        background: #fafbfc;
    }
    .btn-ued-cancel {
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
    .btn-ued-cancel:hover {
        background: #f8fafc;
        color: #475569;
        text-decoration: none;
    }
    .btn-ued-submit {
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
    .btn-ued-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99,102,241,.4);
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .ued-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .ued-actions {
            flex-direction: column;
        }
        .btn-ued-cancel,
        .btn-ued-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="ued-page">
    <div class="container" style="max-width: 680px;">

        {{-- ── Flash Messages ── --}}
        @if (session('success'))
            <div class="ued-flash ued-flash-success fade-up">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- ── Validation Errors ── --}}
        @if ($errors->any())
            <div class="ued-flash ued-flash-error fade-up">
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
        <div class="ued-header fade-up">
            <div>
                <h1 class="ued-header-title">
                    <i class="bi bi-pencil-square"></i>Edit User
                </h1>
                <p class="ued-header-sub">Update account information and role assignment</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn-back-ued">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
        </div>

        @php
            $initials = strtoupper(collect(explode(' ', $user->name))->map(fn($w) => substr($w, 0, 1))->take(2)->join(''));
            $currentRole = $user->roles->first()->name ?? '';
        @endphp

        {{-- ── Form ── --}}
        <form action="{{ route('admin.users.update', $user) }}" method="POST" autocomplete="off">
            @csrf
            @method('PUT')

            <div class="ued-card fade-up fade-up-d1">
                {{-- User banner --}}
                <div class="ued-user-banner">
                    <div class="ued-user-avatar">{{ $initials }}</div>
                    <div>
                        <div class="ued-user-name">{{ $user->name }}</div>
                        <div class="ued-user-email">{{ $user->email }}</div>
                    </div>
                </div>

                <div class="ued-card-header">
                    <i class="bi bi-person-vcard"></i>
                    <h5>Account Information</h5>
                </div>
                <div class="ued-card-body">

                    {{-- Name --}}
                    <div class="ued-field">
                        <label class="ued-label" for="name">
                            Full Name <span class="req">*</span>
                        </label>
                        <div class="ued-input-icon-wrap">
                            <i class="bi bi-person"></i>
                            <input type="text" name="name" id="name"
                                   class="ued-input @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}"
                                   placeholder="e.g. John Doe" required>
                        </div>
                        @error('name')
                            <div class="ued-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="ued-field">
                        <label class="ued-label" for="email">
                            Email Address <span class="req">*</span>
                        </label>
                        <div class="ued-input-icon-wrap">
                            <i class="bi bi-envelope"></i>
                            <input type="email" name="email" id="email"
                                   class="ued-input @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}"
                                   placeholder="e.g. john@company.com" required>
                        </div>
                        @error('email')
                            <div class="ued-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ── Role Selection ── --}}
            <div class="ued-card fade-up fade-up-d2" style="margin-top: 1.25rem;">
                <div class="ued-card-header">
                    <i class="bi bi-shield-lock"></i>
                    <h5>Role Assignment</h5>
                </div>
                <div class="ued-card-body">
                    <label class="ued-label" style="margin-bottom: .75rem;">
                        Select Role <span class="req">*</span>
                    </label>
                    @error('role')
                        <div class="ued-invalid-feedback" style="margin-bottom: .75rem;">{{ $message }}</div>
                    @enderror

                    @foreach ($roles as $role)
                        @php
                            $isSelected = old('role', $currentRole) == $role->name;
                        @endphp
                        <label class="ued-role-option {{ $isSelected ? 'selected' : '' }}"
                               onclick="selectRoleEdit(this, '{{ $role->name }}')">
                            <input type="radio" name="role" value="{{ $role->name }}"
                                   {{ $isSelected ? 'checked' : '' }}>
                            <div class="ued-role-radio">
                                <div class="ued-role-radio-dot"></div>
                            </div>
                            <div class="ued-role-name">
                                <i class="bi bi-shield-check" style="margin-right: .35rem; color: #6366f1; font-size: .75rem;"></i>
                                {{ ucfirst($role->name) }}
                            </div>
                        </label>
                    @endforeach
                </div>

                {{-- ── Form Actions ── --}}
                <div class="ued-actions">
                    <a href="{{ route('admin.users.index') }}" class="btn-ued-cancel">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                    <button type="submit" class="btn-ued-submit">
                        <i class="bi bi-check-lg"></i> Update User
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
function selectRoleEdit(el, roleName) {
    document.querySelectorAll('.ued-role-option').forEach(function(opt) {
        opt.classList.remove('selected');
        opt.querySelector('input[type="radio"]').checked = false;
    });
    el.classList.add('selected');
    el.querySelector('input[type="radio"]').checked = true;
}
</script>
@endsection
