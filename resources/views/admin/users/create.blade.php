@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .ucr-page {
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
    .ucr-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .ucr-header-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -.025em;
        margin: 0;
    }
    .ucr-header-title i {
        color: #6366f1;
        margin-right: .5rem;
        font-size: 1.5rem;
    }
    .ucr-header-sub {
        font-size: .875rem;
        color: #94a3b8;
        margin: .25rem 0 0;
        font-weight: 500;
    }
    .btn-back-ucr {
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
    .btn-back-ucr:hover {
        background: #f8fafc;
        color: #475569;
        border-color: #cbd5e1;
        transform: translateY(-1px);
        text-decoration: none;
    }

    /* ── Flash messages ── */
    .ucr-flash {
        padding: .85rem 1.25rem;
        border-radius: .625rem;
        font-size: .875rem;
        font-weight: 500;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .ucr-flash-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* ── Card ── */
    .ucr-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: .875rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 14px rgba(0,0,0,.04);
        overflow: hidden;
    }
    .ucr-card-header {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: 1.125rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        background: #fafbfc;
    }
    .ucr-card-header h5 {
        margin: 0;
        font-size: .9rem;
        font-weight: 700;
        color: #334155;
    }
    .ucr-card-header i {
        color: #6366f1;
        font-size: 1rem;
    }
    .ucr-card-body {
        padding: 1.5rem;
    }

    /* ── Form controls ── */
    .ucr-label {
        font-size: .8rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: .4rem;
        display: block;
    }
    .ucr-label .req {
        color: #ef4444;
        margin-left: .15rem;
    }
    .ucr-input,
    .ucr-select {
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
    .ucr-input::placeholder {
        color: #94a3b8;
    }
    .ucr-input:focus,
    .ucr-select:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
    }
    .ucr-input.is-invalid,
    .ucr-select.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,.1);
    }
    .ucr-select {
        cursor: pointer;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .75rem center;
        padding-right: 2.25rem;
    }
    .ucr-invalid-feedback {
        font-size: .75rem;
        color: #ef4444;
        margin-top: .3rem;
        font-weight: 500;
    }
    .ucr-input-icon-wrap {
        position: relative;
    }
    .ucr-input-icon-wrap i {
        position: absolute;
        left: .85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: .85rem;
        pointer-events: none;
    }
    .ucr-input-icon-wrap .ucr-input {
        padding-left: 2.5rem;
    }
    .ucr-field {
        margin-bottom: 1.25rem;
    }
    .ucr-field:last-child {
        margin-bottom: 0;
    }

    /* ── Password strength indicator ── */
    .ucr-pw-hint {
        display: flex;
        align-items: center;
        gap: .35rem;
        font-size: .7rem;
        color: #94a3b8;
        margin-top: .35rem;
        font-weight: 500;
    }
    .ucr-pw-hint i {
        font-size: .7rem;
    }

    /* ── Form divider ── */
    .ucr-divider {
        height: 1px;
        background: #f1f5f9;
        margin: 1.25rem 0;
    }

    /* ── Actions ── */
    .ucr-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: .75rem;
        padding: 1.25rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        background: #fafbfc;
    }
    .btn-ucr-cancel {
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
    .btn-ucr-cancel:hover {
        background: #f8fafc;
        color: #475569;
        text-decoration: none;
    }
    .btn-ucr-submit {
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
    .btn-ucr-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99,102,241,.4);
    }

    /* ── Role selector card ── */
    .ucr-role-option {
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
    .ucr-role-option:last-child {
        margin-bottom: 0;
    }
    .ucr-role-option:hover {
        border-color: #c7d2fe;
        background: #fafaff;
    }
    .ucr-role-option.selected {
        border-color: #818cf8;
        background: #eef2ff;
        box-shadow: 0 0 0 3px rgba(99,102,241,.1);
    }
    .ucr-role-option input[type="radio"] {
        display: none;
    }
    .ucr-role-radio {
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
    .ucr-role-option.selected .ucr-role-radio {
        border-color: #6366f1;
    }
    .ucr-role-radio-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #6366f1;
        transform: scale(0);
        transition: transform .2s;
    }
    .ucr-role-option.selected .ucr-role-radio-dot {
        transform: scale(1);
    }
    .ucr-role-name {
        font-size: .8125rem;
        font-weight: 600;
        color: #334155;
        text-transform: capitalize;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .ucr-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .ucr-actions {
            flex-direction: column;
        }
        .btn-ucr-cancel,
        .btn-ucr-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="ucr-page">
    <div class="container" style="max-width: 680px;">

        {{-- ── Validation Errors ── --}}
        @if ($errors->any())
            <div class="ucr-flash ucr-flash-error fade-up">
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
        <div class="ucr-header fade-up">
            <div>
                <h1 class="ucr-header-title">
                    <i class="bi bi-person-plus-fill"></i>Create User
                </h1>
                <p class="ucr-header-sub">Set up a new system user account with role assignment</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn-back-ucr">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
        </div>

        {{-- ── Form ── --}}
        <form action="{{ route('admin.users.store') }}" method="POST" autocomplete="off">
            @csrf

            <div class="ucr-card fade-up fade-up-d1">
                <div class="ucr-card-header">
                    <i class="bi bi-person-vcard"></i>
                    <h5>Account Information</h5>
                </div>
                <div class="ucr-card-body">

                    {{-- Name --}}
                    <div class="ucr-field">
                        <label class="ucr-label" for="name">
                            Full Name <span class="req">*</span>
                        </label>
                        <div class="ucr-input-icon-wrap">
                            <i class="bi bi-person"></i>
                            <input type="text" name="name" id="name"
                                   class="ucr-input @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="e.g. John Doe" required>
                        </div>
                        @error('name')
                            <div class="ucr-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="ucr-field">
                        <label class="ucr-label" for="email">
                            Email Address <span class="req">*</span>
                        </label>
                        <div class="ucr-input-icon-wrap">
                            <i class="bi bi-envelope"></i>
                            <input type="email" name="email" id="email"
                                   class="ucr-input @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="e.g. john@company.com" required>
                        </div>
                        @error('email')
                            <div class="ucr-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="ucr-divider"></div>

                    {{-- Password --}}
                    <div class="ucr-field">
                        <label class="ucr-label" for="password">
                            Password <span class="req">*</span>
                        </label>
                        <div class="ucr-input-icon-wrap">
                            <i class="bi bi-lock"></i>
                            <input type="password" name="password" id="password"
                                   class="ucr-input @error('password') is-invalid @enderror"
                                   placeholder="Minimum 8 characters" required minlength="8">
                        </div>
                        @error('password')
                            <div class="ucr-invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="ucr-pw-hint">
                            <i class="bi bi-info-circle"></i>
                            Use at least 8 characters with a mix of letters and numbers
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="ucr-field">
                        <label class="ucr-label" for="password_confirmation">
                            Confirm Password <span class="req">*</span>
                        </label>
                        <div class="ucr-input-icon-wrap">
                            <i class="bi bi-lock-fill"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="ucr-input"
                                   placeholder="Re-enter your password" required minlength="8">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Role Selection ── --}}
            <div class="ucr-card fade-up fade-up-d2" style="margin-top: 1.25rem;">
                <div class="ucr-card-header">
                    <i class="bi bi-shield-lock"></i>
                    <h5>Role Assignment</h5>
                </div>
                <div class="ucr-card-body">
                    <label class="ucr-label" style="margin-bottom: .75rem;">
                        Select Role <span class="req">*</span>
                    </label>
                    @error('role')
                        <div class="ucr-invalid-feedback" style="margin-bottom: .75rem;">{{ $message }}</div>
                    @enderror

                    @foreach ($roles as $role)
                        <label class="ucr-role-option {{ old('role') == $role->name ? 'selected' : '' }}"
                               id="role-option-{{ $role->id }}"
                               onclick="selectRole(this, '{{ $role->name }}')">
                            <input type="radio" name="role" value="{{ $role->name }}"
                                   {{ old('role') == $role->name ? 'checked' : '' }}>
                            <div class="ucr-role-radio">
                                <div class="ucr-role-radio-dot"></div>
                            </div>
                            <div class="ucr-role-name">
                                <i class="bi bi-shield-check" style="margin-right: .35rem; color: #6366f1; font-size: .75rem;"></i>
                                {{ ucfirst($role->name) }}
                            </div>
                        </label>
                    @endforeach
                </div>

                {{-- ── Form Actions ── --}}
                <div class="ucr-actions">
                    <a href="{{ route('admin.users.index') }}" class="btn-ucr-cancel">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                    <button type="submit" class="btn-ucr-submit">
                        <i class="bi bi-check-lg"></i> Create User
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
function selectRole(el, roleName) {
    document.querySelectorAll('.ucr-role-option').forEach(function(opt) {
        opt.classList.remove('selected');
        opt.querySelector('input[type="radio"]').checked = false;
    });
    el.classList.add('selected');
    el.querySelector('input[type="radio"]').checked = true;
}
</script>
@endsection
