

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">
            <i class="fas fa-shopping-cart mr-3 text-blue-600"></i>
            Keranjang Belanja
        </h1>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if($cartItems->count() > 0): ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Daftar Produk (<?php echo e($cartItems->count()); ?> item)</h2>
                <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex gap-4 border-b pb-4 mb-4">
                        <div class="w-20 h-20">
                            <?php if($item->product->image): ?>
                                <?php if(str_starts_with($item->product->image, 'http')): ?>
                                    <img src="<?php echo e($item->product->image); ?>" alt="<?php echo e($item->product->name); ?>" class="w-full h-full object-cover rounded">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('storage/' . $item->product->image)); ?>" alt="<?php echo e($item->product->name); ?>" class="w-full h-full object-cover rounded">
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-bold"><?php echo e($item->product->name); ?></h3>
                            <p class="text-sm text-gray-600"><?php echo e($item->product->store->name); ?></p>
                            <p class="text-blue-600 font-bold mt-2">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></p>
                        </div>
                        <div class="text-right">
                            <form action="<?php echo e(route('cart.update', $item)); ?>" method="POST" class="mb-2">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="flex items-center gap-2">
                                    <input type="number" name="quantity" value="<?php echo e($item->quantity); ?>" min="1" max="<?php echo e($item->product->stock); ?>" class="w-16 border rounded px-2 py-1 text-center">
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">Update</button>
                                </div>
                            </form>
                            <p class="text-sm font-bold mb-2">Subtotal: Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></p>
                            <form action="<?php echo e(route('cart.remove', $item)); ?>" method="POST" onsubmit="return confirm('Hapus produk?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 text-sm hover:text-red-800">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    <h2 class="text-xl font-bold mb-4">Ringkasan</h2>
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span>Total Item:</span>
                            <span class="font-bold"><?php echo e($cartItems->count()); ?></span>
                        </div>
                        <div class="flex justify-between text-lg border-t pt-2">
                            <span class="font-bold">Total:</span>
                            <span class="font-bold text-blue-600">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                        </div>
                    </div>
                    <a href="<?php echo e(route('checkout')); ?>" class="block w-full bg-green-600 text-white text-center py-3 rounded-lg font-bold hover:bg-green-700 mb-2">
                        <i class="fas fa-credit-card mr-2"></i> Checkout
                    </a>
                    <a href="<?php echo e(route('products.index')); ?>" class="block w-full bg-gray-200 text-gray-700 text-center py-2 rounded-lg hover:bg-gray-300">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
            <h2 class="text-2xl font-bold mb-2">Keranjang Kosong</h2>
            <p class="text-gray-600 mb-6">Belum ada produk di keranjang</p>
            <a href="<?php echo e(route('products.index')); ?>" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700">
                <i class="fas fa-shopping-bag mr-2"></i> Mulai Belanja
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.marketplace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PERKULIAHAN\LSP\Ujikom_Cheisya\resources\views/customer/cart/index.blade.php ENDPATH**/ ?>