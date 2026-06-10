@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    /* ── Reset & Base ── */
    .att-edit-page * { box-sizing: border-box; margin: 0; padding: 0; }
    .att-edit-page {
        font-family: 'Inter', sans-serif;
        color: #1e293b;
        min-height: 100vh;
        padding: 32px 0;
    }

    /* ── Animations ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(22px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulseRing {
        0%   { box-shadow: 0 0 0 0 rgba(99,102,241,.25); }
        70%  { box-shadow: 0 0 0 8px rgba(99,102,241,0); }
        100% { box-shadow: 0 0 0 0 rgba(99,102,241,0); }
    }
    .fade-up { animation: fadeUp .5s cubic-bezier(.22,1,.36,1) both; }
    .fade-up-1 { animation-delay: .05s; }
    .fade-up-2 { animation-delay: .10s; }
    .fade-up-3 { animation-delay: .15s; }
    .fade-up-4 { animation-delay: .20s; }

    /* ── Flash Messages ── */
    .att-flash {
        padding: 14px 20px;
        border-radius: 12px;
        font-size: .875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
        animation: fadeUp .45s cubic-bezier(.22,1,.36,1) both;
        border: 1px solid;
    }
    .att-flash-error {
        background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
        color: #991b1b;
        border-color: #fca5a5;
    }
    .att-flash-error i { font-size: 1.15rem; }

    /* ── Page Header ── */
    .att-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 28px;
    }
    .att-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .att-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.35rem;
        box-shadow: 0 4px 14px rgba(99,102,241,.3);
        animation: pulseRing 2.5s ease infinite;
    }
    .att-header h1 {
        font-size: 1.65rem;
        font-weight: 800;
        background: linear-gradient(135deg, #312e81 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -.025em;
    }
    .att-header h1 span {
        display: block;
        font-size: .8rem;
        font-weight: 500;
        -webkit-text-fill-color: #64748b;
        letter-spacing: .02em;
    }

    /* ── Buttons ── */
    .att-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 20px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: .835rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all .25s cubic-bezier(.22,1,.36,1);
        white-space: nowrap;
    }
    .att-btn-primary {
        background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
        color: #fff;
        box-shadow: 0 4px 14px rgba(99,102,241,.3);
    }
    .att-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(99,102,241,.4);
        color: #fff;
    }
    .att-btn-outline {
        background: #fff;
        color: #6366f1;
        border: 1.5px solid #c7d2fe;
        box-shadow: 0 1px 3px rgba(99,102,241,.08);
    }
    .att-btn-outline:hover {
        background: #eef2ff;
        border-color: #818cf8;
        transform: translateY(-2px);
        color: #6366f1;
        text-decoration: none;
    }
    .att-btn-ghost {
        background: #f1f5f9;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
    }
    .att-btn-ghost:hover {
        background: #e2e8f0;
        color: #475569;
        text-decoration: none;
    }

    /* ── Employee Info Card ── */
    .att-info-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 6px 24px rgba(0,0,0,.03);
        margin-bottom: 20px;
    }
    .att-info-card-header {
        padding: 16px 28px;
        border-bottom: 1px solid #f1f5f9;
        background: linear-gradient(135deg, #fafbff 0%, #f8fafc 100%);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .att-info-card-header-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background: #ecfdf5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #059669;
        font-size: .95rem;
    }
    .att-info-card-header h3 {
        font-size: .9rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -.01em;
    }
    .att-info-card-body {
        padding: 22px 28px;
    }
    .att-info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    .att-info-item-label {
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #94a3b8;
        margin-bottom: 6px;
    }
    .att-info-item-value {
        font-size: .9rem;
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .att-info-badge {
        display: inline-flex;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: .72rem;
        font-weight: 700;
        background: #eef2ff;
        color: #6366f1;
        letter-spacing: .02em;
    }

    /* ── Form Card ── */
    .att-form-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 6px 24px rgba(0,0,0,.03);
    }
    .att-form-card-header {
        padding: 20px 28px;
        border-bottom: 1px solid #f1f5f9;
        background: linear-gradient(135deg, #fafbff 0%, #f8fafc 100%);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .att-form-card-header-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #eef2ff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6366f1;
        font-size: 1.05rem;
    }
    .att-form-card-header h2 {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -.015em;
    }
    .att-form-card-header h2 span {
        display: block;
        font-size: .75rem;
        font-weight: 500;
        color: #94a3b8;
        margin-top: 2px;
    }
    .att-form-card-body {
        padding: 28px;
    }

    /* ── Form Controls ── */
    .att-form-group {
        margin-bottom: 22px;
    }
    .att-form-group:last-child { margin-bottom: 0; }
    .att-form-label {
        display: block;
        font-size: .78rem;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 8px;
    }
    .att-form-label .required {
        color: #ef4444;
        margin-left: 3px;
    }
    .att-form-input,
    .att-form-select,
    .att-form-textarea {
        width: 100%;
        padding: 11px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: .875rem;
        color: #1e293b;
        background: #f8fafc;
        transition: all .2s ease;
        outline: none;
    }
    .att-form-input:focus,
    .att-form-select:focus,
    .att-form-textarea:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        background: #fff;
    }
    .att-form-input.is-invalid,
    .att-form-select.is-invalid,
    .att-form-textarea.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,.1);
    }
    .att-form-textarea {
        resize: vertical;
        min-height: 90px;
    }
    .att-form-error {
        display: block;
        font-size: .75rem;
        font-weight: 600;
        color: #ef4444;
        margin-top: 6px;
    }

    /* ── Input Group (Clock) ── */
    .att-input-group {
        display: flex;
        align-items: stretch;
    }
    .att-input-group-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 14px;
        border: 1.5px solid #e2e8f0;
        border-right: none;
        border-radius: 10px 0 0 10px;
        background: #f1f5f9;
        color: #64748b;
        font-size: .95rem;
    }
    .att-input-group-icon.clock-in { color: #059669; background: #ecfdf5; border-color: #a7f3d0; }
    .att-input-group-icon.clock-out { color: #e11d48; background: #fff1f2; border-color: #fecdd3; }
    .att-input-group .att-form-input {
        border-radius: 0 10px 10px 0;
    }

    /* ── Grid ── */
    .att-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    /* ── Form Actions ── */
    .att-form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 20px 28px;
        border-top: 1px solid #f1f5f9;
        background: #fafbff;
    }

    /* ── Validation Summary ── */
    .att-validation-summary {
        padding: 16px 20px;
        border-radius: 12px;
        background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
        border: 1px solid #fca5a5;
        margin-bottom: 24px;
    }
    .att-validation-summary h4 {
        font-size: .85rem;
        font-weight: 700;
        color: #991b1b;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
    }
    .att-validation-summary ul {
        list-style: none;
        padding: 0;
    }
    .att-validation-summary li {
        font-size: .8rem;
        color: #991b1b;
        padding: 3px 0;
        padding-left: 16px;
        position: relative;
    }
    .att-validation-summary li::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #f87171;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .att-header { flex-direction: column; align-items: flex-start; }
        .att-form-row { grid-template-columns: 1fr; }
        .att-info-grid { grid-template-columns: 1fr; }
        .att-form-card-body, .att-info-card-body { padding: 20px; }
        .att-form-actions { padding: 16px 20px; }
        .att-edit-page { padding: 16px 0; }
    }
