<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS — Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter',sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#0f0c29 0%,#302b63 50%,#24243e 100%);padding:20px;position:relative;overflow:hidden}
        .bg-orb{position:fixed;border-radius:50%;pointer-events:none;filter:blur(60px)}
        .bg-orb-1{width:500px;height:500px;background:rgba(245,158,11,.12);top:-150px;right:-100px;animation:drift 12s ease-in-out infinite}
        .bg-orb-2{width:400px;height:400px;background:rgba(99,102,241,.1);bottom:-100px;left:-80px;animation:drift 10s ease-in-out infinite reverse}
        @keyframes drift{0%,100%{transform:translate(0,0)}50%{transform:translate(30px,-20px)}}

        .card{width:100%;max-width:460px;background:#fff;border-radius:28px;padding:48px 40px;position:relative;overflow:hidden;box-shadow:0 25px 80px rgba(0,0,0,.35);animation:rise .6s ease}
        @keyframes rise{from{opacity:0;transform:translateY(30px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
        .card::before{content:'';position:absolute;top:0;left:0;right:0;height:5px;background:linear-gradient(90deg,#f59e0b,#fbbf24,#fcd34d)}

        .step-dots{display:flex;justify-content:center;gap:8px;margin-bottom:28px}
        .step-dot{width:10px;height:10px;border-radius:50%;background:#e5e7eb;transition:all .3s}
        .step-dot.done{background:#10b981}
        .step-dot.active{background:#f59e0b;width:28px;border-radius:5px}

        .icon-box{width:76px;height:76px;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:22px;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;box-shadow:0 12px 40px rgba(245,158,11,.3)}
        .icon-box i{font-size:34px;color:#fff}

        h2{text-align:center;font-size:1.65rem;font-weight:800;color:#1e1b4b;margin-bottom:8px}
        .subtitle{text-align:center;color:#64748b;font-size:.9rem;margin-bottom:10px;line-height:1.6}
        .email-badge{display:flex;align-items:center;justify-content:center;gap:6px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:8px 16px;font-size:.85rem;color:#6366f1;font-weight:600;margin:0 auto 28px;width:fit-content}

        .otp-inputs{display:flex;gap:10px;justify-content:center;margin-bottom:28px}
        .otp-inputs input{width:52px;height:60px;text-align:center;font-size:1.5rem;font-weight:800;font-family:'Inter',sans-serif;border:2px solid #e5e7eb;border-radius:14px;background:#f9fafb;color:#1e1b4b;transition:all .3s;caret-color:#6366f1}
        .otp-inputs input:focus{outline:none;border-color:#f59e0b;background:#fff;box-shadow:0 0 0 4px rgba(245,158,11,.12);transform:translateY(-2px)}
        .otp-inputs input.filled{border-color:#10b981;background:#f0fdf4}
        .otp-inputs input.is-invalid{border-color:#ef4444;animation:shake .5s}
        @keyframes shake{0%,100%{transform:translateX(0)}20%,60%{transform:translateX(-4px)}40%,80%{transform:translateX(4px)}}

        .alert-box{padding:14px 18px;border-radius:14px;font-size:.85rem;margin-bottom:20px;display:flex;align-items:center;gap:10px}
        .alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
        .alert-success{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}

        .timer{text-align:center;color:#94a3b8;font-size:.82rem;margin-bottom:24px}
        .timer strong{color:#f59e0b}

        .btn-primary{width:100%;padding:16px;border:none;border-radius:14px;font-size:1rem;font-weight:700;font-family:'Inter',sans-serif;color:#fff;background:linear-gradient(135deg,#f59e0b,#d97706);cursor:pointer;transition:all .3s}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 12px 40px rgba(245,158,11,.4)}

        .resend-link{display:block;text-align:center;margin-top:20px;font-size:.85rem;color:#64748b}
        .resend-link a{color:#6366f1;text-decoration:none;font-weight:600}
        .resend-link a:hover{text-decoration:underline}

        .back-link{display:flex;align-items:center;justify-content:center;gap:6px;margin-top:16px;font-size:.85rem;color:#6366f1;text-decoration:none;font-weight:600;transition:all .3s}
        .back-link:hover{color:#4f46e5;gap:10px}
        .footer{text-align:center;margin-top:24px;color:#94a3b8;font-size:.78rem}

        /* Hidden real input */
        .hidden-input{position:absolute;opacity:0;pointer-events:none}
    </style>
</head>
<body>
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>

    <div class="card">
        <div class="step-dots">
            <span class="step-dot done"></span>
            <span class="step-dot active"></span>
            <span class="step-dot"></span>
        </div>

        <div class="icon-box"><i class="bi bi-shield-lock-fill"></i></div>
        <h2>Enter OTP</h2>
        <p class="subtitle">We've sent a 6-digit code to</p>
        <div class="email-badge"><i class="bi bi-envelope-check"></i> {{ $email }}</div>

        @if($errors->any())
            <div class="alert-box alert-error"><i class="bi bi-exclamation-circle-fill" style="font-size:1.1rem"></i>{{ $errors->first() }}</div>
        @endif
        @if(session('success'))
            <div class="alert-box alert-success"><i class="bi bi-check-circle-fill" style="font-size:1.1rem"></i>{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('password.otp.verify') }}" id="otpForm">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="otp" id="otpHidden" value="">

            <div class="otp-inputs" id="otpBox">
                <input type="text" maxlength="1" class="otp-digit" data-index="0" inputmode="numeric" autofocus>
                <input type="text" maxlength="1" class="otp-digit" data-index="1" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-digit" data-index="2" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-digit" data-index="3" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-digit" data-index="4" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-digit" data-index="5" inputmode="numeric">
            </div>

            <div class="timer"><i class="bi bi-clock"></i> OTP valid for <strong id="countdown">10:00</strong></div>

            <button type="submit" class="btn-primary" id="verifyBtn" disabled>
                <i class="bi bi-check2-circle me-2"></i>Verify OTP
            </button>
        </form>

        <p class="resend-link">Didn't receive code? <a href="{{ route('password.otp.forgot') }}">Resend OTP</a></p>
        <a href="{{ route('login') }}" class="back-link"><i class="bi bi-arrow-left"></i> Back to Sign In</a>
        <div class="footer">&copy; {{ date('Y') }} EMS Portal</div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const digits = document.querySelectorAll('.otp-digit');
        const hidden = document.getElementById('otpHidden');
        const btn = document.getElementById('verifyBtn');

        function updateOtp() {
            let val = '';
            digits.forEach(d => val += d.value);
            hidden.value = val;
            btn.disabled = val.length !== 6;
            if (val.length === 6) btn.style.opacity = '1';
            else btn.style.opacity = '0.6';
        }

        digits.forEach((input, idx) => {
            input.addEventListener('input', function(e) {
                this.value = this.value.replace(/\D/g, '').slice(0,1);
                if (this.value) {
                    this.classList.add('filled');
                    if (idx < 5) digits[idx + 1].focus();
                } else {
                    this.classList.remove('filled');
                }
                updateOtp();
            });
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && idx > 0) {
                    digits[idx - 1].focus();
                    digits[idx - 1].value = '';
                    digits[idx - 1].classList.remove('filled');
                    updateOtp();
                }
            });
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0,6);
                paste.split('').forEach((ch, i) => {
                    if (digits[i]) { digits[i].value = ch; digits[i].classList.add('filled'); }
                });
                if (digits[paste.length-1]) digits[Math.min(paste.length, 5)].focus();
                updateOtp();
            });
        });

        // Countdown
        let time = 600;
        const cd = document.getElementById('countdown');
        const timer = setInterval(() => {
            time--;
            const m = Math.floor(time/60), s = time%60;
            cd.textContent = m + ':' + String(s).padStart(2,'0');
            if (time <= 60) cd.style.color = '#ef4444';
            if (time <= 0) { clearInterval(timer); cd.textContent = 'Expired'; btn.disabled = true; }
        }, 1000);

        btn.style.opacity = '0.6';
    });
    </script>
</body>
</html>
