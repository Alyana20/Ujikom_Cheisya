<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500">
        <div class="bg-white/10 backdrop-blur-md rounded-3xl shadow-xl flex w-full max-w-5xl overflow-hidden">

            <!-- Bagian Kiri -->
            <div class="hidden md:flex flex-col justify-center text-white w-1/2 px-12 py-16">
                <div class="flex flex-col items-start">
                    <div class="bg-white/20 p-4 rounded-2xl mb-6">
                        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" class="w-10 h-10">
                    </div>
                    <h1 class="text-4xl font-bold leading-snug">
                        Selamat datang di <br>
                        <span class="text-yellow-300">Toko Alat Kesehatan</span>
                    </h1>
                    <p class="mt-4 text-sm text-gray-100 leading-relaxed">
                        Sistem Online Shopping terpercaya <br>
                        untuk kebutuhan kesehatan Anda.
                    </p>
                </div>

                <div class="mt-10 space-y-4 text-sm text-gray-200">
                    <div class="flex items-center space-x-3">
                        <span class="text-lg">🛡️</span>
                        <p>Transaksi Aman dengan SSL</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-lg">🚚</span>
                        <p>Gratis Ongkir untuk Area Tertentu</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-lg">🎧</span>
                        <p>Customer Service 24/7</p>
                    </div>
                </div>
            </div>

            <!-- Bagian Kanan -->
            <div class="w-full md:w-1/2 bg-white p-10 flex flex-col justify-center">
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">LOGIN</h2>
                <p class="text-center text-gray-500 mb-8">Masuk ke akun Anda</p>

                <!-- Session Status -->
                <?php if(session('status')): ?>
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>

                <!-- Validation Errors -->
                <?php if($errors->any()): ?>
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded">
                        <ul class="list-disc list-inside text-sm">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <!-- User ID -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">User ID</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fa fa-user"></i>
                            </span>
                            <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required autofocus
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700"
                                placeholder="admin@gmail.com">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fa fa-lock"></i>
                            </span>
                            <input id="password" name="password" type="password" required
                                class="block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700"
                                placeholder="••••••••">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 cursor-pointer"
                                onclick="togglePassword()">
                                <i class="fa fa-eye" id="toggleIcon"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex justify-between items-center text-sm">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>

                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span>Ingat saya</span>
                        </label>
                        <?php if(Route::has('password.request')): ?>
                            <a href="<?php echo e(route('password.request')); ?>" class="text-indigo-600 hover:text-indigo-800">Lupa Password?</a>
                        <?php endif; ?>
                    </div>

                    <!-- Button -->
                    <div class="flex justify-center">
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-2 rounded-lg font-semibold shadow hover:from-indigo-700 hover:to-purple-700 transition">
                            <i class="fa fa-sign-in-alt"></i> LOGIN
                        </button>
                    </div>
                </form>

                <p class="text-center text-sm text-gray-600 mt-6">
                    Belum punya akun?
                    <a href="<?php echo e(route('register')); ?>" class="text-indigo-600 font-medium hover:underline">Daftar
                        Sekarang</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH D:\PERKULIAHAN\LSP\Ujikom_Cheisya\resources\views/auth/login.blade.php ENDPATH**/ ?>