@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white text-center py-3">
                    <h4 class="mb-0">
                        <i class="bi bi-shield-lock me-2"></i>Change Password
                    </h4>
                </div>

                <div class="card-body p-4">

                    {{-- Flash Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('change-password.update') }}">
                        @csrf
                        @method('PUT')

                        {{-- Current Password --}}
                        <div class="mb-3">
                            <label for="current_password" class="form-label">
                                <i class="bi bi-lock me-1"></i>Current Password
                            </label>
                            <input type="password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password"
                                   name="current_password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="Enter current password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div class="mb-3">
                            <label for="new_password" class="form-label">
                                <i class="bi bi-lock-fill me-1"></i>New Password
                            </label>
                            <input type="password"
                                   class="form-control @error('new_password') is-invalid @enderror"
                                   id="new_password"
                                   name="new_password"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Enter new password">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm New Password --}}
                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label">
                                <i class="bi bi-lock-fill me-1"></i>Confirm New Password
                            </label>
                            <input type="password"
                                   class="form-control"
                                   id="new_password_confirmation"
                                   name="new_password_confirmation"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Confirm new password">
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Update Password
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
