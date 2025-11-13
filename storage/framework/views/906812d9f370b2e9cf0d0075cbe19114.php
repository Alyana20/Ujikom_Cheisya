<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Katalog Produk Kesehatan</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Temukan berbagai alat kesehatan, obat, dan suplemen berkualitas untuk kebutuhan Anda
            </p>
        </div>

        <!-- Stats Bar -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                <div>
                    <div class="text-2xl font-bold text-blue-600"><?php echo e($products->total()); ?></div>
                    <div class="text-gray-600 text-sm">Total Produk</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-600">
                        <?php echo e($products->where('stok', '>', 0)->count()); ?>

                    </div>
                    <div class="text-gray-600 text-sm">Tersedia</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-purple-600">4</div>
                    <div class="text-gray-600 text-sm">Kategori</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-orange-600">100%</div>
                    <div class="text-gray-600 text-sm">Produk Asli</div>
                </div>
            </div>
        </div>

        <!-- Categories Filter -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Filter by Kategori:</h3>
            <div class="flex flex-wrap gap-3">
                <a href="<?php echo e(route('products.index')); ?>"
                    class="px-6 py-3 <?php echo e(!$selectedCategory ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?> rounded-full font-semibold transition duration-200 flex items-center">
                    <i class="fas fa-layer-group mr-2"></i> Semua
                </a>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('products.byCategory', $category->slug)); ?>"
                        class="px-6 py-3 <?php echo e($selectedCategory && $selectedCategory->id === $category->id ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?> rounded-full font-semibold transition duration-200 flex items-center">
                        <?php echo e($category->icon ?? '📦'); ?> <?php echo e($category->name); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Products Grid -->
        <?php if($products->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div
                        class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                        <!-- Product Image -->
                        <a href="<?php echo e(route('products.show', $product)); ?>" class="block relative">
                            <div class="h-64 bg-gray-100 overflow-hidden">
                                <?php if($product->gambar): ?>
                                    <img src="<?php echo e($product->gambar); ?>" alt="<?php echo e($product->nama); ?>"
                                        class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                                <?php else: ?>
                                    <div
                                        class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                        <?php if($product->kategori == 'Obat'): ?>
                                            <i class="fas fa-pills text-gray-400 text-5xl"></i>
                                        <?php elseif($product->kategori == 'Suplemen'): ?>
                                            <i class="fas fa-capsules text-gray-400 text-5xl"></i>
                                        <?php elseif($product->kategori == 'Alat Terapi'): ?>
                                            <i class="fas fa-stethoscope text-gray-400 text-5xl"></i>
                                        <?php else: ?>
                                            <i class="fas fa-medkit text-gray-400 text-5xl"></i>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-white/90 backdrop-blur-sm text-gray-700 text-xs px-3 py-1.5 rounded-full font-semibold shadow-sm">
                                    <?php echo e($product->kategori); ?>

                                </span>
                            </div>

                            <!-- Stock Badge -->
                            <div class="absolute top-4 right-4">
                                <?php if($product->stok > 0): ?>
                                    <span
                                        class="bg-green-500 text-white text-xs px-3 py-1.5 rounded-full font-semibold shadow-sm">
                                        <i class="fas fa-check mr-1"></i> Stok <?php echo e($product->stok); ?>

                                    </span>
                                <?php else: ?>
                                    <span
                                        class="bg-red-500 text-white text-xs px-3 py-1.5 rounded-full font-semibold shadow-sm">
                                        <i class="fas fa-times mr-1"></i> Habis
                                    </span>
                                <?php endif; ?>
                            </div>
                        </a>

                        <!-- Product Info -->
                        <div class="p-6">
                            <!-- Store Info -->
                            <div class="flex items-center mb-3">
                                <i class="fas fa-store text-gray-400 text-sm mr-2"></i>
                                <span class="text-gray-500 text-sm"><?php echo e($product->store->nama); ?></span>
                            </div>

                            <!-- Product Name -->
                            <a href="<?php echo e(route('products.show', $product)); ?>" class="hover:text-blue-600 block mb-3">
                                <h3 class="font-bold text-lg text-gray-800 line-clamp-2 leading-tight"><?php echo e($product->nama); ?>

                                </h3>
                            </a>

                            <!-- Description -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed"><?php echo e($product->deskripsi); ?>

                            </p>

                            <!-- Price -->
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <span class="text-2xl font-bold text-blue-600">Rp
                                        <?php echo e(number_format($product->harga, 0, ',', '.')); ?></span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="<?php echo e(route('products.show', $product)); ?>"
                                    class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-xl font-semibold hover:bg-blue-700 transition duration-200 text-center flex items-center justify-center">
                                    <i class="fas fa-eye mr-2"></i> Detail
                                </a>

                                <?php if(auth()->guard()->check()): ?>
                                    <?php if($product->stok > 0): ?>
                                        <button
                                            class="bg-green-600 text-white py-3 px-4 rounded-xl font-semibold hover:bg-green-700 transition duration-200 flex items-center justify-center">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    <?php else: ?>
                                        <button disabled
                                            class="bg-gray-400 text-white py-3 px-4 rounded-xl font-semibold cursor-not-allowed flex items-center justify-center">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="<?php echo e(route('login')); ?>"
                                        class="bg-gray-600 text-white py-3 px-4 rounded-xl font-semibold hover:bg-gray-700 transition duration-200 flex items-center justify-center">
                                        <i class="fas fa-sign-in-alt"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <?php echo e($products->links()); ?>

                </div>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="bg-white rounded-2xl shadow-sm p-12 max-w-md mx-auto">
                    <i class="fas fa-search text-gray-400 text-6xl mb-6"></i>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-4">Produk Tidak Ditemukan</h3>
                    <p class="text-gray-500 mb-6">Silakan coba dengan kategori atau kata kunci lain</p>
                    <a href="<?php echo e(route('products.index')); ?>"
                        class="bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-700 transition duration-200 inline-flex items-center">
                        <i class="fas fa-refresh mr-2"></i> Lihat Semua Produk
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <!-- CTA Section -->
        <div class="mt-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-center text-white">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">Butuh Produk Kesehatan Lainnya?</h2>
            <p class="text-lg mb-6 opacity-90">Hubungi kami untuk konsultasi produk kesehatan</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://wa.me/6281234567890"
                    class="bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition duration-300 inline-flex items-center justify-center">
                    <i class="fab fa-whatsapp text-xl mr-3"></i> Chat WhatsApp
                </a>
                <a href="tel:+6281234567890"
                    class="bg-white/20 text-white px-8 py-4 rounded-xl font-semibold hover:bg-white/30 transition duration-300 inline-flex items-center justify-center border border-white/30">
                    <i class="fas fa-phone-alt mr-3"></i> Telepon Sekarang
                </a>
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Custom Pagination Styles */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 4px;
        }

        .pagination li a,
        .pagination li span {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }

        .pagination li a {
            background: white;
            color: #4b5563;
            border: 1px solid #e5e7eb;
        }

        .pagination li a:hover {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .pagination li span {
            background: #3b82f6;
            color: white;
            border: 1px solid #3b82f6;
        }

        .pagination li .text-blue-600 {
            color: #3b82f6 !important;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketplace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PERKULIAHAN\LSP\Ujikom_Cheisya\resources\views/visitor/products/index.blade.php ENDPATH**/ ?>