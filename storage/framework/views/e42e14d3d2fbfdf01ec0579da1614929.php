<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold">
                <i class="fas fa-receipt mr-3 text-blue-600"></i>
                Pesanan Saya
            </h1>
            <p class="text-gray-600 mt-2">Lihat dan kelola semua pesanan Anda</p>
        </div>

        <!-- Success/Error Messages -->
        <?php if(session('success')): ?>
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-3 text-xl"></i>
                <span class="font-semibold"><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-lg flex items-center">
                <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                <span class="font-semibold"><?php echo e(session('error')); ?></span>
            </div>
        <?php endif; ?>

        <?php if($orders->count() > 0): ?>
            <div class="space-y-4">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Order ID</p>
                                <p class="text-lg font-bold text-gray-800">#<?php echo e($order->id); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal</p>
                                <p class="text-lg font-semibold text-gray-800"><?php echo e($order->created_at->format('d M Y')); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="text-lg font-bold text-blue-600">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <p class="mt-1">
                                    <?php if($order->isPending()): ?>
                                        <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full font-semibold">Pending</span>
                                    <?php elseif($order->isPaid()): ?>
                                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full font-semibold">Dibayar</span>
                                    <?php elseif($order->isShipped()): ?>
                                        <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full font-semibold">Dikirim</span>
                                    <?php elseif($order->isDelivered()): ?>
                                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-semibold">Selesai</span>
                                    <?php elseif($order->isCancelled()): ?>
                                        <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full font-semibold">Dibatalkan</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="text-right space-y-2">
                                <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                                    <i class="fas fa-eye mr-2"></i>Detail
                                </a>
                                <?php if($order->canCancel()): ?>
                                    <form action="<?php echo e(route('orders.cancel', $order->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                                            <i class="fas fa-times-circle mr-2"></i>Batalkan
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="border-t pt-3 text-sm text-gray-600 flex items-center justify-between">
                            <div>
                                <i class="fas fa-box mr-2"></i><?php echo e($order->items->count()); ?> item |
                                <i class="fas fa-credit-card ml-3 mr-2"></i><?php echo e($order->payment_status === 'pending' ? 'Menunggu Pembayaran' : 'Dibayar via ' . strtoupper($order->payment_method)); ?>

                            </div>
                            <?php if($order->canCancel()): ?>
                                <span class="text-xs text-yellow-600 font-semibold">
                                    <i class="fas fa-info-circle mr-1"></i>Dapat dibatalkan
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <?php echo e($orders->links()); ?>

            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-shopping-bag text-gray-300 text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Pesanan</h2>
                <p class="text-gray-600 mb-6">Anda belum melakukan pemesanan. Mulai belanja sekarang!</p>
                <a href="<?php echo e(route('products.index')); ?>" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                    <i class="fas fa-shopping-cart mr-2"></i>Mulai Belanja
                </a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketplace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PERKULIAHAN\LSP\Ujikom_Cheisya\resources\views/customer/orders/index.blade.php ENDPATH**/ ?>