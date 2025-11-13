<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Admin Login - Toko Alat Kesehatan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .admin-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 8px 20px;
            border-radius: 50px;
            color: white;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    
    <div class="w-full max-w-md">
        <!-- Admin Badge -->
        <div class="text-center mb-6">
            <span class="admin-badge">
                <i class="fas fa-shield-alt"></i>
                ADMIN PANEL
            </span>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-8 text-white text-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-shield text-4xl text-purple-600"></i>
                </div>
                <h1 class="text-2xl font-bold mb-2">Admin Login</h1>
                <p class="text-purple-100">Toko Alat Kesehatan</p>
            </div>

            <!-- Form -->
            <div class="p-8">
                <!-- Session Status -->
                <?php if(session('status')): ?>
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>

                <!-- Validation Errors -->
                <?php if($errors->any()): ?>
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <p class="font-semibold mb-2">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Terjadi kesalahan:
                        </p>
                        <ul class="list-disc list-inside text-sm">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('admin.login.submit')); ?>" class="space-y-5">
                    <?php echo csrf_field(); ?>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-purple-600"></i>
                            Email Admin
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="<?php echo e(old('email')); ?>" 
                            required 
                            autofocus
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="admin@example.com">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-purple-600"></i>
                            Password
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition pr-12 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="••••••••">
                            <button 
                                type="button" 
                                onclick="togglePassword()"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        
                        <?php if(Route::has('password.request')): ?>
                            <a href="<?php echo e(route('password.request')); ?>" class="text-sm text-purple-600 hover:text-purple-800">
                                Lupa password?
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3 px-4 rounded-lg font-semibold hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition transform hover:scale-[1.02] active:scale-[0.98] shadow-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login sebagai Admin
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">atau</span>
                    </div>
                </div>

                <!-- Back to Public Site -->
                <a href="<?php echo e(route('home')); ?>" 
                   class="block w-full text-center bg-gray-100 text-gray-700 py-3 px-4 rounded-lg font-medium hover:bg-gray-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Halaman Utama
                </a>
            </div>

            <!-- Footer Info -->
            <div class="bg-gray-50 px-8 py-4 text-center text-sm text-gray-600 border-t">
                <i class="fas fa-info-circle mr-1"></i>
                Hanya untuk Administrator
            </div>
        </div>

        <!-- Security Notice -->
        <div class="mt-6 text-center text-white text-sm">
            <i class="fas fa-shield-alt mr-2"></i>
            Koneksi aman dengan SSL
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Auto-focus email field
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('email')?.focus();
        });
    </script>
</body>
</html>
<?php /**PATH D:\PERKULIAHAN\LSP\Ujikom_Cheisya\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>