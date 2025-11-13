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
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500 py-8">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-center text-2xl font-bold text-gray-800 mb-2">REGISTRASI</h2>
            <p class="text-center text-gray-500 mb-6">Buat akun baru</p>

            <!-- Session Status -->
            <?php if(session('status')): ?>
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <!-- Validation Errors -->
            <?php if($errors->any()): ?>
                <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded">
                    <p class="font-semibold mb-2">⚠️ Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-4" id="registerForm">
                <?php echo csrf_field(); ?>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="Masukkan nama lengkap Anda"
                        minlength="3"
                        maxlength="255">
                    <?php $__errorArgs = ['name'];
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

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="contoh@email.com">
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
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Minimal 8 karakter"
                            minlength="8">
                        <button type="button" onclick="togglePasswordVisibility('password')" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i class="fa fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
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

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-700"
                            placeholder="Ketik ulang password"
                            minlength="8">
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation')" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <i class="fa fa-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500" id="password-match-message"></p>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center gap-3 pt-2">
                    <button type="submit" id="submitBtn"
                        class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-2 px-4 rounded-lg font-semibold shadow hover:from-indigo-700 hover:to-purple-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="submitText">Daftar</span>
                        <span id="submitLoading" class="hidden">
                            <i class="fa fa-spinner fa-spin"></i> Mendaftar...
                        </span>
                    </button>
                    <button type="reset"
                        class="flex-1 bg-gray-400 text-white py-2 px-4 rounded-lg font-semibold hover:bg-gray-500 transition">
                        Reset
                    </button>
                </div>
            </form>

            <p class="text-center text-sm text-gray-600 mt-6">
                Sudah punya akun?
                <a href="<?php echo e(route('login')); ?>" class="text-indigo-600 font-medium hover:underline">Login Sekarang</a>
            </p>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(fieldId) {
            const input = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');
            
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

        // Password match validation
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        const matchMessage = document.getElementById('password-match-message');

        passwordConfirmation.addEventListener('input', function() {
            if (this.value === '') {
                matchMessage.textContent = '';
                matchMessage.className = 'mt-1 text-xs text-gray-500';
            } else if (password.value === this.value) {
                matchMessage.textContent = '✓ Password cocok';
                matchMessage.className = 'mt-1 text-xs text-green-600';
            } else {
                matchMessage.textContent = '✗ Password tidak cocok';
                matchMessage.className = 'mt-1 text-xs text-red-600';
            }
        });

        // Form submission
        const form = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitLoading = document.getElementById('submitLoading');

        form.addEventListener('submit', function(e) {
            // Check if passwords match
            if (password.value !== passwordConfirmation.value) {
                e.preventDefault();
                alert('Password dan Konfirmasi Password tidak cocok!');
                return false;
            }

            // Show loading state
            submitBtn.disabled = true;
            submitText.classList.add('hidden');
            submitLoading.classList.remove('hidden');
        });

        // Debug: Log form data when clicking submit
        submitBtn.addEventListener('click', function(e) {
            console.log('Form Data:', {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                password_confirmation: document.getElementById('password_confirmation').value
            });
        });
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
<?php /**PATH D:\PERKULIAHAN\LSP\Ujikom_Cheisya\resources\views/auth/register.blade.php ENDPATH**/ ?>