<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Kedai Cap Tiga Buaya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background-color: #f8fafc;
            color: #1e293b;
            display: flex;
            overflow-x: hidden;
        }

        .login-container {
            display: flex;
            width: 100vw;
            min-height: 100vh;
        }

        /* ---------------- LEFT PANEL (ORIGINAL IMAGE) ---------------- */
        .brand-panel {
            flex: 1.15;
            background-color: #0b2214;
            background-image: 
                linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1)),
                url("{{ asset('images/hero-bg.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            padding: 40px 48px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .brand-top {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .brand-logo-img {
            height: 60px;
            width: auto;
            object-fit: contain;
        }

        .brand-name-wrap {
            color: #ffffff;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6);
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 1px;
            line-height: 1.15;
            text-transform: uppercase;
        }

        .brand-tagline {
            font-size: 11.5px;
            color: #86efac;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-weight: 600;
            margin-top: 3px;
        }

        /* ---------------- RIGHT PANEL (FORM) ---------------- */
        .form-panel {
            flex: 0.95;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px 70px;
            position: relative;
            overflow-y: auto;
        }

        .form-content {
            max-width: 420px;
            width: 100%;
            margin-top: 10px;
            align-self: center;
        }

        /* Logo di pojok kanan atas */
        .form-logo-top-right {
            position: absolute;
            top: 36px;
            right: 48px;
            display: flex;
            align-items: center;
        }

        .form-logo-img {
            max-width: 100px;
            height: auto;
            max-height: 48px;
            object-fit: contain;
            display: block;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            color: #16241b;
            margin-bottom: 6px;
        }

        .form-subtitle {
            font-size: 13.5px;
            color: #64748b;
            font-weight: 400;
            margin-bottom: 24px;
            line-height: 1.45;
        }

        /* Form Inputs */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            color: #475569;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            font-size: 14.5px;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .form-input {
            width: 100%;
            padding: 13px 14px 13px 42px;
            background-color: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: #1e293b;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .form-input:focus {
            background-color: #ffffff;
            border-color: #1f5133;
            box-shadow: 0 0 0 3px rgba(31, 81, 51, 0.12);
        }

        .form-input:focus + .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: #1f5133;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 15px;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
        }

        .toggle-password:hover {
            color: #475569;
        }

        /* Remember device */
        .remember-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 22px 0 26px;
            user-select: none;
        }

        .remember-checkbox {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 1.5px solid #cbd5e1;
            border-radius: 4px;
            background-color: #f8fafc;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
            display: grid;
            place-content: center;
        }

        .remember-checkbox:checked {
            background-color: #1f5133;
            border-color: #1f5133;
        }

        .remember-checkbox:checked::after {
            content: "\f00c";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            font-size: 10px;
            color: #ffffff;
        }

        .remember-checkbox:focus {
            outline: 2px solid rgba(31, 81, 51, 0.3);
            outline-offset: 1px;
        }

        .remember-label {
            font-size: 13.5px;
            color: #475569;
            cursor: pointer;
            font-weight: 500;
        }

        /* Button */
        .btn-submit {
            width: 100%;
            background-color: #1f5133;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 14px 20px;
            font-size: 14.5px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(31, 81, 51, 0.25);
        }

        .btn-submit:hover {
            background-color: #174229;
            box-shadow: 0 6px 16px rgba(31, 81, 51, 0.35);
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit i {
            transition: transform 0.2s ease;
            font-size: 13px;
        }

        .btn-submit:hover i {
            transform: translateX(3px);
        }

        .form-footer-note {
            margin-top: 36px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .brand-panel {
                display: none;
            }

            .form-panel {
                flex: 1;
                padding: 40px 24px;
                justify-content: center;
            }

            .form-content {
                margin: 0 auto;
            }

            .form-panel-top {
                position: absolute;
                top: 24px;
                right: 24px;
                margin-bottom: 0;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        
        <!-- LEFT PANEL (Brand & Showcase) -->
        <div class="brand-panel"></div>

        <!-- RIGHT PANEL (Login Form) -->
        <div class="form-panel">
            <!-- Logo di Pojok Kanan Atas -->
            <div class="form-logo-top-right">
                <img src="{{ asset('images/logo.png') }}?v={{ filemtime(public_path('images/logo.png')) }}" alt="Logo Kedai Cap Tiga Buaya" class="form-logo-img">
            </div>

            <div class="form-content">
                <h1 class="form-title">Login Admin</h1>
                <p class="form-subtitle">Silakan masuk untuk mengelola Kedai</p>

                @if ($errors->any())
                    <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 12px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                @if (session('success'))
                    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; padding: 12px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('admin.login.submit') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="username" class="form-label">USERNAME ATAU EMAIL</label>
                        <div class="input-wrapper">
                            <input 
                                type="text" 
                                id="username" 
                                name="username" 
                                class="form-input" 
                                placeholder="admin@kedaibuaya.id" 
                                required 
                                autocomplete="username"
                            >
                            <i class="fa-regular fa-user input-icon"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">KATA SANDI</label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-input" 
                                placeholder="••••••••" 
                                required 
                                autocomplete="current-password"
                                style="padding-right: 42px;"
                            >
                            <i class="fa-solid fa-lock input-icon"></i>
                            <button type="button" class="toggle-password" id="togglePasswordBtn" aria-label="Tampilkan atau sembunyikan kata sandi">
                                <i class="fa-regular fa-eye" id="passwordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <span>Masuk ke Dashboard</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

    </div>

    <script>
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('passwordIcon');

        if (togglePasswordBtn && passwordInput && passwordIcon) {
            togglePasswordBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                
                if (isPassword) {
                    passwordIcon.classList.remove('fa-eye');
                    passwordIcon.classList.add('fa-eye-slash');
                } else {
                    passwordIcon.classList.remove('fa-eye-slash');
                    passwordIcon.classList.add('fa-eye');
                }
            });
        }
    </script>
</body>
</html>
