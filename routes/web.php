<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ShopRequestApprovalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShopRequestController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==================== VISITOR/MARKETPLACE ROUTES ====================
// Halaman utama untuk visitor (tanpa auth)
Route::get('/', [ProductController::class, 'home'])->name('home');

// Halaman produk untuk visitor (tanpa auth)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{category:slug}', [ProductController::class, 'byCategory'])->name('products.byCategory');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// ==================== AUTH ROUTES ====================
require __DIR__ . '/auth.php';

// ==================== ADMIN AUTH ROUTES (Terpisah) ====================
use App\Http\Controllers\Admin\AdminAuthController;

Route::prefix('admin')->group(function () {
    // Admin Login Routes (tanpa middleware auth)
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// ==================== VENDOR AUTH ROUTES (Terpisah) ====================
use App\Http\Controllers\Vendor\VendorAuthController;

Route::prefix('vendor')->group(function () {
    // Vendor Login Routes (tanpa middleware auth)
    Route::get('/login', [VendorAuthController::class, 'showLoginForm'])->name('vendor.login');
    Route::post('/login', [VendorAuthController::class, 'login'])->name('vendor.login.submit');
    
    // Vendor Register Routes (tanpa middleware auth)
    Route::get('/register', [VendorAuthController::class, 'showRegisterForm'])->name('vendor.register');
    Route::post('/register', [VendorAuthController::class, 'register'])->name('vendor.register.submit');
    
    // Vendor Logout (dengan middleware auth)
    Route::post('/logout', [VendorAuthController::class, 'logout'])->name('vendor.logout')->middleware('auth');
});

// ==================== DASHBOARD BERDASARKAN ROLE ====================
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->role === 'vendor') {
        return redirect()->route('vendor.dashboard');
    } else {
        // Untuk customer, redirect ke home
        return redirect()->route('home');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->middleware(['auth', 'verified', 'is_admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/stores', [AdminStoreController::class, 'index'])->name('admin.stores.index');
    Route::put('/stores/{store}/approve', [AdminStoreController::class, 'approve'])->name('admin.stores.approve');
    Route::put('/stores/{store}/reject', [AdminStoreController::class, 'reject'])->name('admin.stores.reject');
    Route::put('/stores/{store}/toggle-active', [AdminStoreController::class, 'toggleActive'])->name('admin.stores.toggle-active');

    // Product Management Routes
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::put('/products/{product}/ban', [AdminProductController::class, 'ban'])->name('admin.products.ban');
    Route::put('/products/{product}/unban', [AdminProductController::class, 'unban'])->name('admin.products.unban');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

    // Shop Request Approval Routes
    Route::get('/shop-requests', [ShopRequestApprovalController::class, 'index'])->name('admin.shop-requests.index');
    Route::get('/shop-requests/{shopRequest}', [ShopRequestApprovalController::class, 'show'])->name('admin.shop-requests.show');
    Route::post('/shop-requests/{shopRequest}/approve', [ShopRequestApprovalController::class, 'approve'])->name('admin.shop-requests.approve');
    Route::post('/shop-requests/{shopRequest}/reject', [ShopRequestApprovalController::class, 'reject'])->name('admin.shop-requests.reject');
    Route::post('/shop-requests/{shopRequest}/reopen', [ShopRequestApprovalController::class, 'reopen'])->name('admin.shop-requests.reopen');
});

// ==================== VENDOR ROUTES ====================
use App\Http\Controllers\Vendor\VendorProfileController;
use App\Http\Controllers\Vendor\VendorProductController;

Route::middleware(['auth'])->group(function () {
    // Shop request routes (customer apply jadi vendor)
    Route::get('/shop-request/create', [ShopRequestController::class, 'create'])->name('shop-request.create');
    Route::post('/shop-request', [ShopRequestController::class, 'store'])->name('shop-request.store');
    Route::get('/shop-request', [ShopRequestController::class, 'show'])->name('shop-request.show');
    Route::get('/shop-request/edit', [ShopRequestController::class, 'edit'])->name('shop-request.edit');
    Route::put('/shop-request', [ShopRequestController::class, 'update'])->name('shop-request.update');
});

Route::get('/vendor/dashboard', function () {
    return view('vendor.dashboard');
})->middleware(['auth'])->name('vendor.dashboard');

// Vendor Profile Routes
Route::prefix('vendor')->middleware(['auth'])->group(function () {
    Route::get('/profile', [VendorProfileController::class, 'index'])->name('vendor.profile.index');
    Route::get('/profile/edit', [VendorProfileController::class, 'edit'])->name('vendor.profile.edit');
    Route::put('/profile/personal', [VendorProfileController::class, 'updatePersonal'])->name('vendor.profile.update-personal');
    Route::put('/profile/store', [VendorProfileController::class, 'updateStore'])->name('vendor.profile.update-store');
    Route::put('/profile/password', [VendorProfileController::class, 'updatePassword'])->name('vendor.profile.update-password');
    
    // Product Management Routes
    Route::get('/products', [VendorProductController::class, 'index'])->name('vendor.products.index');
    Route::get('/products/create', [VendorProductController::class, 'create'])->name('vendor.products.create');
    Route::post('/products', [VendorProductController::class, 'store'])->name('vendor.products.store');
    Route::get('/products/{product}/edit', [VendorProductController::class, 'edit'])->name('vendor.products.edit');
    Route::put('/products/{product}', [VendorProductController::class, 'update'])->name('vendor.products.update');
    Route::delete('/products/{product}', [VendorProductController::class, 'destroy'])->name('vendor.products.destroy');
    Route::patch('/products/{product}/toggle-status', [VendorProductController::class, 'toggleStatus'])->name('vendor.products.toggle-status');
    
    // Order Management Routes
    Route::get('/orders', [\App\Http\Controllers\Vendor\VendorOrderController::class, 'index'])->name('vendor.orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Vendor\VendorOrderController::class, 'show'])->name('vendor.orders.show');
    Route::patch('/orders/{order}/status', [\App\Http\Controllers\Vendor\VendorOrderController::class, 'updateStatus'])->name('vendor.orders.update-status');
});

// ==================== PROFILE ROUTES ====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================== REVIEW ROUTES ====================
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy')->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/admin/reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
});

// ==================== GUESTBOOK ROUTES ====================
Route::post('/guestbook', [GuestBookController::class, 'store'])->name('guestbook.store');

// ==================== CART ROUTES ====================
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');
});

// ==================== ORDER ROUTES ====================
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');
});

// ==================== PAYMENT ROUTES ====================
use App\Http\Controllers\PaymentController;

Route::middleware('auth')->group(function () {
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/pending', [PaymentController::class, 'pending'])->name('payment.pending');
});

Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

// ==================== ADMIN ORDER ROUTES ====================
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [OrderController::class, 'adminShow'])->name('admin.orders.show');
    Route::post('/admin/orders/{order}/ship', [OrderController::class, 'markShipped'])->name('orders.ship');
    Route::post('/admin/orders/{order}/deliver', [OrderController::class, 'markDelivered'])->name('orders.deliver');
});
