<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #1a73e8;
            --primary-light: #6c8ef5;
            --secondary-color: #34a853;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #e0f7fa 0%, #bbdefb 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
        }

        .welcome-section {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo-header .logo {
            margin-right: 15px;
        }

        .app-name {
            font-size: 24px;
            font-weight: 700;
        }

        .app-tagline {
            font-size: 14px;
            opacity: 0.9;
        }

        .features {
            margin: 30px 0;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .feature-item i {
            margin-right: 10px;
            background: rgba(255, 255, 255, 0.2);
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .auth-section {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-tabs {
            display: flex;
            margin-bottom: 25px;
            border-bottom: 2px solid #eee;
        }

        .auth-tab {
            padding: 12px 20px;
            cursor: pointer;
            font-weight: 600;
            color: #666;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }

        .auth-tab.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .auth-content {
            display: none;
        }

        .auth-content.active {
            display: block;
        }

        .auth-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .auth-subtitle {
            color: #666;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"],
        input[type="tel"],
        input[type="date"],
        select {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
        }

        select {
            appearance: none;
            background: white;
        }

        .select-arrow {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            pointer-events: none;
        }

        input:focus,
        select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
            outline: none;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
            font-size: 14px;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            margin-right: 8px;
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .auth-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 115, 232, 0.3);
        }

        .auth-switch {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .auth-switch a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-switch a:hover {
            text-decoration: underline;
        }

        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            margin: 20px 0;
            font-size: 14px;
        }

        .terms-checkbox input {
            margin-right: 10px;
            margin-top: 3px;
        }

        .terms-checkbox a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .terms-checkbox a:hover {
            text-decoration: underline;
        }

        .gender-options {
            display: flex;
            gap: 15px;
            margin-top: 5px;
        }

        .gender-option {
            display: flex;
            align-items: center;
        }

        .gender-option input {
            margin-right: 5px;
        }

        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            border-radius: 50%;
            background: var(--primary-color);
        }

        .shape-1 {
            width: 150px;
            height: 150px;
            top: 10%;
            left: 5%;
            animation: float 25s infinite linear;
        }

        .shape-2 {
            width: 100px;
            height: 100px;
            top: 60%;
            right: 10%;
            animation: float 20s infinite linear reverse;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }

            100% {
                transform: translate(100px, 50px) rotate(360deg);
            }
        }

        /* Error messages */
        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }

        .password-requirements {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .auth-card {
                flex-direction: column;
                max-width: 100%;
                margin: 0 10px;
            }

            .welcome-section,
            .auth-section {
                padding: 30px 25px;
            }

            .logo-header {
                justify-content: center;
                text-align: center;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>

<body>
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    <div class="auth-container">
        <div class="auth-card">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <div class="logo-header">
                    <div class="logo">
                        <x-application-logo class="w-16 h-16 fill-current text-white" />
                    </div>
                    <div>
                        <div class="app-name">Toko Alert Kesehatan</div>
                        <div class="app-tagline">Selamat datang di Toko Alat Kesehatan</div>
                    </div>
                </div>

                <div class="features">
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Transaksi Aman dengan SSL</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shipping-fast"></i>
                        <span>Gratis Ongkir untuk Area Tertentu</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-headset"></i>
                        <span>Customer Service 24/7</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-pills"></i>
                        <span>Produk Kesehatan Berkualitas</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-tags"></i>
                        <span>Harga Terjangkau</span>
                    </div>
                </div>

                <div style="margin-top: 30px; font-size: 13px; opacity: 0.8;">
                    <p>Bergabunglah dengan ribuan pelanggan yang telah mempercayai kami untuk kebutuhan kesehatan
                        mereka.</p>
                </div>
            </div>

            <!-- Auth Section -->
            <div class="auth-section">
                <div class="auth-tabs">
                    <div class="auth-tab active" data-tab="login">Login</div>
                    <div class="auth-tab" data-tab="register">Daftar</div>
                </div>

                <!-- Login Form -->
                <div class="auth-content active" id="login-content">
                    <h2 class="auth-title">LOGIN</h2>
                    <p class="auth-subtitle">Masuk ke akun Anda</p>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 text-sm font-medium text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Use ID (Email) -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-user"></i>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    autofocus autocomplete="username" placeholder="Use ID">
                            </div>
                            @if ($errors->has('email'))
                                <div class="error-message">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-lock"></i>
                                <input id="password" type="password" name="password" required
                                    autocomplete="current-password" placeholder="Password">
                            </div>
                            @if ($errors->has('password'))
                                <div class="error-message">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <!-- Remember Me -->
                        <div class="form-options">
                            <label class="remember-me">
                                <input type="checkbox" name="remember">
                                <span>Ingat saya</span>
                            </label>

                            <a class="forgot-password switch-to-forgot" href="#">
                                Lupa password?
                            </a>
                        </div>

                        <button type="submit" class="auth-btn">
                            LOGIN
                        </button>
                    </form>

                    <div class="auth-switch">
                        Belum punya akun? <a href="#" class="switch-to-register">Daftar Sekarang</a>
                    </div>
                </div>

                <!-- Register Form -->
                <div class="auth-content" id="register-content">
                    <h2 class="auth-title">FORM REGISTRASI</h2>
                    <p class="auth-subtitle">Bergabung dengan Toko Alert Kesehatan</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Username -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-user"></i>
                                <input id="username" type="text" name="username" value="{{ old('username') }}"
                                    required autofocus placeholder="Username">
                            </div>
                            @if ($errors->has('username'))
                                <div class="error-message">
                                    {{ $errors->first('username') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-row">
                            <!-- Password -->
                            <div class="form-group">
                                <div class="input-with-icon">
                                    <i class="fas fa-lock"></i>
                                    <input id="password" type="password" name="password" required
                                        autocomplete="new-password" placeholder="Password">
                                </div>
                                @if ($errors->has('password'))
                                    <div class="error-message">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Retype Password -->
                            <div class="form-group">
                                <div class="input-with-icon">
                                    <i class="fas fa-lock"></i>
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                        required autocomplete="new-password" placeholder="Retype Password">
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-envelope"></i>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                    required autocomplete="username" placeholder="E-mail">
                            </div>
                            @if ($errors->has('email'))
                                <div class="error-message">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <!-- Date of Birth -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-calendar"></i>
                                <input id="date_of_birth" type="date" name="date_of_birth"
                                    value="{{ old('date_of_birth') }}" required>
                                <i class="fas fa-chevron-down select-arrow"></i>
                            </div>
                            @if ($errors->has('date_of_birth'))
                                <div class="error-message">
                                    {{ $errors->first('date_of_birth') }}
                                </div>
                            @endif
                        </div>

                        <!-- Gender -->
                        <div class="form-group">
                            <label>Gender:</label>
                            <div class="gender-options">
                                <div class="gender-option">
                                    <input type="radio" id="male" name="gender" value="male"
                                        {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                    <label for="male">Male</label>
                                </div>
                                <div class="gender-option">
                                    <input type="radio" id="female" name="gender" value="female"
                                        {{ old('gender') == 'female' ? 'checked' : '' }} required>
                                    <label for="female">Female</label>
                                </div>
                            </div>
                            @if ($errors->has('gender'))
                                <div class="error-message">
                                    {{ $errors->first('gender') }}
                                </div>
                            @endif
                        </div>

                        <!-- Address -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-home"></i>
                                <input id="address" type="text" name="address" value="{{ old('address') }}"
                                    required placeholder="Address">
                            </div>
                            @if ($errors->has('address'))
                                <div class="error-message">
                                    {{ $errors->first('address') }}
                                </div>
                            @endif
                        </div>

                        <!-- City -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-city"></i>
                                <select id="city" name="city" required>
                                    <option value="">Pilih Kota</option>
                                    <option value="jakarta" {{ old('city') == 'jakarta' ? 'selected' : '' }}>Jakarta
                                    </option>
                                    <option value="surabaya" {{ old('city') == 'surabaya' ? 'selected' : '' }}>
                                        Surabaya</option>
                                    <option value="bandung" {{ old('city') == 'bandung' ? 'selected' : '' }}>Bandung
                                    </option>
                                    <option value="medan" {{ old('city') == 'medan' ? 'selected' : '' }}>Medan
                                    </option>
                                    <option value="semarang" {{ old('city') == 'semarang' ? 'selected' : '' }}>
                                        Semarang</option>
                                </select>
                                <i class="fas fa-chevron-down select-arrow"></i>
                            </div>
                            @if ($errors->has('city'))
                                <div class="error-message">
                                    {{ $errors->first('city') }}
                                </div>
                            @endif
                        </div>

                        <!-- Contact No -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-phone"></i>
                                <input id="contact_no" type="tel" name="contact_no"
                                    value="{{ old('contact_no') }}" required placeholder="Contact no">
                            </div>
                            @if ($errors->has('contact_no'))
                                <div class="error-message">
                                    {{ $errors->first('contact_no') }}
                                </div>
                            @endif
                        </div>

                        <!-- PayPal ID -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fab fa-paypal"></i>
                                <input id="paypal_id" type="text" name="paypal_id"
                                    value="{{ old('paypal_id') }}" placeholder="Pay-pal id">
                            </div>
                            @if ($errors->has('paypal_id'))
                                <div class="error-message">
                                    {{ $errors->first('paypal_id') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-row">
                            <button type="submit" class="auth-btn">
                                Submit
                            </button>
                            <button type="reset" class="auth-btn" style="background: #6c757d;">
                                Clear
                            </button>
                        </div>
                    </form>

                    <div class="auth-switch">
                        Sudah punya akun? <a href="#" class="switch-to-login">Login Sekarang</a>
                    </div>
                </div>

                <!-- Forgot Password Form (Hidden by default) -->
                <div class="auth-content" id="forgot-content">
                    <h2 class="auth-title">LUPA PASSWORD</h2>
                    <p class="auth-subtitle">Masukkan email Anda untuk mereset password</p>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 text-sm font-medium text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-envelope"></i>
                                <input id="forgot-email" type="email" name="email" value="{{ old('email') }}"
                                    required autofocus placeholder="Email Anda">
                            </div>
                            @if ($errors->has('email'))
                                <div class="error-message">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="auth-btn">
                            Kirim Link Reset Password
                        </button>
                    </form>

                    <div class="auth-switch">
                        Ingat password? <a href="#" class="switch-to-login">Login Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const loginTab = document.querySelector('[data-tab="login"]');
            const registerTab = document.querySelector('[data-tab="register"]');
            const loginContent = document.getElementById('login-content');
            const registerContent = document.getElementById('register-content');
            const forgotContent = document.getElementById('forgot-content');
            const switchToRegister = document.querySelector('.switch-to-register');
            const switchToLogin = document.querySelectorAll('.switch-to-login');
            const switchToForgot = document.querySelector('.switch-to-forgot');

            function showLogin() {
                loginTab.classList.add('active');
                registerTab.classList.remove('active');
                loginContent.classList.add('active');
                registerContent.classList.remove('active');
                forgotContent.classList.remove('active');
            }

            function showRegister() {
                registerTab.classList.add('active');
                loginTab.classList.remove('active');
                registerContent.classList.add('active');
                loginContent.classList.remove('active');
                forgotContent.classList.remove('active');
            }

            function showForgot() {
                forgotContent.classList.add('active');
                loginContent.classList.remove('active');
                registerContent.classList.remove('active');
                loginTab.classList.remove('active');
                registerTab.classList.remove('active');
            }

            loginTab.addEventListener('click', showLogin);
            registerTab.addEventListener('click', showRegister);
            switchToRegister.addEventListener('click', showRegister);
            switchToForgot.addEventListener('click', showForgot);

            switchToLogin.forEach(link => {
                link.addEventListener('click', showLogin);
            });

            // Show register form if there are register errors
            @if (
                $errors->has('username') ||
                    $errors->has('date_of_birth') ||
                    $errors->has('gender') ||
                    $errors->has('address') ||
                    $errors->has('city') ||
                    $errors->has('contact_no') ||
                    $errors->has('paypal_id') ||
                    ($errors->has('password') && Route::currentRouteName() == 'register'))
                showRegister();
            @endif

            // Show forgot password form if there are forgot password errors
            @if (Route::currentRouteName() == 'password.request' ||
                    (Route::currentRouteName() == 'password.email' && $errors->any()))
                showForgot();
            @endif
        });
    </script>
</body>

</html>
