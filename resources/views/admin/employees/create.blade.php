@extends('layouts.app')

@section('content')
<style>
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .ef-page {
        max-width: 1100px;
        margin: 0 auto;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        -webkit-font-smoothing: antialiased;
    }

    /* ── Page Header ── */
    .ef-page-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 28px;
        animation: fadeUp .45s cubic-bezier(.4,0,.2,1) both;
    }
    .ef-page-header .header-icon {
        width: 52px; height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 1.35rem;
        box-shadow: 0 8px 24px rgba(99,102,241,.3);
        flex-shrink: 0;
    }
    .ef-page-header .header-text h1 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -.5px;
    }
    .ef-page-header .header-text p {
        margin: 3px 0 0;
        font-size: .85rem;
        color: #94a3b8;
        font-weight: 400;
    }

    /* ── Error Alert ── */
    .ef-error-alert {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 16px 20px;
        background: linear-gradient(135deg, #fef2f2, #fff1f2);
        border: 1px solid #fecaca;
        border-radius: 14px;
        margin-bottom: 24px;
        animation: fadeUp .45s cubic-bezier(.4,0,.2,1) .05s both;
    }
    .ef-error-alert .alert-icon {
        width: 36px; height: 36px;
        background: #fee2e2;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: #ef4444; font-size: 1rem;
        flex-shrink: 0;
    }
    .ef-error-alert .alert-content { flex: 1; }
    .ef-error-alert .alert-title {
        font-size: .88rem;
        font-weight: 700;
        color: #dc2626;
        margin: 0 0 6px;
    }
    .ef-error-alert ul {
        margin: 0; padding: 0;
        list-style: none;
    }
    .ef-error-alert ul li {
        font-size: .8rem;
        color: #b91c1c;
        padding: 2px 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .ef-error-alert ul li i { font-size: .7rem; color: #ef4444; }

    /* ── Two-column Grid ── */
    .ef-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    /* ── Card ── */
    .ef-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 24px rgba(0,0,0,.05);
        overflow: hidden;
        animation: fadeUp .5s cubic-bezier(.4,0,.2,1) both;
    }
    .ef-card:nth-child(1) { animation-delay: .1s; }
    .ef-card:nth-child(2) { animation-delay: .18s; }

    .ef-card-header {
        padding: 22px 26px 18px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(135deg, #fafbff 0%, #f8fafc 100%);
    }
    .ef-card-header .card-icon {
        width: 40px; height: 40px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.05rem;
        flex-shrink: 0;
    }
    .ef-card-header .card-icon.personal {
        background: linear-gradient(135deg, #dbeafe, #e0e7ff);
        color: #4f46e5;
    }
    .ef-card-header .card-icon.employment {
        background: linear-gradient(135deg, #d1fae5, #cffafe);
        color: #059669;
    }
    .ef-card-header .card-title {
        margin: 0;
        font-size: 1.02rem;
        font-weight: 700;
        color: #1e293b;
    }
    .ef-card-header .card-subtitle {
        margin: 2px 0 0;
        font-size: .76rem;
        color: #94a3b8;
        font-weight: 400;
    }

    .ef-card-body {
        padding: 26px;
    }

    /* ── Form Fields ── */
    .ef-form-group {
        margin-bottom: 20px;
    }
    .ef-form-group:last-child {
        margin-bottom: 0;
    }
    .ef-form-group label {
        display: block;
        font-size: .82rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 7px;
    }
    .ef-form-group label .req {
        color: #ef4444;
        margin-left: 2px;
    }

    .ef-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .ef-input,
    .ef-select,
    .ef-textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        font-family: 'Inter', sans-serif;
        font-size: .88rem;
        color: #1e293b;
        background: #f8fafc;
        transition: all .2s ease;
        outline: none;
        box-sizing: border-box;
    }
    .ef-select {
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M2.22 4.47a.75.75 0 0 1 1.06 0L6 7.19l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L2.22 5.53a.75.75 0 0 1 0-1.06z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 38px;
        cursor: pointer;
    }
    .ef-textarea {
        resize: vertical;
        min-height: 90px;
    }
    .ef-input:focus,
    .ef-select:focus,
    .ef-textarea:focus {
        border-color: #818cf8;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(99,102,241,.1);
    }
    .ef-input.is-invalid,
    .ef-select.is-invalid,
    .ef-textarea.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }
    .ef-input.is-invalid:focus,
    .ef-select.is-invalid:focus,
    .ef-textarea.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(239,68,68,.1);
    }
    .ef-error-msg {
        font-size: .76rem;
        color: #ef4444;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .ef-error-msg i { font-size: .7rem; }

    /* ── Bottom Actions ── */
    .ef-actions-bar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        padding: 20px 26px;
        background: #fff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 24px rgba(0,0,0,.05);
        animation: fadeUp .5s cubic-bezier(.4,0,.2,1) .25s both;
    }
    .ef-btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 11px 24px;
        background: #fff;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        font-family: 'Inter', sans-serif;
        font-size: .88rem;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: all .2s ease;
    }
    .ef-btn-cancel:hover {
        background: #f8fafc;
        color: #475569;
        border-color: #cbd5e1;
        text-decoration: none;
    }
    .ef-btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 32px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-family: 'Inter', sans-serif;
        font-size: .88rem;
        font-weight: 600;
        cursor: pointer;
        transition: all .25s ease;
        box-shadow: 0 4px 14px rgba(99,102,241,.3);
        position: relative;
        overflow: hidden;
    }
    .ef-btn-submit::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,.15) 0%, rgba(255,255,255,0) 100%);
        opacity: 0;
        transition: opacity .25s;
    }
    .ef-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(99,102,241,.4);
    }
    .ef-btn-submit:hover::before { opacity: 1; }
    .ef-btn-submit:active {
        transform: translateY(0);
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .ef-grid {
            grid-template-columns: 1fr;
        }
        .ef-form-row {
            grid-template-columns: 1fr;
        }
        .ef-actions-bar {
            flex-direction: column;
        }
        .ef-actions-bar .ef-btn-cancel,
        .ef-actions-bar .ef-btn-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="ef-page">

    {{-- Page Header --}}
    <div class="ef-page-header">
        <div class="header-icon">
            <i class="bi bi-person-plus-fill"></i>
        </div>
        <div class="header-text">
            <h1>Add New Employee</h1>
            <p>Fill in the details below to register a new employee</p>
        </div>
    </div>

    {{-- Validation Error Alert --}}
    @if ($errors->any())
        <div class="ef-error-alert">
            <div class="alert-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div class="alert-content">
                <p class="alert-title">Please fix the following errors</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-circle-fill"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.employees.store') }}" method="POST" autocomplete="off">
        @csrf

        <div class="ef-grid">
            {{-- ══════════════ LEFT CARD: Personal Details ══════════════ --}}
            <div class="ef-card">
                <div class="ef-card-header">
                    <div class="card-icon personal">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <h2 class="card-title">Personal Details</h2>
                        <p class="card-subtitle">Basic identity & contact information</p>
                    </div>
                </div>
                <div class="ef-card-body">

                    {{-- First Name & Last Name --}}
                    <div class="ef-form-row">
                        <div class="ef-form-group">
                            <label for="first_name">First Name <span class="req">*</span></label>
                            <input type="text" name="first_name" id="first_name"
                                   class="ef-input {{ $errors->has('first_name') ? 'is-invalid' : '' }}"
                                   value="{{ old('first_name') }}"
                                   placeholder="e.g. John" required>
                            @error('first_name')
                                <div class="ef-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="ef-form-group">
                            <label for="last_name">Last Name <span class="req">*</span></label>
                            <input type="text" name="last_name" id="last_name"
                                   class="ef-input {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                                   value="{{ old('last_name') }}"
                                   placeholder="e.g. Doe" required>
                            @error('last_name')
                                <div class="ef-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="ef-form-group">
                        <label for="email">Email Address <span class="req">*</span></label>
                        <input type="email" name="email" id="email"
                               class="ef-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               value="{{ old('email') }}"
                               placeholder="e.g. john.doe@company.com" required>
                        @error('email')
                            <div class="ef-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Employee Code --}}
                    <div class="ef-form-group">
                        <label for="employee_code">Employee Code <span class="req">*</span></label>
                        <input type="text" name="employee_code" id="employee_code"
                               class="ef-input {{ $errors->has('employee_code') ? 'is-invalid' : '' }}"
                               value="{{ old('employee_code') }}"
                               placeholder="e.g. EMP-001" required>
                        @error('employee_code')
                            <div class="ef-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Gender & Date of Birth --}}
                    <div class="ef-form-row">
                        <div class="ef-form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender"
                                    class="ef-select {{ $errors->has('gender') ? 'is-invalid' : '' }}">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="ef-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="ef-form-group">
                            <label for="date_of_birth">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth"
                                   class="ef-input {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}"
                                   value="{{ old('date_of_birth') }}">
                            @error('date_of_birth')
                                <div class="ef-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="ef-form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" id="phone"
                               class="ef-input {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                               value="{{ old('phone') }}"
                               placeholder="e.g. +91 98765 43210">
                        @error('phone')
                            <div class="ef-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div class="ef-form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" rows="3"
                                  class="ef-textarea {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                  placeholder="Full residential address...">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="ef-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- ══════════════ RIGHT CARD: Employment Details ══════════════ --}}
            <div class="ef-card">
                <div class="ef-card-header">
                    <div class="card-icon employment">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                    <div>
                        <h2 class="card-title">Employment Details</h2>
                        <p class="card-subtitle">Organizational role & assignment</p>
                    </div>
                </div>
                <div class="ef-card-body">

                    {{-- Department --}}
                    <div class="ef-form-group">
                        <label for="department_id">Department</label>
                        <select name="department_id" id="department_id"
                                class="ef-select {{ $errors->has('department_id') ? 'is-invalid' : '' }}">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="ef-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Designation --}}
                    <div class="ef-form-group">
                        <label for="designation_id">Designation</label>
                        <select name="designation_id" id="designation_id"
                                class="ef-select {{ $errors->has('designation_id') ? 'is-invalid' : '' }}">
                            <option value="">Select Designation</option>
                            @foreach($designations as $designation)
                                <option value="{{ $designation->id }}" {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                    {{ $designation->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('designation_id')
                            <div class="ef-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Manager --}}
                    <div class="ef-form-group">
                        <label for="manager_id">Reporting Manager</label>
                        <select name="manager_id" id="manager_id"
                                class="ef-select {{ $errors->has('manager_id') ? 'is-invalid' : '' }}">
                            <option value="">Select Manager</option>
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                    {{ $manager->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('manager_id')
                            <div class="ef-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Joining Date --}}
                    <div class="ef-form-group">
                        <label for="joining_date">Joining Date</label>
                        <input type="date" name="joining_date" id="joining_date"
                               class="ef-input {{ $errors->has('joining_date') ? 'is-invalid' : '' }}"
                               value="{{ old('joining_date') }}">
                        @error('joining_date')
                            <div class="ef-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Employment Status --}}
                    <div class="ef-form-group">
                        <label for="employment_status">Employment Status <span class="req">*</span></label>
                        <select name="employment_status" id="employment_status"
                                class="ef-select {{ $errors->has('employment_status') ? 'is-invalid' : '' }}" required>
                            <option value="">Select Status</option>
                            <option value="active" {{ old('employment_status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('employment_status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="terminated" {{ old('employment_status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                            <option value="resigned" {{ old('employment_status') == 'resigned' ? 'selected' : '' }}>Resigned</option>
                        </select>
                        @error('employment_status')
                            <div class="ef-error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ══════════════ Bottom Actions ══════════════ --}}
        <div class="ef-actions-bar">
            <a href="{{ route('admin.employees.index') }}" class="ef-btn-cancel">
                <i class="bi bi-arrow-left"></i> Cancel
            </a>
            <button type="submit" class="ef-btn-submit">
                <i class="bi bi-check-lg"></i> Create Employee
            </button>
        </div>

    </form>
</div>
@endsection
