<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
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

// ==================== DASHBOARD BERDASARKAN ROLE ====================
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->role === 'vendor') {
        return redirect()->route('vendor.dashboard');
    } else {
        return view('user.dashboard'); // Untuk customer
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

    Route::get('/stores', [StoreController::class, 'index'])->name('admin.stores.index');
    Route::put('/stores/{store}/approve', [StoreController::class, 'approve'])->name('admin.stores.approve');
    Route::put('/stores/{store}/reject', [StoreController::class, 'reject'])->name('admin.stores.reject');

    // Shop Request Approval Routes
    Route::get('/shop-requests', [ShopRequestApprovalController::class, 'index'])->name('admin.shop-requests.index');
    Route::get('/shop-requests/{shopRequest}', [ShopRequestApprovalController::class, 'show'])->name('admin.shop-requests.show');
    Route::post('/shop-requests/{shopRequest}/approve', [ShopRequestApprovalController::class, 'approve'])->name('admin.shop-requests.approve');
    Route::post('/shop-requests/{shopRequest}/reject', [ShopRequestApprovalController::class, 'reject'])->name('admin.shop-requests.reject');
    Route::post('/shop-requests/{shopRequest}/reopen', [ShopRequestApprovalController::class, 'reopen'])->name('admin.shop-requests.reopen');
});

// ==================== VENDOR ROUTES ====================
Route::middleware(['auth'])->group(function () {
    // Old store routes
    Route::get('/vendor/store/create', [StoreController::class, 'create'])->name('vendor.store.create');
    Route::post('/vendor/store', [StoreController::class, 'store'])->name('vendor.store.store');

    // New shop request routes (customer apply jadi vendor)
    Route::get('/shop-request/create', [ShopRequestController::class, 'create'])->name('shop-request.create');
    Route::post('/shop-request', [ShopRequestController::class, 'store'])->name('shop-request.store');
    Route::get('/shop-request', [ShopRequestController::class, 'show'])->name('shop-request.show');
    Route::get('/shop-request/edit', [ShopRequestController::class, 'edit'])->name('shop-request.edit');
    Route::put('/shop-request', [ShopRequestController::class, 'update'])->name('shop-request.update');
});

Route::get('/vendor/dashboard', function () {
    return view('vendor.dashboard');
})->middleware(['auth'])->name('vendor.dashboard');

// ==================== PROFILE ROUTES ====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================== CART & CHECKOUT ====================
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show')->middleware('auth');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process')->middleware('auth');
Route::get('/orders/{order}/confirmation', [CheckoutController::class, 'confirmation'])->name('orders.confirmation')->middleware('auth');

// ==================== REVIEW ROUTES ====================
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy')->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/admin/reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
});

// ==================== GUESTBOOK ROUTES ====================
Route::post('/guestbook', [GuestBookController::class, 'store'])->name('guestbook.store');

// ==================== ORDER ROUTES ====================
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// ==================== ADMIN ORDER ROUTES ====================
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [OrderController::class, 'adminShow'])->name('admin.orders.show');
    Route::post('/admin/orders/{order}/ship', [OrderController::class, 'markShipped'])->name('orders.ship');
    Route::post('/admin/orders/{order}/deliver', [OrderController::class, 'markDelivered'])->name('orders.deliver');
});
