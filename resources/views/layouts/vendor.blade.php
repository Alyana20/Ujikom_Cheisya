<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vendor Dashboard') - Toko Alat Kesehatan</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        .sidebar-link.active {
            background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);
            color: white;
        }
        .sidebar-link:hover {
            background: #f0fdf4;
            color: #10b981;
        }
        .sidebar-link.active:hover {
            background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
            color: white;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-gradient-to-r from-green-600 to-teal-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo/Brand -->
                <div class="flex items-center">
                    <a href="{{ route('vendor.dashboard') }}" class="flex items-center space-x-3">
                        <i class="fas fa-store-alt text-3xl"></i>
                        <span class="font-bold text-xl">Vendor Panel</span>
                    </a>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="relative p-2 rounded-full hover:bg-white/20 transition">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            0
                        </span>
                    </button>

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-3 hover:bg-white/20 rounded-lg px-3 py-2 transition">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </span>
                            </div>
                            <div class="hidden md:block text-left">
                                <div class="text-sm font-semibold">{{ Auth::user()->name }}</div>
                                <div class="text-xs opacity-80">Vendor</div>
                            </div>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-50"
                             style="display: none;">
                            <a href="{{ route('vendor.profile.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-700">
                                <i class="fas fa-user-circle mr-2"></i>
                                Profil Saya
                            </a>
                            <a href="{{ route('vendor.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-700">
                                <i class="fas fa-tachometer-alt mr-2"></i>
                                Dashboard
                            </a>
                            <hr class="my-2">
                            <form action="{{ route('vendor.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb (Optional) -->
    @if(isset($breadcrumbs))
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-sm text-gray-600">
                @foreach($breadcrumbs as $label => $url)
                    @if(!$loop->last)
                        <a href="{{ $url }}" class="hover:text-green-600">{{ $label }}</a>
                        <span class="mx-2">/</span>
                    @else
                        <span class="text-gray-900 font-semibold">{{ $label }}</span>
                    @endif
                @endforeach
            </nav>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-600 text-sm mb-4 md:mb-0">
                    <i class="fas fa-copyright mr-1"></i>
                    {{ date('Y') }} Toko Alat Kesehatan. All rights reserved.
                </div>
                <div class="flex space-x-6 text-sm text-gray-600">
                    <a href="{{ route('home') }}" class="hover:text-green-600">
                        <i class="fas fa-home mr-1"></i>
                        Beranda
                    </a>
                    <a href="#" class="hover:text-green-600">
                        <i class="fas fa-question-circle mr-1"></i>
                        Bantuan
                    </a>
                    <a href="#" class="hover:text-green-600">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Privacy
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js for dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('scripts')
</body>
</html>
