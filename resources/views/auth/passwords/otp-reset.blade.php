<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS — Set New Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter',sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#0f0c29 0%,#302b63 50%,#24243e 100%);padding:20px;position:relative;overflow:hidden}
        .bg-orb{position:fixed;border-radius:50%;pointer-events:none;filter:blur(60px)}
        .bg-orb-1{width:500px;height:500px;background:rgba(16,185,129,.15);top:-150px;left:-100px;animation:drift 12s ease-in-out infinite}
        .bg-orb-2{width:400px;height:400px;background:rgba(5,150,105,.1);bottom:-100px;right:-80px;animation:drift 10s ease-in-out infinite reverse}
        @keyframes drift{0%,100%{transform:translate(0,0)}50%{transform:translate(30px,-20px)}}

        .card{width:100%;max-width:460px;background:#fff;border-radius:28px;padding:44px 40px;position:relative;overflow:hidden;box-shadow:0 25px 80px rgba(0,0,0,.35);animation:rise .6s ease}
        @keyframes rise{from{opacity:0;transform:translateY(30px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
        .card::before{content:'';position:absolute;top:0;left:0;right:0;height:5px;background:linear-gradient(90deg,#10b981,#34d399,#6ee7b7)}

        .step-dots{display:flex;justify-content:center;gap:8px;margin-bottom:28px}
        .step-dot{width:10px;height:10px;border-radius:50%;background:#e5e7eb;transition:all .3s}
        .step-dot.done{background:#10b981}
        .step-dot.active{background:#10b981;width:28px;border-radius:5px}

        .icon-box{width:76px;height:76px;background:linear-gradient(135deg,#10b981,#059669);border-radius:22px;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;box-shadow:0 12px 40px rgba(16,185,129,.3)}
        .icon-box i{font-size:34px;color:#fff}

        h2{text-align:center;font-size:1.65rem;font-weight:800;color:#1e1b4b;margin-bottom:8px}
        .subtitle{text-align:center;color:#64748b;font-size:.9rem;margin-bottom:32px}

        .form-group{margin-bottom:22px}
        .form-group label{display:block;font-size:.85rem;font-weight:600;color:#374151;margin-bottom:8px;transition:color .3s}
        .input-wrap{position:relative}
        .input-wrap input{width:100%;padding:15px 50px 15px 50px;border:2px solid #e5e7eb;border-radius:14px;font-size:.95rem;font-family:'Inter',sans-serif;color:#1f2937;transition:all .3s;background:#f9fafb}
        .input-wrap input:focus{outline:none;border-color:#10b981;background:#fff;box-shadow:0 0 0 4px rgba(16,185,129,.1)}
        .input-wrap input.is-invalid{border-color:#ef4444}
        .input-wrap .icon{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:1.15rem;transition:color .3s}
        .input-wrap input:focus~.icon{color:#10b981}
        .toggle-pw{position:absolute;right:16px;top:50%;transform:translateY(-50%);background:none;border:none;color:#9ca3af;cursor:pointer;font-size:1.15rem;transition:color .3s}
        .toggle-pw:hover{color:#10b981}
        .error-msg{color:#ef4444;font-size:.8rem;margin-top:6px;font-weight:500}

        .alert-box{padding:14px 18px;border-radius:14px;font-size:.85rem;margin-bottom:20px;display:flex;align-items:center;gap:10px;background:#fef2f2;color:#991b1b;border:1px solid #fecaca}

        .strength-wrap{margin-top:8px}
        .strength-bar{height:4px;border-radius:2px;background:#e5e7eb;overflow:hidden}
        .strength-fill{height:100%;border-radius:2px;transition:all .4s;width:0}
        .strength-text{font-size:.72rem;font-weight:600;margin-top:4px;text-align:right}

        .match-msg{font-size:.75rem;font-weight:600;margin-top:6px}

        .btn-primary{width:100%;padding:16px;border:none;border-radius:14px;font-size:1rem;font-weight:700;font-family:'Inter',sans-serif;color:#fff;background:linear-gradient(135deg,#10b981,#059669);cursor:pointer;transition:all .3s;margin-top:4px}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 12px 40px rgba(16,185,129,.4)}
        .footer{text-align:center;margin-top:28px;color:#94a3b8;font-size:.78rem}
    </style>
</head>
<body>
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>

    <div class="card">
        <div class="step-dots">
            <span class="step-dot done"></span>
            <span class="step-dot done"></span>
            <span class="step-dot active"></span>
        </div>

        <div class="icon-box"><i class="bi bi-key-fill"></i></div>
        <h2>Set New Password</h2>
        <p class="subtitle">Create a strong password for your account</p>

        @if($errors->any())
            <div class="alert-box"><i class="bi bi-exclamation-circle-fill" style="font-size:1.1rem"></i>{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.otp.reset') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="password">New Password</label>
                <div class="input-wrap">
                    <input id="password" type="password" name="password" required placeholder="Min. 8 characters" class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                    <i class="bi bi-lock icon"></i>
                    <button type="button" class="toggle-pw" onclick="togglePw('password','t1')"><i class="bi bi-eye" id="t1"></i></button>
                </div>
                <div class="strength-wrap">
                    <div class="strength-bar"><div class="strength-fill" id="sFill"></div></div>
                    <div class="strength-text" id="sText"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <div class="input-wrap">
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Re-enter password">
                    <i class="bi bi-lock-fill icon"></i>
                    <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation','t2')"><i class="bi bi-eye" id="t2"></i></button>
                </div>
                <div class="match-msg" id="matchMsg"></div>
            </div>

            <button type="submit" class="btn-primary"><i class="bi bi-check-circle-fill me-2"></i>Reset Password</button>
        </form>

        <div class="footer">&copy; {{ date('Y') }} EMS Portal</div>
    </div>

    <script>
    function togglePw(id,iconId){const i=document.getElementById(id),ic=document.getElementById(iconId);if(i.type==='password'){i.type='text';ic.classList.replace('bi-eye','bi-eye-slash')}else{i.type='password';ic.classList.replace('bi-eye-slash','bi-eye')}}

    document.getElementById('password').addEventListener('input',function(){
        const v=this.value,f=document.getElementById('sFill'),t=document.getElementById('sText');
        let s=0;if(v.length>=8)s++;if(/[a-z]/.test(v)&&/[A-Z]/.test(v))s++;if(/[0-9]/.test(v))s++;if(/[^a-zA-Z0-9]/.test(v))s++;
        const l=[{w:'0%',c:'#e5e7eb',l:''},{w:'25%',c:'#ef4444',l:'Weak'},{w:'50%',c:'#f59e0b',l:'Fair'},{w:'75%',c:'#06b6d4',l:'Good'},{w:'100%',c:'#10b981',l:'Strong'}][s];
        f.style.width=l.w;f.style.background=l.c;t.style.color=l.c;t.textContent=v.length>0?l.l:'';
    });

    document.getElementById('password_confirmation').addEventListener('input',function(){
        const pw=document.getElementById('password').value,m=document.getElementById('matchMsg');
        if(!this.value){m.textContent='';return}
        if(this.value===pw){m.textContent='✓ Passwords match';m.style.color='#10b981'}
        else{m.textContent='✗ Passwords don\'t match';m.style.color='#ef4444'}
    });

    document.querySelectorAll('.input-wrap input').forEach(i=>{
        i.addEventListener('focus',function(){this.closest('.form-group').querySelector('label').style.color='#10b981'});
        i.addEventListener('blur',function(){this.closest('.form-group').querySelector('label').style.color='#374151'});
    });
    </script>
</body>
</html>
