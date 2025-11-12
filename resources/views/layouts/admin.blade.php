<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - OSS Healthcare Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-item.active {
            background-color: rgba(59, 130, 246, 0.1);
            border-left: 4px solid #3b82f6;
            color: #3b82f6;
        }

        .mobile-menu-btn {
            display: none;
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 40;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay {
                display: none;
            }

            .sidebar.open+.sidebar-overlay {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 30;
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex flex-col min-h-screen">
        <!-- Header - Z-index tertinggi -->
        <header class="bg-gradient-to-r from-primary-600 to-primary-700 text-white shadow-lg sticky top-0 z-50">
            <div class="container mx-auto px-4 py-3">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <button id="mobileMenuBtn"
                            class="mobile-menu-btn text-white p-2 rounded-md hover:bg-primary-500">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div>
                            <h1 class="text-xl md:text-2xl font-bold">OSS Healthcare</h1>
                            <p class="text-primary-100 text-sm">Admin Panel</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="hidden md:flex flex-col items-end">
                            <span class="font-medium">{{ Auth::user()->name }}</span>
                            <span class="text-primary-200 text-sm">Administrator</span>
                        </div>
                        <div class="relative group">
                            <div class="flex items-center space-x-2 cursor-pointer p-2 rounded-lg hover:bg-primary-500">
                                <div class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </div>
                            <div
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                    <p class="font-medium">{{ Auth::user()->name }}</p>
                                    <p class="text-gray-500">Admin</p>
                                </div>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i>Pengaturan
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex flex-1 relative">
            <!-- Sidebar Overlay untuk mobile -->
            <div id="sidebarOverlay" class="sidebar-overlay"></div>

            <!-- Sidebar - Z-index lebih rendah dari header -->
            <aside id="sidebar" class="sidebar bg-gray-800 text-white w-64 min-h-screen fixed md:relative z-40">
                <div class="p-6 border-b border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center">
                            <i class="fas fa-user-md text-white"></i>
                        </div>
                        <div>
                            <h2 class="font-bold">Admin Panel</h2>
                            <p class="text-gray-400 text-xs">OSS Healthcare</p>
                        </div>
                    </div>
                </div>

                <nav class="p-4">
                    <div class="mb-6">
                        <h3 class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-2">Menu Utama</h3>
                        <ul class="space-y-1">
                            <li>
                                <a href="#"
                                    class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg transition duration-200 hover:bg-gray-700">
                                    <i class="fas fa-tachometer-alt w-5 text-center"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.users.index') }}"
                                    class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg transition duration-200 hover:bg-gray-700">
                                    <i class="fas fa-users w-5 text-center"></i>
                                    <span>Kelola User</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.stores.index') }}"
                                    class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg transition duration-200 hover:bg-gray-700">
                                    <i class="fas fa-store w-5 text-center"></i>
                                    <span>Kelola Toko</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg transition duration-200 hover:bg-gray-700">
                                    <i class="fas fa-box w-5 text-center"></i>
                                    <span>Kelola Produk</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-2">Laporan</h3>
                        <ul class="space-y-1">
                            <li>
                                <a href="#"
                                    class="flex items-center space-x-3 py-3 px-4 rounded-lg transition duration-200 hover:bg-gray-700">
                                    <i class="fas fa-chart-bar w-5 text-center"></i>
                                    <span>Statistik</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center space-x-3 py-3 px-4 rounded-lg transition duration-200 hover:bg-gray-700">
                                    <i class="fas fa-file-alt w-5 text-center"></i>
                                    <span>Laporan Harian</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-2">Pengaturan</h3>
                        <ul class="space-y-1">
                            <li>
                                <a href="#"
                                    class="flex items-center space-x-3 py-3 px-4 rounded-lg transition duration-200 hover:bg-gray-700">
                                    <i class="fas fa-cog w-5 text-center"></i>
                                    <span>Pengaturan Sistem</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-6 md:p-8 bg-gray-50 min-h-screen">
                <div class="max-w-7xl mx-auto">
                    <!-- Breadcrumb -->
                    <div class="mb-6">
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a href="#"
                                        class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-primary-600">
                                        <i class="fas fa-home mr-2"></i>
                                        Home
                                    </a>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                        <span
                                            class="ml-1 text-sm font-medium text-gray-500 md:ml-2">@yield('title')</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Page Header -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
                        <p class="text-gray-600">Kelola data dan pengaturan sistem OSS Healthcare</p>
                    </div>

                    <!-- Content -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('hidden');
        });

        // Close sidebar when clicking overlay
        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.remove('open');
            overlay.classList.add('hidden');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const overlay = document.getElementById('sidebarOverlay');

            if (window.innerWidth <= 768 &&
                !sidebar.contains(event.target) &&
                !mobileMenuBtn.contains(event.target) &&
                sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
                overlay.classList.add('hidden');
            }
        });

        // Set active menu item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.sidebar-item');

            menuItems.forEach(item => {
                if (item.getAttribute('href') === currentPath) {
                    item.classList.add('active');
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (window.innerWidth > 768) {
                sidebar.classList.remove('open');
                overlay.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
