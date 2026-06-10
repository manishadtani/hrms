<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS — Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            padding: 20px;
        }

        .reset-card {
            width: 100%;
            max-width: 480px;
            background: #ffffff;
            border-radius: 24px;
            padding: 44px 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0,0,0,0.3);
            animation: slideUp 0.6s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .reset-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 5px;
            background: linear-gradient(90deg, #10b981, #34d399, #6ee7b7);
        }

        .icon-box {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            box-shadow: 0 12px 40px rgba(16,185,129,0.3);
        }
        .icon-box i { font-size: 32px; color: white; }

        h2 {
            text-align: center;
            font-size: 1.6rem;
            font-weight: 800;
            color: #1e1b4b;
            margin-bottom: 8px;
        }
        .subtitle {
            text-align: center;
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 32px;
        }

        .form-group { margin-bottom: 22px; }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        .input-wrapper { position: relative; }
        .input-wrapper input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            color: #1f2937;
            transition: all 0.3s ease;
            background: #f9fafb;
        }
        .input-wrapper input:focus {
            outline: none;
            border-color: #10b981;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(16,185,129,0.1);
        }
        .input-wrapper .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.1rem;
            transition: color 0.3s;
        }
        .input-wrapper input:focus ~ .input-icon { color: #10b981; }
        .input-wrapper input.is-invalid { border-color: #ef4444; }
        .invalid-feedback {
            display: block;
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 6px;
            font-weight: 500;
        }
        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: 1.1rem;
            transition: color 0.3s;
        }
        .toggle-password:hover { color: #10b981; }

        .btn-submit {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            color: white;
            background: linear-gradient(135deg, #10b981, #059669);
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 4px;
            position: relative;
            overflow: hidden;
        }
        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 40px rgba(16,185,129,0.4); }
        .btn-submit:hover::before { left: 100%; }

        .strength-bar {
            height: 4px;
            border-radius: 2px;
            background: #e5e7eb;
            margin-top: 8px;
            overflow: hidden;
        }
        .strength-fill {
            height: 100%;
            border-radius: 2px;
            transition: all 0.4s ease;
            width: 0%;
        }
        .strength-text {
            font-size: 0.72rem;
            font-weight: 600;
            margin-top: 4px;
            text-align: right;
        }

        .footer-text {
            text-align: center;
            margin-top: 28px;
            color: #94a3b8;
            font-size: 0.78rem;
        }

        .bg-circle {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
        }
        .bg-circle-1 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(16,185,129,0.15) 0%, transparent 70%);
            top: -100px; right: -100px;
            animation: float 8s ease-in-out infinite;
        }
        .bg-circle-2 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(5,150,105,0.1) 0%, transparent 70%);
            bottom: -80px; left: -80px;
            animation: float 6s ease-in-out infinite reverse;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }
    </style>
</head>
<body>
    <div class="bg-circle bg-circle-1"></div>
    <div class="bg-circle bg-circle-2"></div>

    <div class="reset-card">
        <div class="icon-box">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <h2>Create New Password</h2>
        <p class="subtitle">Your new password must be at least 8 characters long</p>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <input id="email" type="email"
                           class="@error('email') is-invalid @enderror"
                           name="email"
                           value="{{ $email ?? old('email') }}"
                           required autocomplete="email"
                           placeholder="your@email.com">
                    <i class="bi bi-envelope input-icon"></i>
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- New Password -->
            <div class="form-group">
                <label for="password">New Password</label>
                <div class="input-wrapper">
                    <input id="password" type="password"
                           class="@error('password') is-invalid @enderror"
                           name="password"
                           required autocomplete="new-password"
                           placeholder="Enter new password">
                    <i class="bi bi-lock input-icon"></i>
                    <button type="button" class="toggle-password" onclick="togglePw('password','togIcon1')">
                        <i class="bi bi-eye" id="togIcon1"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                <div class="strength-text" id="strengthText"></div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password-confirm">Confirm Password</label>
                <div class="input-wrapper">
                    <input id="password-confirm" type="password"
                           name="password_confirmation"
                           required autocomplete="new-password"
                           placeholder="Re-enter password">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <button type="button" class="toggle-password" onclick="togglePw('password-confirm','togIcon2')">
                        <i class="bi bi-eye" id="togIcon2"></i>
                    </button>
                </div>
                <div id="matchMsg" style="font-size:0.75rem;margin-top:6px;font-weight:600;"></div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="bi bi-check-circle-fill me-2"></i>Reset Password
            </button>
        </form>

        <div class="footer-text">
            &copy; {{ date('Y') }} Employee Management System
        </div>
    </div>

    <script>
        function togglePw(id, iconId) {
            const input = document.getElementById(id);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }

        // Password strength meter
        document.getElementById('password').addEventListener('input', function() {
            const val = this.value;
            const fill = document.getElementById('strengthFill');
            const text = document.getElementById('strengthText');
            let score = 0;
            if (val.length >= 8) score++;
            if (/[a-z]/.test(val) && /[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^a-zA-Z0-9]/.test(val)) score++;

            const levels = [
                { width: '0%', color: '#e5e7eb', label: '' },
                { width: '25%', color: '#ef4444', label: 'Weak' },
                { width: '50%', color: '#f59e0b', label: 'Fair' },
                { width: '75%', color: '#06b6d4', label: 'Good' },
                { width: '100%', color: '#10b981', label: 'Strong' }
            ];
            const level = levels[score];
            fill.style.width = level.width;
            fill.style.background = level.color;
            text.style.color = level.color;
            text.textContent = val.length > 0 ? level.label : '';
        });

        // Password match check
        document.getElementById('password-confirm').addEventListener('input', function() {
            const pw = document.getElementById('password').value;
            const msg = document.getElementById('matchMsg');
            if (this.value.length === 0) { msg.textContent = ''; return; }
            if (this.value === pw) {
                msg.textContent = '✓ Passwords match';
                msg.style.color = '#10b981';
            } else {
                msg.textContent = '✗ Passwords don\'t match';
                msg.style.color = '#ef4444';
            }
        });

        // Focus label color
        document.querySelectorAll('.input-wrapper input').forEach(input => {
            input.addEventListener('focus', function() {
                this.closest('.form-group').querySelector('label').style.color = '#10b981';
            });
            input.addEventListener('blur', function() {
                this.closest('.form-group').querySelector('label').style.color = '#374151';
            });
        });
    </script>
</body>
</html>
