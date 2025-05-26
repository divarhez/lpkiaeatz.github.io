<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\StokMakananController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TenantController;

// Auth routes
Auth::routes();

// Public routes
Route::get('/', [MenuController::class, 'index'])->name('menu.index');
Route::get('/search', [MenuController::class, 'search'])->name('menu.search');

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
