@extends('layouts.app')

@section('content')
<style>
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .form-page-wrap {
        max-width: 620px;
        animation: fadeUp .5s cubic-bezier(.4,0,.2,1) both;
    }
    .form-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 24px rgba(0,0,0,.06);
        overflow: hidden;
    }
    .form-card-header {
        padding: 24px 28px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .form-card-header .header-icon {
        width: 44px; height: 44px;
        border-radius: 14px;
        background: linear-gradient(135deg, #f59e0b, #f97316);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 1.15rem;
        box-shadow: 0 4px 14px rgba(245,158,11,.25);
        flex-shrink: 0;
    }
    .form-card-header .header-text h2 {
        margin: 0;
        font-family: 'Inter', sans-serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e293b;
    }
    .form-card-header .header-text p {
        margin: 2px 0 0;
        font-family: 'Inter', sans-serif;
        font-size: .78rem;
        color: #94a3b8;
        font-weight: 400;
    }
    .form-card-body {
        padding: 28px;
    }
    .form-group {
        margin-bottom: 22px;
    }
    .form-group label {
        display: block;
        font-family: 'Inter', sans-serif;
        font-size: .82rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 7px;
    }
    .form-group label .req {
        color: #ef4444;
        margin-left: 2px;
    }
    .form-group input[type="text"],
    .form-group input[type="date"],
    .form-group select,
    .form-group textarea {
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
    .form-group input[type="text"]:focus,
    .form-group input[type="date"]:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #818cf8;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(99,102,241,.1);
    }
    .form-group input.input-error,
    .form-group select.input-error,
    .form-group textarea.input-error {
        border-color: #ef4444;
        background: #fef2f2;
    }
    .form-group input.input-error:focus,
    .form-group select.input-error:focus,
    .form-group textarea.input-error:focus {
        box-shadow: 0 0 0 3px rgba(239,68,68,.1);
    }
    .form-group select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 38px;
        cursor: pointer;
    }
    .form-group textarea {
        resize: vertical;
        min-height: 88px;
    }
    .form-group .error-msg {
        font-family: 'Inter', sans-serif;
        font-size: .76rem;
        color: #ef4444;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .form-group .hint-text {
        font-family: 'Inter', sans-serif;
        font-size: .74rem;
        color: #94a3b8;
        margin-top: 5px;
    }
    .form-row {
        display: flex;
        gap: 16px;
    }
    .form-row .form-group {
        flex: 1;
    }
    /* Toggle switch */
    .toggle-group {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 28px;
        padding: 14px 16px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
    }
    .toggle-switch {
        position: relative;
        width: 44px;
        height: 24px;
        flex-shrink: 0;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }
    .toggle-slider {
        position: absolute;
        inset: 0;
        background: #cbd5e1;
        border-radius: 24px;
        cursor: pointer;
        transition: all .25s ease;
    }
    .toggle-slider::before {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        left: 3px;
        top: 3px;
        background: #fff;
        border-radius: 50%;
        transition: all .25s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,.15);
    }
    .toggle-switch input:checked + .toggle-slider {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
    }
    .toggle-switch input:checked + .toggle-slider::before {
        transform: translateX(20px);
    }
    .toggle-label {
        font-family: 'Inter', sans-serif;
        font-size: .84rem;
        font-weight: 500;
        color: #475569;
    }
    .toggle-label small {
        display: block;
        font-size: .72rem;
        color: #94a3b8;
        font-weight: 400;
        margin-top: 1px;
    }
    /* Actions */
    .form-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-top: 6px;
    }
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 28px;
        background: linear-gradient(135deg, #f59e0b, #f97316);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-family: 'Inter', sans-serif;
        font-size: .88rem;
        font-weight: 600;
        cursor: pointer;
        transition: all .25s ease;
        box-shadow: 0 4px 14px rgba(245,158,11,.3);
    }
    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(245,158,11,.4);
    }
    .btn-submit:active {
        transform: translateY(0);
    }
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 11px 22px;
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
    .btn-cancel:hover {
        background: #f8fafc;
        color: #475569;
        border-color: #cbd5e1;
    }
    /* Error alert */
    .form-error-alert {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 18px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 12px;
        margin-bottom: 22px;
    }
    .form-error-alert .alert-icon {
        width: 32px; height: 32px;
        background: #fee2e2;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: #ef4444;
        font-size: .95rem;
        flex-shrink: 0;
    }
    .form-error-alert ul {
        margin: 0; padding: 0;
        list-style: none;
    }
    .form-error-alert ul li {
        font-family: 'Inter', sans-serif;
        font-size: .8rem;
        color: #dc2626;
        padding: 2px 0;
    }
</style>

<div class="form-page-wrap">
    {{-- Error Alert --}}
    @if ($errors->any())
        <div class="form-error-alert">
            <div class="alert-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li><i class="bi bi-dot"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <div class="form-card-header">
            <div class="header-icon"><i class="bi bi-pencil-fill"></i></div>
            <div class="header-text">
                <h2>Edit Holiday</h2>
                <p>Update details for <strong>{{ $holiday->name }}</strong></p>
            </div>
        </div>
        <div class="form-card-body">
            <form action="{{ route('admin.holidays.update', $holiday) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="form-group">
                    <label for="name">Holiday Name <span class="req">*</span></label>
                    <input type="text" name="name" id="name"
                           class="{{ $errors->has('name') ? 'input-error' : '' }}"
                           value="{{ old('name', $holiday->name) }}"
                           placeholder="e.g. Independence Day" required>
                    @error('name')
                        <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Date & Type --}}
                <div class="form-row">
                    <div class="form-group">
                        <label for="date">Date <span class="req">*</span></label>
                        <input type="date" name="date" id="date"
                               class="{{ $errors->has('date') ? 'input-error' : '' }}"
                               value="{{ old('date', $holiday->date instanceof \Carbon\Carbon ? $holiday->date->format('Y-m-d') : $holiday->date) }}" required>
                        @error('date')
                            <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type">Type <span class="req">*</span></label>
                        <select name="type" id="type"
                                class="{{ $errors->has('type') ? 'input-error' : '' }}" required>
                            <option value="" disabled>Select type...</option>
                            <option value="national" {{ old('type', $holiday->type) == 'national' ? 'selected' : '' }}>National</option>
                            <option value="regional" {{ old('type', $holiday->type) == 'regional' ? 'selected' : '' }}>Regional</option>
                            <option value="company" {{ old('type', $holiday->type) == 'company' ? 'selected' : '' }}>Company</option>
                            <option value="optional" {{ old('type', $holiday->type) == 'optional' ? 'selected' : '' }}>Optional</option>
                        </select>
                        @error('type')
                            <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="{{ $errors->has('description') ? 'input-error' : '' }}"
                              placeholder="Brief description of this holiday...">{{ old('description', $holiday->description) }}</textarea>
                    @error('description')
                        <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Is Active --}}
                <div class="toggle-group">
                    <label class="toggle-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $holiday->is_active) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                    <div class="toggle-label">
                        Active
                        <small>Inactive holidays won't appear on the calendar</small>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-lg"></i> Update Holiday
                    </button>
                    <a href="{{ route('admin.holidays.index') }}" class="btn-cancel">
                        <i class="bi bi-arrow-left"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
