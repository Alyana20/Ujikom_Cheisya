<?php $__env->startSection("title", "Detail Pesanan #" . $order->id); ?>

<?php $__env->startSection("content"); ?>
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Detail Pesanan #<?php echo e($order->id); ?></h1>
                <p class="text-gray-600"><?php echo e($order->created_at->format("d F Y, H:i")); ?></p>
            </div>
            <a href="<?php echo e(route("vendor.orders.index")); ?>" class="text-blue-600 hover:text-blue-800">
                &larr; Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded shadow overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Produk yang Dipesan</h2>
                </div>
                <div class="p-6">
                    <table class="w-full">
                        <thead class="border-b">
                            <tr>
                                <th class="pb-3 text-left text-sm font-medium text-gray-500">Produk</th>
                                <th class="pb-3 text-right text-sm font-medium text-gray-500">Harga</th>
                                <th class="pb-3 text-center text-sm font-medium text-gray-500">Jumlah</th>
                                <th class="pb-3 text-right text-sm font-medium text-gray-500">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="py-4">
                                    <div class="font-medium"><?php echo e($item->product ? $item->product->nama : "Produk tidak tersedia"); ?></div>
                                </td>
                                <td class="py-4 text-right">Rp <?php echo e(number_format($item->price, 0, ",", ".")); ?></td>
                                <td class="py-4 text-center"><?php echo e($item->quantity); ?></td>
                                <td class="py-4 text-right font-medium">Rp <?php echo e(number_format($item->subtotal, 0, ",", ".")); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot class="border-t">
                            <tr>
                                <td colspan="3" class="pt-4 text-right font-semibold">Total:</td>
                                <td class="pt-4 text-right font-bold text-lg">
                                    Rp <?php echo e(number_format($order->items->sum("subtotal"), 0, ",", ".")); ?>

                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded shadow overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Informasi Pelanggan</h2>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <div class="text-sm text-gray-600">Nama</div>
                        <div class="font-medium"><?php echo e($order->user->name); ?></div>
                    </div>
                    <div class="mb-4">
                        <div class="text-sm text-gray-600">Email</div>
                        <div class="font-medium"><?php echo e($order->user->email); ?></div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">Alamat Pengiriman</div>
                        <div class="font-medium"><?php echo e($order->shipping_address ?? "Tidak ada alamat"); ?></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded shadow overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Update Status Pesanan</h2>
                </div>
                <div class="p-6">
                    <?php if(session("success")): ?>
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        <?php echo e(session("success")); ?>

                    </div>
                    <?php endif; ?>

                    <?php if(session("error")): ?>
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <?php echo e(session("error")); ?>

                    </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <div class="text-sm text-gray-600 mb-2">Status Pesanan Saat Ini</div>
                        <?php if($order->status === "pending"): ?>
                            <span class="px-3 py-1 text-sm rounded bg-yellow-100 text-yellow-800">Menunggu</span>
                        <?php elseif($order->status === "paid"): ?>
                            <span class="px-3 py-1 text-sm rounded bg-green-100 text-green-800">Dibayar</span>
                        <?php elseif($order->status === "processing"): ?>
                            <span class="px-3 py-1 text-sm rounded bg-blue-100 text-blue-800">Diproses</span>
                        <?php elseif($order->status === "shipped"): ?>
                            <span class="px-3 py-1 text-sm rounded bg-indigo-100 text-indigo-800">Sedang Dikirim</span>
                        <?php elseif($order->status === "delivered"): ?>
                            <span class="px-3 py-1 text-sm rounded bg-green-100 text-green-800">Sudah Terkirim</span>
                        <?php elseif($order->status === "cancelled"): ?>
                            <span class="px-3 py-1 text-sm rounded bg-red-100 text-red-800">Dibatalkan</span>
                        <?php else: ?>
                            <span class="px-3 py-1 text-sm rounded bg-gray-100 text-gray-800"><?php echo e(ucfirst($order->status)); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <div class="text-sm text-gray-600 mb-2">Status Pembayaran</div>
                        <?php if($order->payment_status === "paid"): ?>
                            <span class="px-3 py-1 text-sm rounded bg-green-100 text-green-800">Sudah Dibayar</span>
                        <?php elseif($order->payment_status === "pending"): ?>
                            <span class="px-3 py-1 text-sm rounded bg-yellow-100 text-yellow-800">Menunggu Pembayaran</span>
                        <?php elseif($order->payment_status === "unpaid"): ?>
                            <span class="px-3 py-1 text-sm rounded bg-red-100 text-red-800">Belum Dibayar</span>
                        <?php else: ?>
                            <span class="px-3 py-1 text-sm rounded bg-gray-100 text-gray-800"><?php echo e(ucfirst($order->payment_status)); ?></span>
                        <?php endif; ?>
                    </div>

                    <?php
                        $canUpdateStatus = ($order->payment_method === "cod" || $order->payment_status === "paid") 
                                        && $order->status !== "cancelled" 
                                        && $order->status !== "delivered";
                    ?>

                    <?php if($canUpdateStatus): ?>
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded">
                        <div class="text-sm text-blue-800 mb-3">
                            <i class="fas fa-info-circle mr-1"></i>
                            Anda dapat mengubah status pesanan ini
                        </div>
                        <form action="<?php echo e(route("vendor.orders.update-status", $order->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field("PATCH"); ?>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ubah Status Pesanan</label>
                            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">-- Pilih Status --</option>
                                <?php if($order->status === "pending" || $order->status === "paid"): ?>
                                <option value="processing">Diproses</option>
                                <?php endif; ?>
                                <?php if($order->status === "processing"): ?>
                                <option value="shipped">Sedang Dikirim</option>
                                <?php endif; ?>
                                <?php if($order->status === "shipped"): ?>
                                <option value="delivered">Sudah Terkirim</option>
                                <?php endif; ?>
                            </select>
                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                                <i class="fas fa-sync-alt mr-2"></i>Update Status
                            </button>
                        </form>
                    </div>
                    <?php else: ?>
                    <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded">
                        <div class="text-sm text-gray-600">
                            <?php if($order->status === "cancelled"): ?>
                                <i class="fas fa-ban mr-1"></i> Pesanan ini telah dibatalkan
                            <?php elseif($order->status === "delivered"): ?>
                                <i class="fas fa-check-circle mr-1"></i> Pesanan telah selesai
                            <?php elseif($order->payment_method !== "cod" && $order->payment_status !== "paid"): ?>
                                <i class="fas fa-clock mr-1"></i> Menunggu pembayaran dari customer
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white rounded shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Informasi Pembayaran</h2>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <div class="text-sm text-gray-600">Metode Pembayaran</div>
                        <div class="font-medium">
                            <?php if($order->payment_method === "cod"): ?>
                                <span class="text-green-600"><i class="fas fa-money-bill-wave mr-1"></i>COD (Cash on Delivery)</span>
                            <?php elseif($order->payment_method === "midtrans"): ?>
                                <span class="text-blue-600"><i class="fas fa-credit-card mr-1"></i>Transfer Bank / E-Wallet</span>
                            <?php else: ?>
                                <?php echo e(strtoupper($order->payment_method)); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if($order->phone): ?>
                    <div class="mb-4">
                        <div class="text-sm text-gray-600">Nomor Telepon</div>
                        <div class="font-medium"><?php echo e($order->phone); ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if($order->notes): ?>
                    <div>
                        <div class="text-sm text-gray-600">Catatan</div>
                        <div class="font-medium"><?php echo e($order->notes); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.vendor", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PERKULIAHAN\LSP\Ujikom_Cheisya\resources\views/vendor/orders/show.blade.php ENDPATH**/ ?>