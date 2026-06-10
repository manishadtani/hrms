@extends('layouts.app')

@section('content')
<style>
    .profile-edit-page {
        --primary: #0891b2;
        --primary-light: #06b6d4;
        --teal-dark: #0e7490;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --indigo: #6366f1;
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-700: #334155;
        --slate-800: #1e293b;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* ── Header Banner ── */
    .edit-header {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 40%, #0e7490 100%);
        border-radius: 20px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
    }
    .edit-header::before {
        content: '';
        position: absolute;
        right: -60px; top: -60px;
        width: 240px; height: 240px;
        background: rgba(255,255,255,0.07);
        border-radius: 50%;
    }
    .edit-header::after {
        content: '';
        position: absolute;
        right: 80px; bottom: -80px;
        width: 200px; height: 200px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }
    .edit-header-inner {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 28px 36px;
        position: relative;
        z-index: 1;
        flex-wrap: wrap;
    }
    .edit-header-icon {
        width: 56px; height: 56px;
        border-radius: 16px;
        background: rgba(255,255,255,0.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        backdrop-filter: blur(4px);
    }
    .edit-header-text h1 {
        font-size: 1.5rem; font-weight: 800;
        margin: 0 0 4px; letter-spacing: -0.5px;
    }
    .edit-header-text p {
        font-size: 0.88rem; opacity: 0.8; margin: 0;
    }
    .edit-header-actions {
        margin-left: auto;
        display: flex; gap: 10px;
    }
    .btn-back-profile {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 22px; border-radius: 12px;
        font-size: 0.85rem; font-weight: 600;
        text-decoration: none;
        border: 2px solid rgba(255,255,255,0.4);
        color: #fff;
        background: rgba(255,255,255,0.1);
        transition: all 0.3s;
        backdrop-filter: blur(4px);
    }
    .btn-back-profile:hover {
        background: rgba(255,255,255,0.25);
        border-color: rgba(255,255,255,0.7);
        color: #fff;
        transform: translateY(-2px);
    }

    /* ── Form Cards ── */
    .edit-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--slate-100);
        overflow: hidden;
        transition: all 0.3s;
        position: relative;
        height: 100%;
    }
    .edit-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
    }
    .edit-card-bar {
        position: absolute; top: 0; left: 0; right: 0;
        height: 4px;
    }
    .bar-teal { background: linear-gradient(90deg, #06b6d4, #14b8a6); }
    .bar-indigo { background: linear-gradient(90deg, #6366f1, #818cf8); }
    .bar-emerald { background: linear-gradient(90deg, #10b981, #34d399); }
    .bar-violet { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }

    .edit-card-header {
        padding: 22px 24px 0;
        display: flex; align-items: center; gap: 12px;
    }
    .edit-card-icon {
        width: 40px; height: 40px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
    }
    .icon-teal { background: #f0fdfa; color: #0d9488; }
    .icon-indigo { background: #eef2ff; color: #6366f1; }
    .icon-emerald { background: #ecfdf5; color: #10b981; }
    .icon-violet { background: #f5f3ff; color: #8b5cf6; }

    .edit-card-header h5 {
        font-size: 1rem; font-weight: 700;
        color: var(--slate-800); margin: 0;
    }
    .edit-card-body {
        padding: 20px 24px 24px;
    }

    /* ── Read-Only Info ── */
    .readonly-field {
        display: flex; align-items: center; gap: 14px;
        padding: 12px 16px;
        background: var(--slate-50);
        border-radius: 12px;
        margin-bottom: 12px;
    }
    .readonly-field:last-child { margin-bottom: 0; }
    .readonly-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.9rem; flex-shrink: 0;
        background: #fff;
        color: var(--slate-500);
        border: 1px solid var(--slate-200);
    }
    .readonly-content { flex: 1; }
    .readonly-label {
        font-size: 0.68rem; text-transform: uppercase;
        letter-spacing: 0.6px; font-weight: 600;
        color: var(--slate-400); margin-bottom: 1px;
    }
    .readonly-value {
        font-size: 0.88rem; font-weight: 600; color: var(--slate-800);
    }
    .readonly-badge {
        font-size: 0.65rem; background: var(--slate-200);
        color: var(--slate-500); padding: 2px 8px;
        border-radius: 6px; font-weight: 600;
    }

    /* ── Form Inputs ── */
    .form-field { margin-bottom: 20px; }
    .form-field:last-child { margin-bottom: 0; }
    .form-field label {
        display: flex; align-items: center; gap: 8px;
        font-size: 0.82rem; font-weight: 600;
        color: var(--slate-700); margin-bottom: 8px;
        letter-spacing: 0.2px;
    }
    .form-field label i {
        font-size: 0.95rem; color: var(--slate-400);
    }
    .form-field .form-control,
    .form-field .form-select {
        border: 2px solid var(--slate-200);
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.9rem;
        font-family: 'Inter', sans-serif;
        color: var(--slate-800);
        background: var(--slate-50);
        transition: all 0.3s;
    }
    .form-field .form-control:focus,
    .form-field .form-select:focus {
        border-color: #06b6d4;
        box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1);
        background: #fff;
        outline: none;
    }
    .form-field .form-control.is-invalid {
        border-color: var(--danger);
    }
    .form-field .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }
    .form-field .form-text {
        font-size: 0.75rem; color: var(--slate-400);
        margin-top: 6px;
    }
    .form-field .invalid-feedback {
        font-size: 0.78rem; font-weight: 500;
    }

    /* ── Photo Upload ── */
    .photo-upload-area {
        display: flex; align-items: center; gap: 20px;
        padding: 20px;
        border: 2px dashed var(--slate-200);
        border-radius: 16px;
        background: var(--slate-50);
        transition: all 0.3s;
    }
    .photo-upload-area:hover {
        border-color: #06b6d4;
        background: #f0fdfa;
    }
    .photo-upload-area.drag-over {
        border-color: #06b6d4;
        background: #ecfeff;
        transform: scale(1.01);
    }
    .photo-current {
        width: 80px; height: 80px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden;
        background: rgba(6, 182, 212, 0.1);
        border: 3px solid var(--slate-200);
        transition: border-color 0.3s;
    }
    .photo-current img {
        width: 100%; height: 100%; object-fit: cover;
    }
    .photo-current .initials {
        font-size: 1.5rem; font-weight: 800;
        color: #0891b2;
    }
    .photo-upload-info { flex: 1; }
    .photo-upload-info h6 {
        font-size: 0.88rem; font-weight: 700;
        color: var(--slate-800); margin: 0 0 4px;
    }
    .photo-upload-info p {
        font-size: 0.78rem; color: var(--slate-400);
        margin: 0 0 10px;
    }
    .photo-upload-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: 10px;
        font-size: 0.8rem; font-weight: 600;
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        color: #fff; border: none; cursor: pointer;
        transition: all 0.3s;
    }
    .photo-upload-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(8, 145, 178, 0.3);
    }

    /* ── Action Buttons ── */
    .edit-actions {
        display: flex; justify-content: flex-end; gap: 12px;
        padding: 20px 24px;
        background: var(--slate-50);
        border-top: 1px solid var(--slate-100);
    }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 12px 24px; border-radius: 12px;
        font-size: 0.88rem; font-weight: 600;
        color: var(--slate-500); background: #fff;
        border: 2px solid var(--slate-200);
        text-decoration: none; transition: all 0.3s;
    }
    .btn-cancel:hover {
        background: var(--slate-50);
        border-color: var(--slate-400);
        color: var(--slate-700);
    }
    .btn-save {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 12px 28px; border-radius: 12px;
        font-size: 0.88rem; font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        border: none; cursor: pointer;
        transition: all 0.3s; letter-spacing: 0.3px;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(8, 145, 178, 0.35);
    }
    .btn-save:active { transform: translateY(0); }

    /* ── Flash Alerts ── */
    .edit-alert {
        border-radius: 12px; border: none;
        padding: 14px 20px; font-size: 0.88rem;
        font-weight: 500; display: flex;
        align-items: center; gap: 10px;
        margin-bottom: 20px;
    }
    .edit-alert-success { background: #ecfdf5; color: #166534; }
    .edit-alert-error { background: #fef2f2; color: #991b1b; }
    .edit-alert-warning { background: #fffbeb; color: #92400e; }

    /* ── Animations ── */
    .fade-up {
        opacity: 0; transform: translateY(20px);
        animation: editFadeUp 0.5s ease forwards;
    }
    @keyframes editFadeUp {
        to { opacity: 1; transform: translateY(0); }
    }
    .fade-up:nth-child(1) { animation-delay: 0.05s; }
    .fade-up:nth-child(2) { animation-delay: 0.1s; }
    .fade-up:nth-child(3) { animation-delay: 0.15s; }
    .fade-up:nth-child(4) { animation-delay: 0.2s; }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .edit-header-inner { padding: 20px; flex-direction: column; text-align: center; }
        .edit-header-actions { margin-left: 0; }
        .edit-card-body { padding: 16px; }
        .photo-upload-area { flex-direction: column; text-align: center; }
        .edit-actions { flex-direction: column; }
        .edit-actions .btn-cancel,
        .edit-actions .btn-save { width: 100%; justify-content: center; }
    }
</style>

<div class="profile-edit-page">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="edit-alert edit-alert-success alert alert-dismissible fade show">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="edit-alert edit-alert-error alert alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="edit-alert edit-alert-warning alert alert-dismissible fade show">
            <i class="bi bi-exclamation-circle-fill"></i>
            <div>
                <strong>Please fix the following:</strong>
                <ul class="mb-0 mt-1" style="font-size:0.82rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ═══ Header ═══ --}}
    <div class="edit-header fade-up">
        <div class="edit-header-inner">
            <div class="edit-header-icon">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div class="edit-header-text">
                <h1>Edit Profile</h1>
                <p>Update your personal information and contact details</p>
            </div>
            <div class="edit-header-actions">
                <a href="{{ route('employee.profile.show') }}" class="btn-back-profile">
                    <i class="bi bi-arrow-left"></i> Back to Profile
                </a>
            </div>
        </div>
    </div>

    <form action="{{ route('employee.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- ═══ Left Column: Read-Only Info ═══ --}}
            <div class="col-lg-4 fade-up">
                <div class="edit-card">
                    <div class="edit-card-bar bar-indigo"></div>
                    <div class="edit-card-header">
                        <div class="edit-card-icon icon-indigo">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>
                        <h5>Employee Info</h5>
                    </div>
                    <div class="edit-card-body">
                        <p style="font-size:0.75rem;color:var(--slate-400);margin-bottom:16px;">
                            <i class="bi bi-lock-fill" style="margin-right:4px;"></i>
                            These fields are managed by your administrator
                        </p>

                        <div class="readonly-field">
                            <div class="readonly-icon"><i class="bi bi-person"></i></div>
                            <div class="readonly-content">
                                <div class="readonly-label">Full Name</div>
                                <div class="readonly-value">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                            </div>
                        </div>

                        <div class="readonly-field">
                            <div class="readonly-icon"><i class="bi bi-hash"></i></div>
                            <div class="readonly-content">
                                <div class="readonly-label">Employee Code</div>
                                <div class="readonly-value" style="font-family:monospace;">{{ $employee->employee_code }}</div>
                            </div>
                            <span class="readonly-badge">ID</span>
                        </div>

                        <div class="readonly-field">
                            <div class="readonly-icon"><i class="bi bi-envelope"></i></div>
                            <div class="readonly-content">
                                <div class="readonly-label">Email Address</div>
                                <div class="readonly-value">{{ $employee->user->email ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="readonly-field">
                            <div class="readonly-icon"><i class="bi bi-diagram-3"></i></div>
                            <div class="readonly-content">
                                <div class="readonly-label">Department</div>
                                <div class="readonly-value">{{ $employee->department->name ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="readonly-field">
                            <div class="readonly-icon"><i class="bi bi-bookmark-star"></i></div>
                            <div class="readonly-content">
                                <div class="readonly-label">Designation</div>
                                <div class="readonly-value">{{ $employee->designation->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ Right Column: Editable Fields ═══ --}}
            <div class="col-lg-8 fade-up">
                <div class="edit-card">
                    <div class="edit-card-bar bar-teal"></div>
                    <div class="edit-card-header">
                        <div class="edit-card-icon icon-teal">
                            <i class="bi bi-pencil-fill"></i>
                        </div>
                        <h5>Editable Details</h5>
                    </div>
                    <div class="edit-card-body">

                    <div class="row">
                            {{-- Phone --}}
                            <div class="col-md-6">
                                <div class="form-field">
                                    <label for="phone"><i class="bi bi-telephone"></i> Phone Number</label>
                                    <input type="text" name="phone" id="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone', $employee->phone) }}"
                                           placeholder="e.g. +91 98765 43210">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Gender --}}
                            <div class="col-md-6">
                                <div class="form-field">
                                    <label for="gender"><i class="bi bi-gender-ambiguous"></i> Gender</label>
                                    <select name="gender" id="gender"
                                            class="form-select @error('gender') is-invalid @enderror">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $employee->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Date of Birth --}}
                            <div class="col-md-6">
                                <div class="form-field">
                                    <label for="date_of_birth"><i class="bi bi-cake2"></i> Date of Birth</label>
                                    <input type="date" name="date_of_birth" id="date_of_birth"
                                           class="form-control @error('date_of_birth') is-invalid @enderror"
                                           value="{{ old('date_of_birth', $employee->date_of_birth ? \Carbon\Carbon::parse($employee->date_of_birth)->format('Y-m-d') : '') }}">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Empty spacer for alignment --}}
                            <div class="col-md-6"></div>

                            {{-- Address --}}
                            <div class="col-12">
                                <div class="form-field">
                                    <label for="address"><i class="bi bi-geo-alt"></i> Residential Address</label>
                                    <textarea name="address" id="address" rows="3"
                                              class="form-control @error('address') is-invalid @enderror"
                                              placeholder="Enter your full residential address">{{ old('address', $employee->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">This will be visible on your employee profile.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="edit-actions">
                        <a href="{{ route('employee.profile.show') }}" class="btn-cancel">
                            <i class="bi bi-x-lg"></i> Cancel
                        </a>
                        <button type="submit" class="btn-save" id="saveBtn">
                            <i class="bi bi-check-lg"></i> Save Changes
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>

    <div style="height:40px;"></div>
</div>

<script>
    // ── Save Button Animation ──
    document.getElementById('profileForm').addEventListener('submit', function() {
        const btn = document.getElementById('saveBtn');
        btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Saving...';
        btn.disabled = true;
    });

    // Spin animation for save button
    const style = document.createElement('style');
    style.textContent = `@keyframes spin { to { transform: rotate(360deg); } } .spin { animation: spin 1s linear infinite; }`;
    document.head.appendChild(style);
</script>
@endsection
