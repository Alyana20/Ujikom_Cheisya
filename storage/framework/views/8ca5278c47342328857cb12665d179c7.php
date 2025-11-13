<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Toko Alat Kesehatan - <?php echo e($title ?? 'Marketplace'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .dropdown {
            position: relative;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 0.5rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            z-index: 50;
        }
        .dropdown:hover .dropdown-menu,
        .dropdown.active .dropdown-menu {
            display: block;
        }
        .dropdown-menu a,
        .dropdown-menu button {
            display: block;
            width: 100%;
            text-align: left;
            padding: 0.75rem 1rem;
            color: #374151;
            transition: all 0.2s;
        }
        .dropdown-menu a:hover,
        .dropdown-menu button:hover {
            background: #f3f4f6;
            color: #2563eb;
        }
        .dropdown-menu a:first-child {
            border-radius: 0.5rem 0.5rem 0 0;
        }
        .dropdown-menu button:last-child {
            border-radius: 0 0 0.5rem 0.5rem;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <i class="fas fa-stethoscope text-blue-600 text-2xl mr-2"></i>
                    <span class="text-xl font-bold text-gray-800">Toko Alat Kesehatan</span>
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-6">
                    <a href="<?php echo e(route('home')); ?>" class="text-gray-600 hover:text-blue-600 font-medium">
                        <i class="fas fa-home mr-1"></i> Home
                    </a>
                    <a href="<?php echo e(route('products.index')); ?>" class="text-gray-600 hover:text-blue-600 font-medium">
                        <i class="fas fa-box mr-1"></i> Produk
                    </a>

                    <?php if(auth()->guard()->check()): ?>
                        <!-- Cart Icon with Badge -->
                        <a href="<?php echo e(route('cart.index')); ?>" class="relative text-gray-600 hover:text-blue-600 font-medium">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <?php
                                $cartCount = \App\Models\Cart::where('user_id', Auth::id())->count();
                            ?>
                            <?php if($cartCount > 0): ?>
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                    <?php echo e($cartCount); ?>

                                </span>
                            <?php endif; ?>
                        </a>

                        <!-- User Menu Dropdown -->
                        <div class="dropdown">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 font-medium focus:outline-none">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white">
                                    <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                                </div>
                                <span><?php echo e(Auth::user()->name); ?></span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>

                            <div class="dropdown-menu">
                                <!-- User Info -->
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <p class="text-sm font-medium text-gray-900"><?php echo e(Auth::user()->name); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e(Auth::user()->email); ?></p>
                                    <span class="inline-block mt-1 px-2 py-1 text-xs font-semibold rounded-full 
                                        <?php echo e(Auth::user()->role === 'admin' ? 'bg-red-100 text-red-800' : 
                                           (Auth::user()->role === 'vendor' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800')); ?>">
                                        <?php echo e(ucfirst(Auth::user()->role)); ?>

                                    </span>
                                </div>

                                <!-- Menu Items -->
                                <?php if(Auth::user()->role === 'admin'): ?>
                                    <a href="<?php echo e(route('admin.dashboard')); ?>">
                                        <i class="fas fa-tachometer-alt mr-2"></i> Admin Dashboard
                                    </a>
                                <?php elseif(Auth::user()->role === 'vendor'): ?>
                                    <a href="<?php echo e(route('vendor.dashboard')); ?>">
                                        <i class="fas fa-store mr-2"></i> Vendor Dashboard
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('home')); ?>">
                                        <i class="fas fa-shopping-bag mr-2"></i> Belanja
                                    </a>
                                    <a href="<?php echo e(route('cart.index')); ?>">
                                        <i class="fas fa-shopping-cart mr-2"></i> Keranjang
                                    </a>
                                    <a href="<?php echo e(route('orders.index')); ?>">
                                        <i class="fas fa-receipt mr-2"></i> Pesanan Saya
                                    </a>
                                <?php endif; ?>

                                <!-- Logout Button -->
                                <form method="POST" action="<?php echo e(route('logout')); ?>" class="m-0">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-700 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Untuk visitor -->
                        <a href="<?php echo e(route('login')); ?>" class="text-gray-600 hover:text-blue-600 font-medium">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </a>
                        <a href="<?php echo e(route('register')); ?>"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-user-plus mr-1"></i> Daftar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- About -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Toko Alat Kesehatan</h3>
                    <p class="text-gray-300 text-sm">
                        Platform terpercaya untuk kebutuhan alat kesehatan Anda.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?php echo e(route('home')); ?>" class="text-gray-300 hover:text-white">Home</a></li>
                        <li><a href="<?php echo e(route('products.index')); ?>" class="text-gray-300 hover:text-white">Produk</a></li>
                        <li><a href="<?php echo e(route('login')); ?>" class="text-gray-300 hover:text-white">Login</a></li>
                    </ul>
                </div>

                <!-- Admin Access -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Admin Area</h3>
                    <a href="<?php echo e(route('admin.login')); ?>" 
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-4 py-2 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition text-sm">
                        <i class="fas fa-shield-alt"></i>
                        <span>Login Admin</span>
                    </a>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-400">
                <p>&copy; 2024 Toko Alat Kesehatan. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Dropdown Toggle Script -->
    <script>
        // Toggle dropdown on click (for mobile)
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.querySelector('.dropdown');
            const dropdownButton = dropdown?.querySelector('button');
            
            if (dropdownButton) {
                dropdownButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('active');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('active');
                    }
                });
            }

            // Confirm logout
            const logoutForm = document.querySelector('form[action="<?php echo e(route('logout')); ?>"]');
            if (logoutForm) {
                logoutForm.addEventListener('submit', function(e) {
                    if (!confirm('Apakah Anda yakin ingin logout?')) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
</body>

</html>
<?php /**PATH D:\PERKULIAHAN\LSP\Ujikom_Cheisya\resources\views/layouts/marketplace.blade.php ENDPATH**/ ?>