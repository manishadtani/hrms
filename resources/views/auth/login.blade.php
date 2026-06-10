<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS — Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            overflow: hidden;
        }

        /* Left Panel — Branding */
        .brand-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.3) 0%, transparent 70%);
            top: -100px;
            left: -100px;
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        .brand-panel::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.2) 0%, transparent 70%);
            bottom: -50px;
            right: -50px;
            border-radius: 50%;
            animation: float 6s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        .brand-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }

        .brand-icon {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 20px 60px rgba(99, 102, 241, 0.4);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 20px 60px rgba(99, 102, 241, 0.4); }
            50% { box-shadow: 0 25px 80px rgba(99, 102, 241, 0.6); }
        }

        .brand-icon i {
            font-size: 40px;
            color: white;
        }

        .brand-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #fff 0%, #c4b5fd 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-content p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.6);
            max-width: 400px;
            line-height: 1.7;
        }

        .feature-list {
            margin-top: 40px;
            text-align: left;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 18px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
        }

        .feature-item .icon-box {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-item:nth-child(1) .icon-box { background: rgba(99, 102, 241, 0.2); color: #818cf8; }
        .feature-item:nth-child(2) .icon-box { background: rgba(16, 185, 129, 0.2); color: #34d399; }
        .feature-item:nth-child(3) .icon-box { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
        .feature-item:nth-child(4) .icon-box { background: rgba(236, 72, 153, 0.2); color: #f472b6; }

        /* Right Panel — Login Form */
        .login-panel {
            width: 520px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            background: #ffffff;
            position: relative;
        }

        .login-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #6366f1, #8b5cf6, #a78bfa);
        }

        .login-header {
            margin-bottom: 40px;
        }

        .login-header .welcome-back {
            font-size: 0.85rem;
            font-weight: 600;
            color: #6366f1;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }

        .login-header h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #1e1b4b;
            letter-spacing: -0.5px;
        }

        .login-header p {
            color: #64748b;
            margin-top: 8px;
            font-size: 0.95rem;
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }

        .input-wrapper {
            position: relative;
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
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .input-wrapper input:focus + .input-icon,
        .input-wrapper input:focus ~ .input-icon {
            color: #6366f1;
        }

        .input-wrapper input.is-invalid {
            border-color: #ef4444;
        }

        .input-wrapper input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
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

        .toggle-password:hover {
            color: #6366f1;
        }

        .invalid-feedback {
            display: block;
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 6px;
            font-weight: 500;
        }

        /* Remember & Forgot */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .form-check-input:checked {
            background-color: #6366f1;
            border-color: #6366f1;
        }

        .form-check-label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
        }

        .forgot-link {
            font-size: 0.85rem;
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: #4f46e5;
        }

        /* ═══════ Swipe-to-Login Button ═══════ */
        .swipe-container {
            width: 100%;
            height: 62px;
            border-radius: 16px;
            background: linear-gradient(135deg, #1e1b4b, #312e81);
            position: relative;
            overflow: hidden;
            user-select: none;
            -webkit-user-select: none;
            touch-action: none;
            box-shadow: 0 4px 20px rgba(30, 27, 75, 0.3);
            transition: box-shadow 0.3s;
        }

        .swipe-container:hover {
            box-shadow: 0 8px 35px rgba(99, 102, 241, 0.4);
        }

        /* Track background fill as you drag */
        .swipe-track-fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 16px;
            transition: width 0.1s ease-out;
        }

        /* Shimmer sweep on the track */
        .swipe-shimmer {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.08) 40%, rgba(255,255,255,0.15) 50%, rgba(255,255,255,0.08) 60%, transparent 100%);
            animation: shimmerSweep 3s ease-in-out infinite;
        }

        @keyframes shimmerSweep {
            0% { left: -100%; }
            50% { left: 100%; }
            100% { left: 100%; }
        }

        /* Text label */
        .swipe-label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            pointer-events: none;
            transition: opacity 0.3s, transform 0.3s;
            white-space: nowrap;
        }

        .swipe-label .arrows {
            display: inline-block;
            animation: arrowPulse 1.5s ease-in-out infinite;
            margin-left: 6px;
        }

        @keyframes arrowPulse {
            0%, 100% { transform: translateX(0); opacity: 0.5; }
            50% { transform: translateX(6px); opacity: 1; }
        }

        /* Draggable knob */
        .swipe-knob {
            position: absolute;
            top: 5px;
            left: 5px;
            width: 52px;
            height: 52px;
            border-radius: 13px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: grab;
            z-index: 5;
            transition: left 0.15s ease-out, transform 0.2s, background 0.4s, width 0.5s;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.5);
        }

        .swipe-knob:active {
            cursor: grabbing;
            transform: scale(1.05);
        }

        .swipe-knob i {
            font-size: 1.4rem;
            color: white;
            transition: transform 0.3s;
        }

        .swipe-knob:active i {
            transform: translateX(2px);
        }

        /* Success state */
        .swipe-container.swiped .swipe-track-fill {
            width: 100% !important;
            background: linear-gradient(135deg, #059669, #10b981);
            transition: width 0.4s ease, background 0.3s;
        }

        .swipe-container.swiped .swipe-knob {
            background: linear-gradient(135deg, #059669, #10b981);
            width: calc(100% - 10px);
            border-radius: 13px;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.5);
        }

        .swipe-container.swiped .swipe-label {
            opacity: 0;
            transform: translate(-50%, -50%) scale(0.8);
        }

        .swipe-container.swiped .swipe-shimmer {
            animation: none;
            opacity: 0;
        }

        /* Success text */
        .swipe-success {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 1px;
            opacity: 0;
            z-index: 6;
            pointer-events: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: opacity 0.3s 0.2s;
        }

        .swipe-container.swiped .swipe-success {
            opacity: 1;
        }

        .swipe-success .checkmark {
            width: 22px;
            height: 22px;
            border: 2px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: checkPop 0.4s ease 0.3s both;
        }

        @keyframes checkPop {
            0% { transform: scale(0) rotate(-45deg); }
            60% { transform: scale(1.2) rotate(0deg); }
            100% { transform: scale(1) rotate(0deg); }
        }

        /* Ripple on release */
        .swipe-ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: scale(0);
            animation: rippleOut 0.6s ease-out forwards;
            pointer-events: none;
            z-index: 4;
        }

        @keyframes rippleOut {
            to { transform: scale(4); opacity: 0; }
        }

        /* Hidden submit */
        .btn-login-hidden {
            display: none;
        }

        /* Footer */
        .login-footer {
            margin-top: 30px;
            text-align: center;
            color: #94a3b8;
            font-size: 0.8rem;
        }

        /* Alert styling */
        .alert-modern {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.85rem;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-modern.alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-modern.alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        /* Responsive */
        @media (max-width: 992px) {
            body { flex-direction: column; }
            .brand-panel {
                padding: 40px 30px;
                min-height: auto;
            }
            .brand-content h1 { font-size: 1.8rem; }
            .feature-list { display: none; }
            .login-panel {
                width: 100%;
                padding: 40px 30px;
                min-height: auto;
            }
            .login-panel::before { display: none; }
        }

        @media (max-width: 576px) {
            .brand-panel { padding: 30px 20px; }
            .login-panel { padding: 30px 20px; }
            .login-header h2 { font-size: 1.5rem; }
        }

        /* Floating particles */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: rise linear infinite;
        }

        @keyframes rise {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            20% { opacity: 1; }
            100% { transform: translateY(-10vh) scale(1); opacity: 0; }
        }
    </style>
