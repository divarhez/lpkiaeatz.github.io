<?php

use Illuminate\Support\Facades\Route; // Tambahkan baris ini
use App\Http\Controllers\MenuController;
use App\Http\Controllers\StokMakananController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', [MenuController::class, 'index'])->name('menu.index');
Route::post('/cart/add/{id}', [MenuController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [MenuController::class, 'showCart'])->name('cart.show');
Route::post('/cart/update/{id}', [MenuController::class, 'updateCart'])->name('cart.update');
Route::get('/cart/remove/{id}', [MenuController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/checkout', [MenuController::class, 'checkout'])->name('checkout');
Route::get('/search', [MenuController::class, 'search'])->name('menu.search');

Route::middleware(['auth', 'petugas'])->group(function () {
    Route::resource('stok-makanan', StokMakananController::class);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
