<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\StokMakananController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\OrderHistoryController;

// Auth routes
Auth::routes();

// Public routes
Route::get('/', [MenuController::class, 'index'])->name('menu.index');
Route::get('/search', [MenuController::class, 'search'])->name('menu.search');

// Route untuk tambah tenant (khusus petugas)
Route::middleware(['auth', 'petugas'])->group(function () {
    Route::get('/tenant/create', [TenantController::class, 'create'])->name('tenant.create');
    Route::post('/tenant', [TenantController::class, 'store'])->name('tenant.store');
});

Route::prefix('cart')->group(function () {
    Route::get('/', [MenuController::class, 'showCart'])->name('cart.show');
    Route::post('/add/{id}', [MenuController::class, 'addToCart'])->name('cart.add');
    Route::post('/update/{id}', [MenuController::class, 'updateCart'])->name('cart.update');
    Route::get('/remove/{id}', [MenuController::class, 'removeFromCart'])->name('cart.remove');
});
Route::post('/checkout', [MenuController::class, 'checkout'])->name('checkout');

// Protected routes for petugas
Route::middleware(['auth', 'petugas'])->prefix('stok-makanan')->name('stok-makanan.')->group(function () {
    Route::get('/', [StokMakananController::class, 'index'])->name('index');
    Route::get('/create', [StokMakananController::class, 'create'])->name('create');
    Route::post('/', [StokMakananController::class, 'store'])->name('store');
    Route::get('/{stok_makanan}/edit', [StokMakananController::class, 'edit'])->name('edit');
    Route::put('/{stok_makanan}', [StokMakananController::class, 'update'])->name('update');
    Route::delete('/{stok_makanan}', [StokMakananController::class, 'destroy'])->name('destroy');
});

// Home route
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/tenant/{id}', [TenantController::class, 'show'])->name('tenant.show');
Route::get('/tenants', [TenantController::class, 'index'])->name('tenant.index');

// Route untuk menampilkan form tambah menu (khusus petugas)
Route::middleware(['auth', 'petugas'])->group(function () {
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
});

// Route untuk halaman profil user
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/orders/history', [OrderHistoryController::class, 'index'])->name('orders.history');
});

// Dashboard admin untuk petugas
Route::middleware(['auth', 'petugas'])->get('/admin/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Route manajemen menu untuk admin/petugas
Route::middleware(['auth', 'petugas'])->get('/admin/menu-management', [MenuController::class, 'management'])->name('admin.menu.management');
Route::middleware(['auth', 'petugas'])->get('/admin/menu-management/edit/{id}', [MenuController::class, 'edit'])->name('admin.menu.edit');
Route::middleware(['auth', 'petugas'])->post('/admin/menu-management/update/{id}', [MenuController::class, 'update'])->name('admin.menu.update');
Route::middleware(['auth', 'petugas'])->post('/admin/menu-management/delete/{id}', [MenuController::class, 'destroy'])->name('admin.menu.delete');

// Route untuk memberi rating pada menu yang sudah dibeli
Route::middleware(['auth'])->post('/transaction-items/{id}/rate', [\App\Http\Controllers\TransactionItemController::class, 'rate'])->name('transaction-items.rate');

// Route untuk mengambil voucher yang tersedia (opsional, bisa untuk AJAX)
Route::get('/vouchers/available', [\App\Http\Controllers\VoucherController::class, 'available'])->name('vouchers.available');