</style>

<div class="att-edit-page">
    <div class="container" style="max-width: 760px;">

        {{-- ── Flash Error ── --}}
        @if(session('error'))
            <div class="att-flash att-flash-error">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- ── Validation Errors ── --}}
        @if($errors->any())
            <div class="att-validation-summary fade-up">
                <h4><i class="bi bi-exclamation-triangle-fill"></i> Please fix the following errors:</h4>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ── Page Header ── --}}
        <div class="att-header fade-up fade-up-1">
            <div class="att-header-left">
                <div class="att-header-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <h1>
                    Edit Attendance
                    <span>Update attendance record for {{ $attendance->employee->full_name }}</span>
                </h1>
            </div>
            <a href="{{ route('admin.attendance.index') }}" class="att-btn att-btn-outline">
                <i class="bi bi-arrow-left"></i> Back to Attendance
            </a>
        </div>

        {{-- ── Form ── --}}
        <form action="{{ route('admin.attendance.update', $attendance) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Employee Info (Read-only) --}}
            <div class="att-info-card fade-up fade-up-2">
                <div class="att-info-card-header">
                    <div class="att-info-card-header-icon">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <h3>Employee Information</h3>
                </div>
                <div class="att-info-card-body">
                    <div class="att-info-grid">
                        <div>
                            <div class="att-info-item-label">Employee Name</div>
                            <div class="att-info-item-value">
                                <i class="bi bi-person-fill" style="color: #6366f1;"></i>
                                {{ $attendance->employee->full_name }}
                            </div>
                        </div>
                        <div>
                            <div class="att-info-item-label">Employee Code</div>
                            <div class="att-info-item-value">
                                <span class="att-info-badge">{{ $attendance->employee->employee_code }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="att-info-item-label">Date</div>
                            <div class="att-info-item-value">
                                <i class="bi bi-calendar-date" style="color: #6366f1;"></i>
                                {{ \Carbon\Carbon::parse($attendance->date)->format('D, d M Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Editable Fields --}}
            <div class="att-form-card fade-up fade-up-3">
                <div class="att-form-card-header">
                    <div class="att-form-card-header-icon">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <h2>
                        Attendance Details
                        <span>Update the attendance information below</span>
                    </h2>
                </div>

                <div class="att-form-card-body">

                    {{-- Date (hidden, for submission) --}}
                    <input type="hidden" name="date" value="{{ $attendance->date }}">

                    {{-- Clock In & Clock Out Row --}}
                    <div class="att-form-row">
                        <div class="att-form-group">
                            <label class="att-form-label" for="clock_in">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Clock In
                            </label>
                            <div class="att-input-group">
                                <span class="att-input-group-icon clock-in">
                                    <i class="bi bi-sunrise"></i>
                                </span>
                                <input type="time" name="clock_in" id="clock_in"
                                       class="att-form-input @error('clock_in') is-invalid @enderror"
                                       value="{{ old('clock_in', $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '') }}">
                            </div>
                            @error('clock_in')
                                <span class="att-form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="att-form-group">
                            <label class="att-form-label" for="clock_out">
                                <i class="bi bi-box-arrow-right me-1"></i> Clock Out
                            </label>
                            <div class="att-input-group">
                                <span class="att-input-group-icon clock-out">
                                    <i class="bi bi-sunset"></i>
                                </span>
                                <input type="time" name="clock_out" id="clock_out"
                                       class="att-form-input @error('clock_out') is-invalid @enderror"
                                       value="{{ old('clock_out', $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '') }}">
                            </div>
                            @error('clock_out')
                                <span class="att-form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="att-form-group">
                        <label class="att-form-label" for="status">
                            <i class="bi bi-flag me-1"></i> Status <span class="required">*</span>
                        </label>
                        <select name="status" id="status"
                                class="att-form-select @error('status') is-invalid @enderror" required>
                            <option value="present" {{ old('status', $attendance->status) == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ old('status', $attendance->status) == 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="half_day" {{ old('status', $attendance->status) == 'half_day' ? 'selected' : '' }}>Half Day</option>
                            <option value="leave" {{ old('status', $attendance->status) == 'leave' ? 'selected' : '' }}>Leave</option>
                            <option value="holiday" {{ old('status', $attendance->status) == 'holiday' ? 'selected' : '' }}>Holiday</option>
                        </select>
                        @error('status')
                            <span class="att-form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Remarks --}}
                    <div class="att-form-group">
                        <label class="att-form-label" for="remarks">
                            <i class="bi bi-chat-left-text me-1"></i> Remarks
                        </label>
                        <textarea name="remarks" id="remarks"
                                  class="att-form-textarea @error('remarks') is-invalid @enderror"
                                  placeholder="Optional correction notes…">{{ old('remarks', $attendance->remarks) }}</textarea>
                        @error('remarks')
                            <span class="att-form-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                {{-- Form Actions --}}
                <div class="att-form-actions">
                    <a href="{{ route('admin.attendance.index') }}" class="att-btn att-btn-ghost">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <button type="submit" class="att-btn att-btn-primary">
                        <i class="bi bi-check-circle"></i> Update Attendance
                    </button>
                </div>
            </div>

        </form>

    </div>
</div>
@endsection
