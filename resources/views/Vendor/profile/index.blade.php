@extends('layouts.vendor')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-user-circle mr-3 text-green-600"></i>
                    Profil Vendor
                </h1>
                <p class="mt-2 text-gray-600">Kelola informasi toko Anda dan atur profil penjual</p>
            </div>
            <a href="{{ route('vendor.profile.edit') }}" 
               class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition shadow-lg">
                <i class="fas fa-edit mr-2"></i>
                Edit Profil
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
            <i class="fas fa-check-circle mr-3 text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-teal-500 h-32"></div>
                <div class="px-6 pb-6">
                    <div class="-mt-16 mb-4">
                        <div class="w-32 h-32 bg-white rounded-full border-4 border-white shadow-xl flex items-center justify-center mx-auto">
                            <span class="text-4xl font-bold text-green-600">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $user->name }}</h2>
                        <p class="text-gray-600 mb-2">{{ $user->email }}</p>
                        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-store mr-1"></i>
                            Vendor
                        </span>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">
                                    <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                    Bergabung
                                </span>
                                <span class="font-semibold text-gray-900">
                                    {{ $user->created_at->format('d M Y') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">
                                    <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                    Email
                                </span>
                                <span class="font-semibold text-gray-900">
                                    @if($user->email_verified_at)
                                        <i class="fas fa-check-circle text-green-600"></i> Terverifikasi
                                    @else
                                        <i class="fas fa-times-circle text-red-600"></i> Belum
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Store Information Card -->
            @if($store)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-store-alt mr-3"></i>
                        Informasi Toko
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-shopping-bag mr-2 text-green-600"></i>
                                Nama Toko
                            </label>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-900">
                                {{ $store->name }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-phone mr-2 text-green-600"></i>
                                No. Telepon
                            </label>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-900">
                                {{ $store->phone }}
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>
                                Alamat Toko
                            </label>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-900">
                                {{ $store->address }}
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-align-left mr-2 text-green-600"></i>
                                Deskripsi Toko
                            </label>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-900 min-h-[100px]">
                                {{ $store->description ?: 'Belum ada deskripsi' }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-check-circle mr-2 text-green-600"></i>
                                Status Toko
                            </label>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                                @if($store->status === 'approved')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Disetujui
                                    </span>
                                @elseif($store->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-2"></i>
                                        Menunggu Persetujuan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-2"></i>
                                        Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar-check mr-2 text-green-600"></i>
                                Terdaftar Sejak
                            </label>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-900">
                                {{ $store->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-4xl mb-3"></i>
                <h3 class="text-lg font-semibold text-yellow-800 mb-2">Toko Belum Tersedia</h3>
                <p class="text-yellow-700">Anda belum memiliki toko yang terdaftar.</p>
            </div>
            @endif

            <!-- Personal Information Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-user mr-3"></i>
                        Informasi Personal
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-id-card mr-2 text-blue-600"></i>
                                Nama Lengkap
                            </label>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-900">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-blue-600"></i>
                                Email
                            </label>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-900">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user-tag mr-2 text-blue-600"></i>
                                Role
                            </label>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                    <i class="fas fa-store mr-2"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-shield-alt mr-2 text-blue-600"></i>
                                Keamanan
                            </label>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-gray-900">
                                Password terenkripsi
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-bolt mr-3"></i>
                        Aksi Cepat
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('vendor.profile.edit') }}" 
                           class="flex items-center justify-center bg-gradient-to-r from-green-500 to-teal-500 text-white px-6 py-4 rounded-lg hover:from-green-600 hover:to-teal-600 transition shadow-md">
                            <i class="fas fa-edit mr-3 text-xl"></i>
                            <span class="font-semibold">Edit Profil & Toko</span>
                        </a>
                        
                        <a href="{{ route('vendor.dashboard') }}" 
                           class="flex items-center justify-center bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-6 py-4 rounded-lg hover:from-blue-600 hover:to-indigo-600 transition shadow-md">
                            <i class="fas fa-tachometer-alt mr-3 text-xl"></i>
                            <span class="font-semibold">Kembali ke Dashboard</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
