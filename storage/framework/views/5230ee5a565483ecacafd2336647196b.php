

<?php $__env->startSection('title', 'Kelola Produk'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="bg-gray-50 rounded-lg p-6 mb-6">
        <form method="GET" action="<?php echo e(route('admin.products.index')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Produk</label>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Nama produk, toko..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Kategori</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Status</option>
                    <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    <option value="banned" <?php echo e(request('status') == 'banned' ? 'selected' : ''); ?>>Banned</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Active</p>
                    <p class="text-2xl font-bold"><?php echo e($products->where('status', 'active')->count()); ?></p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-gray-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Inactive</p>
                    <p class="text-2xl font-bold"><?php echo e($products->where('status', 'inactive')->count()); ?></p>
                </div>
                <div class="bg-gray-100 p-3 rounded-lg">
                    <i class="fas fa-eye-slash text-gray-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Banned</p>
                    <p class="text-2xl font-bold"><?php echo e($products->where('status', 'banned')->count()); ?></p>
                </div>
                <div class="bg-red-100 p-3 rounded-lg">
                    <i class="fas fa-ban text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Produk</p>
                    <p class="text-2xl font-bold"><?php echo e($products->total()); ?></p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="fas fa-box text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Toko</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <?php if($product->image): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" class="h-12 w-12 rounded object-cover">
                                <?php else: ?>
                                    <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($product->name); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e(Str::limit($product->description, 50)); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900"><?php echo e($product->store->name); ?></div>
                            <div class="text-sm text-gray-500"><?php echo e($product->store->user->name); ?></div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($product->category ? $product->category->name : '-'); ?></td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($product->stock); ?></td>
                        <td class="px-6 py-4">
                            <?php if($product->status === 'active'): ?>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Active
                                </span>
                            <?php elseif($product->status === 'inactive'): ?>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <i class="fas fa-eye-slash mr-1"></i> Inactive
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-ban mr-1"></i> Banned
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <?php if($product->status !== 'banned'): ?>
                                    <form action="<?php echo e(route('admin.products.ban', $product->id)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" onclick="return confirm('Ban produk ini? Produk tidak akan muncul di marketplace.')" class="bg-red-600 text-white px-3 py-1.5 rounded hover:bg-red-700 text-sm">
                                            <i class="fas fa-ban mr-1"></i>Ban
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form action="<?php echo e(route('admin.products.unban', $product->id)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <button type="submit" onclick="return confirm('Unban produk ini?')" class="bg-green-600 text-white px-3 py-1.5 rounded hover:bg-green-700 text-sm">
                                            <i class="fas fa-check mr-1"></i>Unban
                                        </button>
                                    </form>
                                <?php endif; ?>
                                <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" onclick="return confirm('Hapus produk ini secara permanen?')" class="bg-gray-600 text-white px-3 py-1.5 rounded hover:bg-gray-700 text-sm">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <i class="fas fa-box text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-500 text-lg">Tidak ada produk ditemukan</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($products->hasPages()): ?>
        <div class="mt-4">
            <?php echo e($products->links()); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PERKULIAHAN\LSP\Ujikom_Cheisya\resources\views/admin/products/index.blade.php ENDPATH**/ ?>