</head>
<body>

    <!-- Left Brand Panel -->
    <div class="brand-panel d-none d-lg-flex">
        <div class="particles" id="particles"></div>
        <div class="brand-content">
            <div class="brand-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <h1>EMS Portal</h1>
            <p>Streamline your workforce management with our comprehensive Employee Management System</p>

            <div class="feature-list">
                <div class="feature-item">
                    <div class="icon-box"><i class="bi bi-shield-check"></i></div>
                    <span>Role-Based Access Control</span>
                </div>
                <div class="feature-item">
                    <div class="icon-box"><i class="bi bi-clock-history"></i></div>
                    <span>Real-Time Attendance Tracking</span>
                </div>
                <div class="feature-item">
                    <div class="icon-box"><i class="bi bi-calendar-check"></i></div>
                    <span>Smart Leave Management</span>
                </div>
                <div class="feature-item">
                    <div class="icon-box"><i class="bi bi-graph-up-arrow"></i></div>
                    <span>Detailed Reports & Analytics</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Login Panel -->
    <div class="login-panel">
        <!-- Mobile brand (visible on small screens) -->
        <div class="d-lg-none text-center mb-4">
            <div class="brand-icon mx-auto" style="width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;box-shadow:0 10px 30px rgba(99,102,241,0.3);">
                <i class="bi bi-people-fill" style="font-size:28px;color:#fff;"></i>
            </div>
            <h4 class="mt-3 fw-bold" style="color:#1e1b4b;">EMS Portal</h4>
        </div>

        <div class="login-header">
            <div class="welcome-back">Welcome Back</div>
            <h2>Sign in to your account</h2>
            <p>Enter your credentials to access the dashboard</p>
        </div>

        <!-- Flash Messages -->
        @if(session('status'))
            <div class="alert-modern alert-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('status') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-modern alert-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert-modern alert-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <input id="email" type="email"
                           class="@error('email') is-invalid @enderror"
                           name="email"
                           value="{{ old('email') }}"
                           required autocomplete="email" autofocus
                           placeholder="you@company.com">
                    <i class="bi bi-envelope input-icon"></i>
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input id="password" type="password"
                           class="@error('password') is-invalid @enderror"
                           name="password"
                           required autocomplete="current-password"
                           placeholder="Enter your password">
                    <i class="bi bi-lock input-icon"></i>
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember & Forgot -->
            <div class="form-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.otp.forgot') }}" class="forgot-link">Forgot password?</a>
                @endif
            </div>

            <!-- Swipe to Login -->
            <div class="swipe-container" id="swipeContainer">
                <div class="swipe-track-fill" id="swipeTrackFill"></div>
                <div class="swipe-shimmer"></div>
                <div class="swipe-label">Slide to Sign In <span class="arrows">→</span></div>
                <div class="swipe-knob" id="swipeKnob">
                    <i class="bi bi-arrow-right"></i>
                </div>
                <div class="swipe-success">
                    <span class="checkmark"><i class="bi bi-check" style="font-size:14px;"></i></span>
                    Signing you in...
                </div>
            </div>
            <button type="submit" class="btn-login-hidden" id="hiddenSubmit">Sign In</button>
        </form>

        <div class="login-footer">
            <p>&copy; {{ date('Y') }} Employee Management System. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        // Generate floating particles
        function createParticles() {
            const container = document.getElementById('particles');
            if (!container) return;
            for (let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                particle.style.left = Math.random() * 100 + '%';
                particle.style.width = particle.style.height = (Math.random() * 6 + 3) + 'px';
                particle.style.animationDuration = (Math.random() * 10 + 8) + 's';
                particle.style.animationDelay = (Math.random() * 5) + 's';
                container.appendChild(particle);
            }
        }
        createParticles();

        // Input focus animation
        document.querySelectorAll('.input-wrapper input').forEach(input => {
            input.addEventListener('focus', function() {
                this.closest('.form-group').querySelector('label').style.color = '#6366f1';
            });
            input.addEventListener('blur', function() {
                this.closest('.form-group').querySelector('label').style.color = '#374151';
            });
        });

        // ═══════ Swipe-to-Login Logic ═══════
        (function() {
            const container = document.getElementById('swipeContainer');
            const knob = document.getElementById('swipeKnob');
            const trackFill = document.getElementById('swipeTrackFill');
            const hiddenSubmit = document.getElementById('hiddenSubmit');

            let isDragging = false;
            let startX = 0;
            let currentX = 0;
            let knobWidth = 52;
            let containerPadding = 5;
            let swiped = false;

            function getMaxX() {
                return container.offsetWidth - knobWidth - (containerPadding * 2);
            }

            function handleStart(e) {
                if (swiped) return;
                isDragging = true;
                startX = (e.touches ? e.touches[0].clientX : e.clientX) - currentX;
                knob.style.transition = 'none';
                trackFill.style.transition = 'none';
            }

            function handleMove(e) {
                if (!isDragging || swiped) return;
                e.preventDefault();

                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                let x = clientX - startX;
                const maxX = getMaxX();

                x = Math.max(0, Math.min(x, maxX));
                currentX = x;

                knob.style.left = (containerPadding + x) + 'px';
                trackFill.style.width = (x + knobWidth + containerPadding) + 'px';

                // Change knob icon based on progress
                const progress = x / maxX;
                const icon = knob.querySelector('i');
                if (progress > 0.85) {
                    icon.className = 'bi bi-check-lg';
                    icon.style.transform = 'scale(1.2)';
                } else {
                    icon.className = 'bi bi-arrow-right';
                    icon.style.transform = 'none';
                }
            }

            function handleEnd() {
                if (!isDragging || swiped) return;
                isDragging = false;

                const maxX = getMaxX();
                const progress = currentX / maxX;

                knob.style.transition = 'left 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), transform 0.2s, background 0.4s, width 0.5s';
                trackFill.style.transition = 'width 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';

                if (progress > 0.75) {
                    // SUCCESS — swipe complete!
                    swiped = true;
                    currentX = maxX;
                    container.classList.add('swiped');

                    // Ripple effect
                    const ripple = document.createElement('div');
                    ripple.className = 'swipe-ripple';
                    ripple.style.width = ripple.style.height = '60px';
                    ripple.style.left = (maxX + containerPadding + knobWidth/2 - 30) + 'px';
                    ripple.style.top = '1px';
                    container.appendChild(ripple);

                    // Submit form after animation
                    setTimeout(() => {
                        hiddenSubmit.click();
                    }, 800);
                } else {
                    // SNAP BACK — not swiped enough
                    currentX = 0;
                    knob.style.left = containerPadding + 'px';
                    trackFill.style.width = '0px';

                    const icon = knob.querySelector('i');
                    icon.className = 'bi bi-arrow-right';
                    icon.style.transform = 'none';

                    // Bounce effect on snap back
                    knob.style.transition = 'left 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55), transform 0.2s';
                }
            }

            // Mouse events
            knob.addEventListener('mousedown', handleStart);
            window.addEventListener('mousemove', handleMove);
            window.addEventListener('mouseup', handleEnd);

            // Touch events
            knob.addEventListener('touchstart', handleStart, { passive: true });
            window.addEventListener('touchmove', handleMove, { passive: false });
            window.addEventListener('touchend', handleEnd);

            // Prevent drag ghost image
            knob.addEventListener('dragstart', e => e.preventDefault());
        })();
    </script>
</body>
</html>
