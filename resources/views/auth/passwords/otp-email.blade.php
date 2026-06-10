<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS — Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter',sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#0f0c29 0%,#302b63 50%,#24243e 100%);padding:20px;position:relative;overflow:hidden}
        .bg-orb{position:fixed;border-radius:50%;pointer-events:none;filter:blur(60px)}
        .bg-orb-1{width:500px;height:500px;background:rgba(99,102,241,0.15);top:-150px;left:-100px;animation:drift 12s ease-in-out infinite}
        .bg-orb-2{width:400px;height:400px;background:rgba(139,92,246,0.1);bottom:-100px;right:-80px;animation:drift 10s ease-in-out infinite reverse}
        @keyframes drift{0%,100%{transform:translate(0,0)}50%{transform:translate(30px,-20px)}}

        .card{width:100%;max-width:460px;background:#fff;border-radius:28px;padding:48px 40px;position:relative;overflow:hidden;box-shadow:0 25px 80px rgba(0,0,0,0.35);animation:rise .6s ease}
        @keyframes rise{from{opacity:0;transform:translateY(30px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
        .card::before{content:'';position:absolute;top:0;left:0;right:0;height:5px;background:linear-gradient(90deg,#6366f1,#8b5cf6,#a78bfa)}

        .step-dots{display:flex;justify-content:center;gap:8px;margin-bottom:28px}
        .step-dot{width:10px;height:10px;border-radius:50%;background:#e5e7eb;transition:all .3s}
        .step-dot.active{background:#6366f1;width:28px;border-radius:5px}

        .icon-box{width:76px;height:76px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:22px;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;box-shadow:0 12px 40px rgba(99,102,241,.3);animation:pulse 2s ease-in-out infinite}
        @keyframes pulse{0%,100%{box-shadow:0 12px 40px rgba(99,102,241,.3)}50%{box-shadow:0 16px 50px rgba(99,102,241,.5)}}
        .icon-box i{font-size:34px;color:#fff}

        h2{text-align:center;font-size:1.65rem;font-weight:800;color:#1e1b4b;margin-bottom:8px}
        .subtitle{text-align:center;color:#64748b;font-size:.9rem;margin-bottom:32px;line-height:1.6}

        .form-group{margin-bottom:24px}
        .form-group label{display:block;font-size:.85rem;font-weight:600;color:#374151;margin-bottom:8px;transition:color .3s}
        .input-wrap{position:relative}
        .input-wrap input{width:100%;padding:15px 16px 15px 50px;border:2px solid #e5e7eb;border-radius:14px;font-size:.95rem;font-family:'Inter',sans-serif;color:#1f2937;transition:all .3s;background:#f9fafb}
        .input-wrap input:focus{outline:none;border-color:#6366f1;background:#fff;box-shadow:0 0 0 4px rgba(99,102,241,.1)}
        .input-wrap input.is-invalid{border-color:#ef4444;box-shadow:0 0 0 4px rgba(239,68,68,.08)}
        .input-wrap .icon{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:1.15rem;transition:color .3s}
        .input-wrap input:focus~.icon{color:#6366f1}
        .error-msg{color:#ef4444;font-size:.8rem;margin-top:6px;font-weight:500;display:flex;align-items:center;gap:4px}

        .btn-primary{width:100%;padding:16px;border:none;border-radius:14px;font-size:1rem;font-weight:700;font-family:'Inter',sans-serif;color:#fff;background:linear-gradient(135deg,#6366f1,#8b5cf6);cursor:pointer;transition:all .3s;position:relative;overflow:hidden}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 12px 40px rgba(99,102,241,.4)}
        .btn-primary:active{transform:translateY(0)}
        .btn-primary::after{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.2),transparent);transition:left .5s}
        .btn-primary:hover::after{left:100%}

        .back-link{display:flex;align-items:center;justify-content:center;gap:6px;margin-top:24px;font-size:.88rem;color:#6366f1;text-decoration:none;font-weight:600;transition:all .3s}
        .back-link:hover{color:#4f46e5;gap:10px}

        .alert-box{padding:14px 18px;border-radius:14px;font-size:.88rem;margin-bottom:24px;display:flex;align-items:center;gap:10px;animation:slideIn .4s ease}
        .alert-success{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
        .alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
        @keyframes slideIn{from{opacity:0;transform:translateX(-10px)}to{opacity:1;transform:translateX(0)}}

        .footer{text-align:center;margin-top:28px;color:#94a3b8;font-size:.78rem}
    </style>
</head>
<body>
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>

    <div class="card">
        <div class="step-dots">
            <span class="step-dot active"></span>
            <span class="step-dot"></span>
            <span class="step-dot"></span>
        </div>

        <div class="icon-box"><i class="bi bi-envelope-paper-fill"></i></div>
        <h2>Forgot Password?</h2>
        <p class="subtitle">Enter your registered email and we'll send you a <strong>6-digit OTP</strong> to verify your identity.</p>

        @if(session('success'))
            <div class="alert-box alert-success"><i class="bi bi-check-circle-fill" style="font-size:1.2rem"></i>{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-box alert-error"><i class="bi bi-exclamation-circle-fill" style="font-size:1.2rem"></i>{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.otp.send') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                    <i class="bi bi-envelope icon"></i>
                </div>
            </div>
            <button type="submit" class="btn-primary"><i class="bi bi-send-fill me-2"></i>Send OTP</button>
        </form>

        <a href="{{ route('login') }}" class="back-link"><i class="bi bi-arrow-left"></i> Back to Sign In</a>
        <div class="footer">&copy; {{ date('Y') }} EMS Portal</div>
    </div>
</body>
</html>
