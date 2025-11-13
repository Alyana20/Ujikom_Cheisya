<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Vendor - Toko Alat Kesehatan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .vendor-badge {
            background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
            padding: 8px 20px;
            border-radius: 50px;
            color: #1a202c;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(132, 250, 176, 0.3);
        }
        .password-match {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .password-match.match {
            color: #10b981;
        }
        .password-match.mismatch {
            color: #ef4444;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    
    <div class="w-full max-w-2xl my-8">
        <!-- Vendor Badge -->
        <div class="text-center mb-6">
            <span class="vendor-badge">
                <i class="fas fa-store"></i>
                VENDOR REGISTRATION
            </span>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-500 to-teal-500 p-8 text-white text-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-store-alt text-4xl text-green-600"></i>
                </div>
                <h1 class="text-2xl font-bold mb-2">Daftar Sebagai Vendor</h1>
                <p class="text-green-100">Toko Alat Kesehatan</p>
            </div>

            <!-- Form -->
            <div class="p-8">
                <!-- Info Notice -->
                <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
                    <p class="font-semibold mb-2">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informasi Pendaftaran
                    </p>
                    <ul class="text-sm space-y-1 ml-6 list-disc">
                        <li>Setelah mendaftar, akun Anda akan menunggu persetujuan admin</li>
                        <li>Anda akan menerima notifikasi setelah akun disetujui</li>
                        <li>Pastikan data yang diisi sudah benar</li>
                    </ul>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <p class="font-semibold mb-2">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Terjadi kesalahan:
                        </p>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('vendor.register.submit') }}" class="space-y-5">
                    @csrf

                    <!-- Account Information -->
                    <div class="border-b pb-4 mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-user-circle mr-2 text-green-600"></i>
                            Informasi Akun
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    id="name" 
                                    type="text" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    required 
                                    autofocus
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('name') border-red-500 @enderror"
                                    placeholder="John Doe">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('email') border-red-500 @enderror"
                                    placeholder="vendor@example.com">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        id="password" 
                                        type="password" 
                                        name="password" 
                                        required
                                        onkeyup="checkPasswordMatch()"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition pr-12 @error('password') border-red-500 @enderror"
                                        placeholder="Min. 8 karakter">
                                    <button 
                                        type="button" 
                                        onclick="togglePassword('password')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye" id="toggleIconPassword"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Konfirmasi Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        id="password_confirmation" 
                                        type="password" 
                                        name="password_confirmation" 
                                        required
                                        onkeyup="checkPasswordMatch()"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition pr-12"
                                        placeholder="Ulangi password">
                                    <button 
                                        type="button" 
                                        onclick="togglePassword('password_confirmation')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye" id="toggleIconConfirmation"></i>
                                    </button>
                                </div>
                                <p id="passwordMatch" class="password-match" style="display: none;"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Shop Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-store mr-2 text-green-600"></i>
                            Informasi Toko
                        </h3>

                        <div class="space-y-5">
                            <!-- Shop Name -->
                            <div>
                                <label for="shop_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Toko <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    id="shop_name" 
                                    type="text" 
                                    name="shop_name" 
                                    value="{{ old('shop_name') }}" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('shop_name') border-red-500 @enderror"
                                    placeholder="Contoh: Apotek Sehat Sejahtera">
                                @error('shop_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Shop Phone -->
                            <div>
                                <label for="shop_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    No. Telepon Toko <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    id="shop_phone" 
                                    type="text" 
                                    name="shop_phone" 
                                    value="{{ old('shop_phone') }}" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('shop_phone') border-red-500 @enderror"
                                    placeholder="08123456789">
                                @error('shop_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Shop Address -->
                            <div>
                                <label for="shop_address" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Alamat Toko <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    id="shop_address" 
                                    name="shop_address" 
                                    rows="3" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('shop_address') border-red-500 @enderror"
                                    placeholder="Alamat lengkap toko...">{{ old('shop_address') }}</textarea>
                                @error('shop_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Shop Description -->
                            <div>
                                <label for="shop_description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Deskripsi Toko
                                </label>
                                <textarea 
                                    id="shop_description" 
                                    name="shop_description" 
                                    rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('shop_description') border-red-500 @enderror"
                                    placeholder="Ceritakan tentang toko Anda (opsional)...">{{ old('shop_description') }}</textarea>
                                @error('shop_description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button 
                            type="submit"
                            class="w-full bg-gradient-to-r from-green-500 to-teal-500 text-white py-4 px-4 rounded-lg font-semibold hover:from-green-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition transform hover:scale-[1.02] active:scale-[0.98] shadow-lg">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Permohonan Menjadi Vendor
                        </button>
                    </div>
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

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-gray-600 mb-3">Sudah punya akun vendor?</p>
                    <a href="{{ route('vendor.login') }}" 
                       class="block w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-lg font-medium hover:bg-gray-200 transition">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login Vendor
                    </a>
                </div>

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
                <a href="{{ route('home') }}" 
                   class="block w-full text-center bg-white border border-gray-300 text-gray-700 py-3 px-4 rounded-lg font-medium hover:bg-gray-50 transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Halaman Utama
                </a>
            </div>

            <!-- Footer Info -->
            <div class="bg-gray-50 px-8 py-4 text-center text-sm text-gray-600 border-t">
                <i class="fas fa-shield-check mr-1"></i>
                Data Anda aman dan terenkripsi
            </div>
        </div>

        <!-- Security Notice -->
        <div class="mt-6 text-center text-white text-sm">
            <i class="fas fa-shield-alt mr-2"></i>
            Koneksi aman dengan SSL
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = document.getElementById('toggleIcon' + fieldId.charAt(0).toUpperCase() + fieldId.slice(1).replace('_', ''));
            
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

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchElement = document.getElementById('passwordMatch');

            if (confirmPassword.length > 0) {
                matchElement.style.display = 'block';
                if (password === confirmPassword) {
                    matchElement.textContent = '✓ Password cocok';
                    matchElement.className = 'password-match match';
                } else {
                    matchElement.textContent = '✗ Password tidak cocok';
                    matchElement.className = 'password-match mismatch';
                }
            } else {
                matchElement.style.display = 'none';
            }
        }

        // Auto-focus name field
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('name')?.focus();
        });
    </script>
</body>
</html>
