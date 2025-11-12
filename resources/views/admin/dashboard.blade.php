@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div
            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-800">0</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="fas fa-users text-blue-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-500 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i>
                    0%
                </span>
                <span class="text-gray-500 ml-2">dari bulan lalu</span>
            </div>
        </div>

        <!-- Total Toko -->
        <div
            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Toko</p>
                    <p class="text-3xl font-bold text-gray-800">0</p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="fas fa-store text-green-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-500 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i>
                    0%
                </span>
                <span class="text-gray-500 ml-2">dari bulan lalu</span>
            </div>
        </div>

        <!-- Total Produk -->
        <div
            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500 hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Produk</p>
                    <p class="text-3xl font-bold text-gray-800">0</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-lg">
                    <i class="fas fa-box text-yellow-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-green-500 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i>
                    0%
                </span>
                <span class="text-gray-500 ml-2">dari bulan lalu</span>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div
            class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Menunggu Persetujuan</p>
                    <p class="text-3xl font-bold text-gray-800">0</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-lg">
                    <i class="fas fa-clock text-purple-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="#" class="text-purple-600 text-sm font-medium hover:text-purple-700 flex items-center">
                    Lihat detail
                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Permohonan Buka Toko -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-clock text-yellow-500 mr-3"></i>
                    Permohonan Buka Toko
                </h2>
                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    Menunggu Approval
                </span>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                <div class="flex items-center justify-center py-8">
                    <div class="text-center">
                        <i class="fas fa-inbox text-yellow-400 text-4xl mb-3"></i>
                        <p class="text-yellow-800 font-medium">Belum ada permohonan toko baru</p>
                        <p class="text-yellow-600 text-sm mt-1">Semua permohonan telah diproses</p>
                    </div>
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <a href="{{ route('admin.stores.index') }}"
                    class="text-primary-600 text-sm font-medium hover:text-primary-700 flex items-center">
                    Kelola semua toko
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-bell text-blue-500 mr-3"></i>
                    Aktivitas Terbaru
                </h2>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    0 Aktivitas
                </span>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <div class="flex items-center justify-center py-8">
                    <div class="text-center">
                        <i class="fas fa-history text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-600 font-medium">Tidak ada aktivitas terbaru</p>
                        <p class="text-gray-500 text-sm mt-1">Aktivitas sistem akan muncul di sini</p>
                    </div>
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <a href="#" class="text-primary-600 text-sm font-medium hover:text-primary-700 flex items-center">
                    Lihat riwayat lengkap
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-bolt text-primary-500 mr-3"></i>
                Quick Actions
            </h2>
            <p class="text-gray-500 text-sm">Akses cepat ke fitur utama</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Kelola User -->
            <a href="{{ route('admin.users.index') }}"
                class="group bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-5 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-3">
                    <div class="bg-blue-500 p-3 rounded-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <i
                        class="fas fa-arrow-right text-blue-400 group-hover:translate-x-1 transition-transform duration-300"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-1">Kelola User</h3>
                <p class="text-gray-600 text-sm">Kelola pengguna dan akses</p>
            </a>

            <!-- Kelola Toko -->
            <a href="{{ route('admin.stores.index') }}"
                class="group bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-5 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-3">
                    <div class="bg-green-500 p-3 rounded-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-store text-white text-xl"></i>
                    </div>
                    <i
                        class="fas fa-arrow-right text-green-400 group-hover:translate-x-1 transition-transform duration-300"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-1">Kelola Toko</h3>
                <p class="text-gray-600 text-sm">Kelola toko dan persetujuan</p>
            </a>

            <!-- Kelola Produk -->
            <a href="#"
                class="group bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-5 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-3">
                    <div class="bg-purple-500 p-3 rounded-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-box text-white text-xl"></i>
                    </div>
                    <i
                        class="fas fa-arrow-right text-purple-400 group-hover:translate-x-1 transition-transform duration-300"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-1">Kelola Produk</h3>
                <p class="text-gray-600 text-sm">Kelola produk dan kategori</p>
            </a>
        </div>
    </div>

    <!-- Additional Info Section -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- System Status -->
        <div class="bg-gradient-to-r from-primary-50 to-blue-50 border border-primary-200 rounded-xl p-5">
            <div class="flex items-center mb-4">
                <div class="bg-primary-500 p-2 rounded-lg mr-3">
                    <i class="fas fa-server text-white"></i>
                </div>
                <h3 class="font-bold text-gray-800">Status Sistem</h3>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Server</span>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">Online</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Database</span>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">Connected</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Cache</span>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">Active</span>
                </div>
            </div>
        </div>

        <!-- Support -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-5">
            <div class="flex items-center mb-4">
                <div class="bg-gray-600 p-2 rounded-lg mr-3">
                    <i class="fas fa-headset text-white"></i>
                </div>
                <h3 class="font-bold text-gray-800">Butuh Bantuan?</h3>
            </div>
            <p class="text-gray-600 text-sm mb-4">Tim support siap membantu Anda 24/7</p>
            <div class="flex space-x-3">
                <a href="#"
                    class="flex-1 bg-primary-500 text-white text-center py-2 px-3 rounded-lg hover:bg-primary-600 transition-colors duration-300 text-sm font-medium">
                    Kontak Support
                </a>
                <a href="#"
                    class="flex-1 bg-gray-500 text-white text-center py-2 px-3 rounded-lg hover:bg-gray-600 transition-colors duration-300 text-sm font-medium">
                    Dokumentasi
                </a>
            </div>
        </div>
    </div>
@endsection
