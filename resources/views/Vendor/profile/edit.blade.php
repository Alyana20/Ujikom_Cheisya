@extends('layouts.vendor')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-edit mr-3 text-green-600"></i>
                    Edit Profil Vendor
                </h1>
                <p class="mt-2 text-gray-600">Perbarui informasi toko dan profil personal Anda</p>
            </div>
            <a href="{{ route('vendor.profile.index') }}" 
               class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition shadow-lg">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden sticky top-4">
                <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
                    <h3 class="text-lg font-bold text-white">Menu Edit</h3>
                </div>
                <div class="p-4">
                    <nav class="space-y-2">
                        <a href="#personal-info" 
                           class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-lg transition">
                            <i class="fas fa-user mr-3 w-5"></i>
                            Informasi Personal
                        </a>
                        @if($store)
                        <a href="#store-info" 
                           class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-lg transition">
                            <i class="fas fa-store mr-3 w-5"></i>
                            Informasi Toko
                        </a>
                        @endif
                        <a href="#password" 
                           class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-lg transition">
                            <i class="fas fa-lock mr-3 w-5"></i>
                            Ubah Password
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information Form -->
            <div id="personal-info" class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-user mr-3"></i>
                        Informasi Personal
                    </h3>
                </div>
                
                <form action="{{ route('vendor.profile.update-personal') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-id-card mr-2 text-blue-600"></i>
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $user->name) }}" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('name') border-red-500 @enderror"
                                placeholder="John Doe">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-blue-600"></i>
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', $user->email) }}" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('email') border-red-500 @enderror"
                                placeholder="vendor@example.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button 
                                type="submit"
                                class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 text-white py-3 px-6 rounded-lg font-semibold hover:from-blue-600 hover:to-indigo-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition transform hover:scale-[1.02] active:scale-[0.98] shadow-lg">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Informasi Personal
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Store Information Form -->
            @if($store)
            <div id="store-info" class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-store-alt mr-3"></i>
                        Informasi Toko
                    </h3>
                </div>
                
                <form action="{{ route('vendor.profile.update-store') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        <!-- Store Name -->
                        <div>
                            <label for="store_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-shopping-bag mr-2 text-green-600"></i>
                                Nama Toko <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="store_name" 
                                name="name" 
                                value="{{ old('name', $store->name) }}" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('name') border-red-500 @enderror"
                                placeholder="Apotek Sehat Sejahtera">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Store Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-phone mr-2 text-green-600"></i>
                                No. Telepon Toko <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone', $store->phone) }}" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('phone') border-red-500 @enderror"
                                placeholder="08123456789">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Store Address -->
                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>
                                Alamat Toko <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="address" 
                                name="address" 
                                rows="3" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('address') border-red-500 @enderror"
                                placeholder="Alamat lengkap toko...">{{ old('address', $store->address) }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Store Description -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-align-left mr-2 text-green-600"></i>
                                Deskripsi Toko
                            </label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition @error('description') border-red-500 @enderror"
                                placeholder="Ceritakan tentang toko Anda...">{{ old('description', $store->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Maksimal 1000 karakter</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button 
                                type="submit"
                                class="w-full bg-gradient-to-r from-green-500 to-teal-500 text-white py-3 px-6 rounded-lg font-semibold hover:from-green-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition transform hover:scale-[1.02] active:scale-[0.98] shadow-lg">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Informasi Toko
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @endif

            <!-- Change Password Form -->
            <div id="password" class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-pink-500 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-lock mr-3"></i>
                        Ubah Password
                    </h3>
                </div>
                
                <form action="{{ route('vendor.profile.update-password') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-key mr-2 text-red-600"></i>
                                Password Saat Ini <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="current_password" 
                                    name="current_password" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition pr-12 @error('current_password') border-red-500 @enderror"
                                    placeholder="••••••••">
                                <button 
                                    type="button" 
                                    onclick="togglePasswordVisibility('current_password')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye" id="toggleIconCurrent"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-red-600"></i>
                                Password Baru <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    required
                                    onkeyup="checkPasswordMatch()"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition pr-12 @error('password') border-red-500 @enderror"
                                    placeholder="Min. 8 karakter">
                                <button 
                                    type="button" 
                                    onclick="togglePasswordVisibility('password')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye" id="toggleIconNew"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-red-600"></i>
                                Konfirmasi Password Baru <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    required
                                    onkeyup="checkPasswordMatch()"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition pr-12"
                                    placeholder="Ulangi password baru">
                                <button 
                                    type="button" 
                                    onclick="togglePasswordVisibility('password_confirmation')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye" id="toggleIconConfirm"></i>
                                </button>
                            </div>
                            <p id="passwordMatch" class="mt-1 text-sm" style="display: none;"></p>
                        </div>

                        <!-- Info -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-sm text-blue-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                Password harus minimal 8 karakter untuk keamanan akun Anda.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button 
                                type="submit"
                                class="w-full bg-gradient-to-r from-red-500 to-pink-500 text-white py-3 px-6 rounded-lg font-semibold hover:from-red-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition transform hover:scale-[1.02] active:scale-[0.98] shadow-lg">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Ubah Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(fieldId) {
    const input = document.getElementById(fieldId);
    let iconId = 'toggleIcon';
    
    if (fieldId === 'current_password') iconId = 'toggleIconCurrent';
    else if (fieldId === 'password') iconId = 'toggleIconNew';
    else if (fieldId === 'password_confirmation') iconId = 'toggleIconConfirm';
    
    const icon = document.getElementById(iconId);
    
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

function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    const matchElement = document.getElementById('passwordMatch');

    if (confirmPassword.length > 0) {
        matchElement.style.display = 'block';
        if (password === confirmPassword) {
            matchElement.textContent = '✓ Password cocok';
            matchElement.className = 'mt-1 text-sm text-green-600';
        } else {
            matchElement.textContent = '✗ Password tidak cocok';
            matchElement.className = 'mt-1 text-sm text-red-600';
        }
    } else {
        matchElement.style.display = 'none';
    }
}

// Smooth scroll to sections
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>
@endsection
