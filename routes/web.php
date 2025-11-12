<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProductController; // ✅ TAMBAHKAN INI
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==================== VISITOR/MARKETPLACE ROUTES ====================
// Halaman utama untuk visitor (tanpa auth)
Route::get('/', [ProductController::class, 'home'])->name('home');

// Halaman produk untuk visitor (tanpa auth)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
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
});

// ==================== VENDOR ROUTES ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/vendor/store/create', [StoreController::class, 'create'])->name('vendor.store.create');
    Route::post('/vendor/store', [StoreController::class, 'store'])->name('vendor.store.store');
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
