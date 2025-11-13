<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

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
            z-index: 1;
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
            background: white;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            padding-right: 45px;
        }

        select option {
            padding: 10px;
        }

        .select-arrow {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            pointer-events: none;
            z-index: 1;
        }

        input:focus,
        select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
            outline: none;
        }

        small {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            color: #666;
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
                        <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'w-16 h-16 fill-current text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-16 h-16 fill-current text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
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
                    <?php if(session('status')): ?>
                        <div class="mb-4 text-sm font-medium text-green-600">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>

                        <!-- Use ID (Email) -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-user"></i>
                                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required
                                    autofocus autocomplete="username" placeholder="Use ID">
                            </div>
                            <?php if($errors->has('email')): ?>
                                <div class="error-message">
                                    <?php echo e($errors->first('email')); ?>

                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-lock"></i>
                                <input id="password" type="password" name="password" required
                                    autocomplete="current-password" placeholder="Password">
                            </div>
                            <?php if($errors->has('password')): ?>
                                <div class="error-message">
                                    <?php echo e($errors->first('password')); ?>

                                </div>
                            <?php endif; ?>
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

                    <!-- Display Validation Errors -->
                    <?php if($errors->any()): ?>
                        <div style="background: #fee; border: 1px solid #fcc; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                            <p style="color: #c33; font-weight: bold; margin-bottom: 10px;">⚠️ Terjadi kesalahan:</p>
                            <ul style="color: #c33; margin: 0; padding-left: 20px;">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('register')); ?>" id="registerFormGuest">
                        <?php echo csrf_field(); ?>

                        <!-- Name (bukan username!) -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-user"></i>
                                <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>"
                                    required autofocus placeholder="Nama Lengkap" minlength="3" maxlength="255">
                            </div>
                            <?php if($errors->has('name')): ?>
                                <div class="error-message">
                                    <?php echo e($errors->first('name')); ?>

                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-envelope"></i>
                                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>"
                                    required placeholder="contoh@email.com">
                            </div>
                            <?php if($errors->has('email')): ?>
                                <div class="error-message">
                                    <?php echo e($errors->first('email')); ?>

                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-row">
                            <!-- Password -->
                            <div class="form-group">
                                <div class="input-with-icon">
                                    <i class="fas fa-lock"></i>
                                    <input id="password_reg" type="password" name="password" required
                                        autocomplete="new-password" placeholder="Password (min 8 karakter)" minlength="8">
                                </div>
                                <?php if($errors->has('password')): ?>
                                    <div class="error-message">
                                        <?php echo e($errors->first('password')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Retype Password -->
                            <div class="form-group">
                                <div class="input-with-icon">
                                    <i class="fas fa-lock"></i>
                                    <input id="password_confirmation_reg" type="password" name="password_confirmation"
                                        required autocomplete="new-password" placeholder="Konfirmasi Password" minlength="8">
                                </div>
                            </div>
                        </div>

                        <!-- Password Match Indicator -->
                        <div id="password-match-indicator" style="margin-top: -10px; margin-bottom: 15px; font-size: 13px;"></div>

                        <!-- Informasi Tambahan (Opsional) -->
                        <div style="margin: 25px 0 15px; padding-top: 15px; border-top: 2px dashed #ddd;">
                            <p style="color: #666; font-size: 14px; margin-bottom: 15px;">
                                <i class="fas fa-info-circle"></i> <strong>Informasi Tambahan</strong> <span style="font-size: 12px; color: #999;">(Opsional)</span>
                            </p>
                        </div>

                        <!-- Phone Number -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-phone"></i>
                                <input id="phone" type="tel" name="phone" value="<?php echo e(old('phone')); ?>"
                                    placeholder="Nomor Telepon (contoh: 081234567890)" pattern="[0-9]{10,13}">
                            </div>
                            <small style="color: #666; font-size: 12px;">Format: 10-13 digit angka</small>
                            <?php if($errors->has('phone')): ?>
                                <div class="error-message">
                                    <?php echo e($errors->first('phone')); ?>

                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-row">
                            <!-- Date of Birth -->
                            <div class="form-group">
                                <div class="input-with-icon">
                                    <i class="fas fa-calendar"></i>
                                    <input id="date_of_birth" type="date" name="date_of_birth" value="<?php echo e(old('date_of_birth')); ?>"
                                        placeholder="Tanggal Lahir">
                                </div>
                                <?php if($errors->has('date_of_birth')): ?>
                                    <div class="error-message">
                                        <?php echo e($errors->first('date_of_birth')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Gender -->
                            <div class="form-group">
                                <div class="input-with-icon">
                                    <i class="fas fa-venus-mars"></i>
                                    <select id="gender" name="gender">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="male" <?php echo e(old('gender') == 'male' ? 'selected' : ''); ?>>Laki-laki</option>
                                        <option value="female" <?php echo e(old('gender') == 'female' ? 'selected' : ''); ?>>Perempuan</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-arrow"></i>
                                </div>
                                <?php if($errors->has('gender')): ?>
                                    <div class="error-message">
                                        <?php echo e($errors->first('gender')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-map-marker-alt"></i>
                                <input id="address" type="text" name="address" value="<?php echo e(old('address')); ?>"
                                    placeholder="Alamat Lengkap" maxlength="255">
                            </div>
                            <?php if($errors->has('address')): ?>
                                <div class="error-message">
                                    <?php echo e($errors->first('address')); ?>

                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-row">
                            <!-- City -->
                            <div class="form-group">
                                <div class="input-with-icon">
                                    <i class="fas fa-city"></i>
                                    <input id="city" type="text" name="city" value="<?php echo e(old('city')); ?>"
                                        placeholder="Kota" maxlength="100">
                                </div>
                                <?php if($errors->has('city')): ?>
                                    <div class="error-message">
                                        <?php echo e($errors->first('city')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Postal Code -->
                            <div class="form-group">
                                <div class="input-with-icon">
                                    <i class="fas fa-mail-bulk"></i>
                                    <input id="postal_code" type="text" name="postal_code" value="<?php echo e(old('postal_code')); ?>"
                                        placeholder="Kode Pos" pattern="[0-9]{5}" maxlength="5">
                                </div>
                                <small style="color: #666; font-size: 12px;">5 digit angka</small>
                                <?php if($errors->has('postal_code')): ?>
                                    <div class="error-message">
                                        <?php echo e($errors->first('postal_code')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <button type="submit" class="auth-btn" id="registerSubmitBtn">
                                <span id="registerBtnText">Submit</span>
                                <span id="registerBtnLoading" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i> Mendaftar...
                                </span>
                            </button>
                            <button type="reset" class="auth-btn" style="background: #6c757d;">
                                Clear
                            </button>
                        </div>
                    </form>

                    <script>
                        // Password match validation
                        document.addEventListener('DOMContentLoaded', function() {
                            const password = document.getElementById('password_reg');
                            const passwordConfirmation = document.getElementById('password_confirmation_reg');
                            const matchIndicator = document.getElementById('password-match-indicator');
                            const registerForm = document.getElementById('registerFormGuest');
                            const submitBtn = document.getElementById('registerSubmitBtn');
                            const btnText = document.getElementById('registerBtnText');
                            const btnLoading = document.getElementById('registerBtnLoading');

                            if (passwordConfirmation && password) {
                                passwordConfirmation.addEventListener('input', function() {
                                    if (this.value === '') {
                                        matchIndicator.textContent = '';
                                    } else if (password.value === this.value) {
                                        matchIndicator.innerHTML = '<span style="color: #28a745;">✓ Password cocok</span>';
                                    } else {
                                        matchIndicator.innerHTML = '<span style="color: #dc3545;">✗ Password tidak cocok</span>';
                                    }
                                });

                                // Form submission
                                registerForm.addEventListener('submit', function(e) {
                                    if (password.value !== passwordConfirmation.value) {
                                        e.preventDefault();
                                        alert('Password dan Konfirmasi Password tidak cocok!');
                                        return false;
                                    }

                                    // Show loading
                                    submitBtn.disabled = true;
                                    btnText.style.display = 'none';
                                    btnLoading.style.display = 'inline';

                                    console.log('Registering with:', {
                                        name: document.getElementById('name').value,
                                        email: document.getElementById('email').value
                                    });
                                });
                            }
                        });
                    </script>

                    <div class="auth-switch">
                        Sudah punya akun? <a href="#" class="switch-to-login">Login Sekarang</a>
                    </div>
                </div>

                <!-- Forgot Password Form (Hidden by default) -->
                <div class="auth-content" id="forgot-content">
                    <h2 class="auth-title">LUPA PASSWORD</h2>
                    <p class="auth-subtitle">Masukkan email Anda untuk mereset password</p>

                    <!-- Session Status -->
                    <?php if(session('status')): ?>
                        <div class="mb-4 text-sm font-medium text-green-600">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('password.email')); ?>">
                        <?php echo csrf_field(); ?>

                        <!-- Email Address -->
                        <div class="form-group">
                            <div class="input-with-icon">
                                <i class="fas fa-envelope"></i>
                                <input id="forgot-email" type="email" name="email" value="<?php echo e(old('email')); ?>"
                                    required autofocus placeholder="Email Anda">
                            </div>
                            <?php if($errors->has('email')): ?>
                                <div class="error-message">
                                    <?php echo e($errors->first('email')); ?>

                                </div>
                            <?php endif; ?>
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

            // Show register form if route is register or if there are register errors
            <?php if(
                Route::currentRouteName() == 'register' ||
                $errors->has('username') ||
                    $errors->has('date_of_birth') ||
                    $errors->has('gender') ||
                    $errors->has('address') ||
                    $errors->has('city') ||
                    $errors->has('contact_no') ||
                    $errors->has('paypal_id') ||
                    ($errors->has('password') && Route::currentRouteName() == 'register')): ?>
                showRegister();
            <?php endif; ?>

            // Show forgot password form if there are forgot password errors
            <?php if(Route::currentRouteName() == 'password.request' ||
                    (Route::currentRouteName() == 'password.email' && $errors->any())): ?>
                showForgot();
            <?php endif; ?>
        });
    </script>
</body>

</html>
<?php /**PATH D:\PERKULIAHAN\LSP\Ujikom_Cheisya\resources\views/layouts/guest.blade.php ENDPATH**/ ?>