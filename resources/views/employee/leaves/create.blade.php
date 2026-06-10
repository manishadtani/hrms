@extends('layouts.app')

@section('content')
<style>
    :root {
        --clr-primary: #4f46e5;
        --clr-primary-light: #6366f1;
        --clr-primary-dark: #3730a3;
        --clr-accent: #818cf8;
        --clr-bg: #f1f5f9;
        --clr-surface: #ffffff;
        --clr-text: #1e293b;
        --clr-text-muted: #64748b;
        --clr-border: #e2e8f0;
        --clr-error: #ef4444;
        --clr-error-bg: #fef2f2;
        --clr-error-border: #fecaca;
        --clr-success: #22c55e;
        --radius: 16px;
        --radius-sm: 10px;
        --shadow-card: 0 1px 3px rgba(0,0,0,0.04), 0 6px 24px rgba(0,0,0,0.06);
        --shadow-hover: 0 8px 32px rgba(79,70,229,0.13);
        --shadow-focus: 0 0 0 3px rgba(99,102,241,0.18);
        --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .leave-page {
        font-family: 'Inter', sans-serif;
        color: var(--clr-text);
    }

    /* ── fadeUp animation ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up          { animation: fadeUp .5s ease-out both; }
    .fade-up-delay-1  { animation: fadeUp .5s ease-out .08s both; }
    .fade-up-delay-2  { animation: fadeUp .5s ease-out .16s both; }
    .fade-up-delay-3  { animation: fadeUp .5s ease-out .24s both; }

    /* ── Page header / gradient banner ── */
    .page-banner {
        background: linear-gradient(135deg, var(--clr-primary) 0%, var(--clr-primary-light) 50%, var(--clr-accent) 100%);
        border-radius: var(--radius);
        padding: 32px 36px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        position: relative;
        overflow: hidden;
    }
    .page-banner::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 180px; height: 180px;
        background: rgba(255,255,255,0.07);
        border-radius: 50%;
    }
    .page-banner::after {
        content: '';
        position: absolute;
        bottom: -30px; left: 30%;
        width: 120px; height: 120px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .page-banner h1 {
        font-size: 1.65rem;
        font-weight: 700;
        margin: 0 0 4px 0;
        letter-spacing: -0.02em;
    }
    .page-banner p {
        margin: 0;
        font-size: 0.92rem;
        opacity: 0.85;
        font-weight: 400;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 22px;
        background: rgba(255,255,255,0.18);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: var(--radius-sm);
        font-size: 0.88rem;
        font-weight: 500;
        text-decoration: none;
        backdrop-filter: blur(6px);
        transition: var(--transition);
        position: relative;
        z-index: 1;
    }
    .btn-back:hover {
        background: rgba(255,255,255,0.3);
        color: #fff;
        transform: translateY(-1px);
    }

    /* ── Flash / error alerts ── */
    .alert-flash {
        border-radius: var(--radius-sm);
        padding: 14px 20px;
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        border: none;
        position: relative;
    }
    .alert-flash.alert-error {
        background: var(--clr-error-bg);
        color: var(--clr-error);
        border-left: 4px solid var(--clr-error);
    }
    .alert-flash .alert-icon {
        font-size: 1.15rem;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .alert-flash .btn-dismiss {
        background: none;
        border: none;
        color: inherit;
        opacity: 0.5;
        font-size: 1.1rem;
        cursor: pointer;
        padding: 0;
        margin-left: auto;
        flex-shrink: 0;
        transition: opacity 0.2s;
    }
    .alert-flash .btn-dismiss:hover { opacity: 1; }

    .validation-list {
        list-style: none;
        padding: 0;
        margin: 6px 0 0 0;
    }
    .validation-list li {
        padding: 3px 0;
        font-size: 0.85rem;
        font-weight: 400;
    }
    .validation-list li::before {
        content: '•';
        margin-right: 8px;
        font-weight: 700;
    }

    /* ── Form card ── */
    .form-card {
        background: var(--clr-surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        transition: var(--transition);
    }
    .form-card:hover {
        box-shadow: var(--shadow-hover);
    }
    .form-card-header {
        padding: 22px 30px;
        border-bottom: 1px solid var(--clr-border);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-card-header .header-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--clr-primary), var(--clr-primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.05rem;
        flex-shrink: 0;
    }
    .form-card-header h2 {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
        color: var(--clr-text);
    }
    .form-card-header span {
        font-size: 0.82rem;
        color: var(--clr-text-muted);
        font-weight: 400;
    }
    .form-card-body {
        padding: 30px;
    }

    /* ── Form groups ── */
    .form-group {
        margin-bottom: 24px;
    }
    .form-group:last-child {
        margin-bottom: 0;
    }
    .form-label-custom {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--clr-text);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .form-label-custom .required-star {
        color: var(--clr-error);
        margin-left: 2px;
    }

    /* ── Input wrapper with icon ── */
    .input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-wrap .input-icon {
        position: absolute;
        left: 14px;
        color: var(--clr-text-muted);
        font-size: 1.05rem;
        transition: color 0.25s;
        z-index: 2;
        pointer-events: none;
    }
    .input-wrap input,
    .input-wrap select,
    .input-wrap textarea {
        width: 100%;
        padding: 12px 14px 12px 42px;
        border: 1.5px solid var(--clr-border);
        border-radius: var(--radius-sm);
        font-family: 'Inter', sans-serif;
        font-size: 0.92rem;
        color: var(--clr-text);
        background: var(--clr-surface);
        outline: none;
        transition: var(--transition);
        -webkit-appearance: none;
    }
    .input-wrap select {
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8.825a.5.5 0 0 1-.354-.146l-4-4a.5.5 0 0 1 .708-.708L6 7.617l3.646-3.646a.5.5 0 0 1 .708.708l-4 4A.5.5 0 0 1 6 8.825z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 14px;
        padding-right: 38px;
    }
    .input-wrap textarea {
        resize: vertical;
        min-height: 110px;
        line-height: 1.6;
    }

    /* Focus states */
    .input-wrap input:focus,
    .input-wrap select:focus,
    .input-wrap textarea:focus {
        border-color: var(--clr-primary);
        box-shadow: var(--shadow-focus);
    }
    .input-wrap:has(input:focus) .input-icon,
    .input-wrap:has(select:focus) .input-icon,
    .input-wrap:has(textarea:focus) .input-icon {
        color: var(--clr-primary);
    }

    /* Error states */
    .input-wrap.has-error input,
    .input-wrap.has-error select,
    .input-wrap.has-error textarea {
        border-color: var(--clr-error);
        background: var(--clr-error-bg);
    }
    .input-wrap.has-error input:focus,
    .input-wrap.has-error select:focus,
    .input-wrap.has-error textarea:focus {
        box-shadow: 0 0 0 3px rgba(239,68,68,0.15);
    }
    .input-wrap.has-error .input-icon {
        color: var(--clr-error);
    }
    .field-error {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 6px;
        font-size: 0.8rem;
        color: var(--clr-error);
        font-weight: 500;
    }
    .field-error i { font-size: 0.85rem; flex-shrink: 0; }

    .field-hint {
        margin-top: 6px;
        font-size: 0.8rem;
        color: var(--clr-text-muted);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* ── Date row ── */
    .date-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    /* ── Submit button ── */
    .btn-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 14px 28px;
        background: linear-gradient(135deg, var(--clr-primary), var(--clr-primary-light));
        color: #fff;
        border: none;
        border-radius: var(--radius-sm);
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        letter-spacing: 0.01em;
        position: relative;
        overflow: hidden;
    }
    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        transition: left 0.5s;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79,70,229,0.35);
    }
    .btn-submit:hover::before {
        left: 100%;
    }
    .btn-submit:active {
        transform: translateY(0);
    }

    /* ── Leave type info cards ── */
    .leave-types-info {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 12px;
        margin-top: 20px;
    }
    .leave-type-chip {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-sm);
        padding: 14px 16px;
        text-align: center;
        transition: var(--transition);
    }
    .leave-type-chip:hover {
        border-color: var(--clr-accent);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99,102,241,0.1);
    }
    .leave-type-chip .chip-name {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--clr-text);
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .leave-type-chip .chip-days {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--clr-primary);
    }
    .leave-type-chip .chip-label {
        font-size: 0.72rem;
        color: var(--clr-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    /* ── Bottom color bar on form card ── */
    .form-card-bottom-bar {
        height: 4px;
        background: linear-gradient(90deg, var(--clr-primary), var(--clr-primary-light), var(--clr-accent));
        border-radius: 0 0 var(--radius) var(--radius);
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .page-banner {
            padding: 24px 20px;
            flex-direction: column;
            align-items: flex-start;
        }
        .page-banner h1 { font-size: 1.35rem; }
        .btn-back { align-self: flex-start; }
        .form-card-body { padding: 20px; }
        .date-row {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .leave-types-info {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .leave-types-info {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>

<div class="leave-page">

    {{-- ── Page Banner ── --}}
    <div class="page-banner fade-up" style="margin-bottom: 24px;">
        <div>
            <h1><i class="bi bi-calendar-plus me-2"></i>Apply for Leave</h1>
            <p>Submit a new leave application to your manager for approval</p>
        </div>
        <a href="{{ route('employee.leaves.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back to My Leaves
        </a>
    </div>

    {{-- ── Flash Error ── --}}
    @if (session('error'))
        <div class="alert-flash alert-error fade-up-delay-1" style="margin-bottom: 20px;" id="flashAlert">
            <i class="bi bi-exclamation-triangle-fill alert-icon"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-dismiss" onclick="this.closest('.alert-flash').style.display='none'">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    {{-- ── Validation Errors ── --}}
    @if ($errors->any())
        <div class="alert-flash alert-error fade-up-delay-1" style="margin-bottom: 20px;">
            <i class="bi bi-exclamation-triangle-fill alert-icon"></i>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul class="validation-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-dismiss" onclick="this.closest('.alert-flash').style.display='none'">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-7 col-xl-6">

            {{-- ── Form Card ── --}}
            <div class="form-card fade-up-delay-2">
                <div class="form-card-header">
                    <div class="header-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <h2>Leave Application Form</h2>
                        <span>All fields marked with <span style="color:var(--clr-error);">*</span> are required</span>
                    </div>
                </div>

                <div class="form-card-body">
                    <form action="{{ route('employee.leaves.store') }}" method="POST">
                        @csrf

                        {{-- Leave Type --}}
                        <div class="form-group">
                            <label class="form-label-custom">
                                <i class="bi bi-tag-fill me-1" style="font-size:0.78rem;"></i>
                                Leave Type <span class="required-star">*</span>
                            </label>
                            <div class="input-wrap @error('leave_type_id') has-error @enderror">
                                <i class="bi bi-bookmark-star input-icon"></i>
                                <select name="leave_type_id" id="leave_type_id" required>
                                    <option value="">— Select Leave Type —</option>
                                    @foreach ($leaveTypes as $leaveType)
                                        <option value="{{ $leaveType->id }}"
                                                {{ old('leave_type_id') == $leaveType->id ? 'selected' : '' }}>
                                            {{ $leaveType->name }} — {{ $leaveType->days_per_year }} days/year
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('leave_type_id')
                                <div class="field-error">
                                    <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Date Range --}}
                        <div class="form-group">
                            <div class="date-row">
                                {{-- Start Date --}}
                                <div>
                                    <label class="form-label-custom">
                                        <i class="bi bi-calendar-event-fill me-1" style="font-size:0.78rem;"></i>
                                        Start Date <span class="required-star">*</span>
                                    </label>
                                    <div class="input-wrap @error('start_date') has-error @enderror">
                                        <i class="bi bi-calendar3 input-icon"></i>
                                        <input type="date" name="start_date" id="start_date"
                                               value="{{ old('start_date') }}"
                                               min="{{ date('Y-m-d') }}" required>
                                    </div>
                                    @error('start_date')
                                        <div class="field-error">
                                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- End Date --}}
                                <div>
                                    <label class="form-label-custom">
                                        <i class="bi bi-calendar-event-fill me-1" style="font-size:0.78rem;"></i>
                                        End Date <span class="required-star">*</span>
                                    </label>
                                    <div class="input-wrap @error('end_date') has-error @enderror">
                                        <i class="bi bi-calendar3 input-icon"></i>
                                        <input type="date" name="end_date" id="end_date"
                                               value="{{ old('end_date') }}"
                                               min="{{ date('Y-m-d') }}" required>
                                    </div>
                                    @error('end_date')
                                        <div class="field-error">
                                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Reason --}}
                        <div class="form-group">
                            <label class="form-label-custom">
                                <i class="bi bi-chat-left-text-fill me-1" style="font-size:0.78rem;"></i>
                                Reason <span class="required-star">*</span>
                            </label>
                            <div class="input-wrap @error('reason') has-error @enderror">
                                <i class="bi bi-chat-quote input-icon" style="top: 14px; align-self: flex-start;"></i>
                                <textarea name="reason" id="reason" rows="4"
                                          placeholder="Please provide a detailed reason for your leave request..."
                                          minlength="10" required>{{ old('reason') }}</textarea>
                            </div>
                            @error('reason')
                                <div class="field-error">
                                    <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                                </div>
                            @enderror
                            <div class="field-hint">
                                <i class="bi bi-info-circle"></i> Minimum 10 characters required
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div style="margin-top: 32px;">
                            <button type="submit" class="btn-submit">
                                <i class="bi bi-send-fill"></i>
                                Submit Application
                            </button>
                        </div>
                    </form>
                </div>

                <div class="form-card-bottom-bar"></div>
            </div>

            {{-- ── Leave Types Quick Reference ── --}}
            @if($leaveTypes->count())
                <div class="fade-up-delay-3" style="margin-top: 24px;">
                    <div style="font-size: 0.82rem; font-weight: 600; color: var(--clr-text-muted); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 10px;">
                        <i class="bi bi-info-circle me-1"></i> Available Leave Types
                    </div>
                    <div class="leave-types-info">
                        @foreach ($leaveTypes as $leaveType)
                            <div class="leave-type-chip">
                                <div class="chip-name" title="{{ $leaveType->name }}">{{ $leaveType->name }}</div>
                                <div class="chip-days">{{ $leaveType->days_per_year }}</div>
                                <div class="chip-label">days / year</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
