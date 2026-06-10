<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS — Forgot Password</title>
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

        .forgot-card {
            width: 100%;
            max-width: 480px;
            background: #ffffff;
            border-radius: 24px;
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0,0,0,0.3);
            animation: slideUp 0.6s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .forgot-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #a78bfa);
        }

        .icon-box {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            box-shadow: 0 12px 40px rgba(99,102,241,0.3);
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
            line-height: 1.5;
        }

        .form-group { margin-bottom: 24px; }
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
            border-color: #6366f1;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
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
        .input-wrapper input:focus ~ .input-icon { color: #6366f1; }
        .input-wrapper input.is-invalid { border-color: #ef4444; }
        .invalid-feedback {
            display: block;
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 6px;
            font-weight: 500;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            color: white;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            cursor: pointer;
            transition: all 0.3s ease;
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
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 40px rgba(99,102,241,0.4); }
        .btn-submit:hover::before { left: 100%; }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 24px;
            font-size: 0.88rem;
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        .back-link:hover { color: #4f46e5; }

        .alert-modern {
            padding: 14px 18px;
            border-radius: 14px;
            font-size: 0.88rem;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.4s ease;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        .footer-text {
            text-align: center;
            margin-top: 28px;
            color: #94a3b8;
            font-size: 0.78rem;
        }

        /* Floating bg circles */
        .bg-circle {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
        }
        .bg-circle-1 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
            top: -100px; left: -100px;
            animation: float 8s ease-in-out infinite;
        }
        .bg-circle-2 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 70%);
            bottom: -80px; right: -80px;
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

    <div class="forgot-card">
        <div class="icon-box">
            <i class="bi bi-key-fill"></i>
        </div>

        <h2>Forgot Password?</h2>
        <p class="subtitle">No worries! Enter your email address and we'll send you a link to reset your password.</p>

        @if (session('status'))
            <div class="alert-modern alert-success">
                <i class="bi bi-check-circle-fill" style="font-size:1.2rem;"></i>
                <div>
                    <strong>Email Sent!</strong><br>
                    <span style="font-size:0.82rem;">{{ session('status') }}</span>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <input id="email" type="email"
                           class="@error('email') is-invalid @enderror"
                           name="email"
                           value="{{ old('email') }}"
                           required autocomplete="email" autofocus
                           placeholder="Enter your registered email">
                    <i class="bi bi-envelope input-icon"></i>
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                <i class="bi bi-send-fill me-2"></i>Send Reset Link
            </button>
        </form>

        <a href="{{ route('login') }}" class="back-link">
            <i class="bi bi-arrow-left"></i> Back to Sign In
        </a>

        <div class="footer-text">
            &copy; {{ date('Y') }} Employee Management System
        </div>
    </div>

    <script>
        document.querySelector('.input-wrapper input').addEventListener('focus', function() {
            this.closest('.form-group').querySelector('label').style.color = '#6366f1';
        });
        document.querySelector('.input-wrapper input').addEventListener('blur', function() {
            this.closest('.form-group').querySelector('label').style.color = '#374151';
        });
    </script>
</body>
</html>
