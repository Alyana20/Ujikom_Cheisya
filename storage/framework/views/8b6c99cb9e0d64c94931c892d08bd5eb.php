

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <i class="fas fa-home mr-2"></i>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="<?php echo e(route('cart.index')); ?>" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Keranjang</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Checkout</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-credit-card mr-3 text-green-600"></i>
            Checkout
        </h1>
        <p class="text-gray-600 mt-2">Lengkapi informasi pengiriman Anda</p>
    </div>

    <?php if(session('error')): ?>
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <p class="font-semibold mb-2">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Terjadi kesalahan:
            </p>
            <ul class="list-disc list-inside text-sm">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('checkout.process')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Shipping Information -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-blue-600 text-white px-6 py-4">
                        <h2 class="text-xl font-bold">
                            <i class="fas fa-shipping-fast mr-2"></i>
                            Informasi Pengiriman
                        </h2>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Shipping Address -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Alamat Pengiriman <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                name="shipping_address" 
                                rows="4" 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500"
                                placeholder="Masukkan alamat lengkap pengiriman..."
                                required><?php echo e(old('shipping_address')); ?></textarea>
                            <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Nomor Telepon <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="phone"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500"
                                placeholder="08xxxxxxxxxx"
                                value="<?php echo e(old('phone')); ?>"
                                required>
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea 
                                name="notes" 
                                rows="3" 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500"
                                placeholder="Tambahkan catatan untuk penjual..."><?php echo e(old('notes')); ?></textarea>
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-3">
                                Metode Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-3">
                                <!-- COD Option -->
                                <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input 
                                        type="radio" 
                                        name="payment_method" 
                                        value="cod" 
                                        class="w-5 h-5 text-blue-600 focus:ring-blue-500" 
                                        <?php echo e(old('payment_method', 'cod') == 'cod' ? 'checked' : ''); ?>

                                        required>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-bold text-gray-800">
                                                    <i class="fas fa-money-bill-wave mr-2 text-green-600"></i>
                                                    Cash on Delivery (COD)
                                                </p>
                                                <p class="text-sm text-gray-600 mt-1">Bayar saat barang diterima</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <!-- Midtrans Option -->
                                <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input 
                                        type="radio" 
                                        name="payment_method" 
                                        value="midtrans" 
                                        class="w-5 h-5 text-blue-600 focus:ring-blue-500"
                                        <?php echo e(old('payment_method') == 'midtrans' ? 'checked' : ''); ?>>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-bold text-gray-800">
                                                    <i class="fas fa-credit-card mr-2 text-blue-600"></i>
                                                    Transfer Bank / E-Wallet
                                                </p>
                                                <p class="text-sm text-gray-600 mt-1">Via Midtrans (BCA, Mandiri, BNI, GoPay, dll)</p>
                                            </div>
                                            <img src="https://midtrans.com/assets/img/midtrans-logo.svg" alt="Midtrans" class="h-6">
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-100 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-box mr-2"></i>
                            Produk yang Dipesan (<?php echo e($cartItems->count()); ?> item)
                        </h2>
                    </div>

                    <div class="divide-y divide-gray-200">
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-4 flex items-center gap-4">
                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    <?php if($item->product->image): ?>
                                        <?php if(str_starts_with($item->product->image, 'http')): ?>
                                            <img src="<?php echo e($item->product->image); ?>" alt="<?php echo e($item->product->name); ?>" class="w-16 h-16 object-cover rounded">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('storage/' . $item->product->image)); ?>" alt="<?php echo e($item->product->name); ?>" class="w-16 h-16 object-cover rounded">
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Product Info -->
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-gray-800"><?php echo e($item->product->name); ?></h3>
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-store mr-1"></i>
                                        <?php echo e($item->product->store->name); ?>

                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <?php echo e($item->quantity); ?> x Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?>

                                    </p>
                                </div>

                                <!-- Subtotal -->
                                <div class="text-right">
                                    <p class="font-bold text-blue-600">
                                        Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?>

                                    </p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <!-- Order Summary & Submit -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md overflow-hidden sticky top-4">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-4">
                        <h2 class="text-xl font-bold">
                            <i class="fas fa-receipt mr-2"></i>
                            Ringkasan Pesanan
                        </h2>
                    </div>

                    <div class="p-6">
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-semibold">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Ongkos Kirim</span>
                                <span class="font-semibold text-green-600">Gratis</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3 mt-3">
                                <div class="flex justify-between text-xl font-bold text-gray-800">
                                    <span>Total</span>
                                    <span class="text-green-600">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-bold py-4 px-6 rounded-lg shadow-lg transition transform hover:scale-105">
                            <i class="fas fa-check-circle mr-2"></i>
                            Buat Pesanan
                        </button>

                        <a href="<?php echo e(route('cart.index')); ?>" class="block w-full mt-3 bg-gray-200 hover:bg-gray-300 text-gray-700 text-center font-semibold py-3 px-6 rounded-lg transition">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Keranjang
                        </a>

                        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                            <p class="text-xs text-gray-600">
                                <i class="fas fa-info-circle mr-1 text-blue-600"></i>
                                Pesanan akan diproses setelah konfirmasi pembayaran
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.marketplace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PERKULIAHAN\LSP\Ujikom_Cheisya\resources\views/customer/cart/checkout.blade.php ENDPATH**/ ?>