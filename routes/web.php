<?php

use App\Http\Controllers\MenuController;
Route::get('/', [MenuController::class, 'index'])->name('menu.index');
Route::post('/cart/add/{id}', [MenuController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [MenuController::class, 'showCart'])->name('cart.show');
Route::post('/cart/update/{id}', [MenuController::class, 'updateCart'])->name('cart.update');
Route::get('/cart/remove/{id}', [MenuController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/checkout', [MenuController::class, 'checkout'])->name('checkout');
Route::get('/search', [MenuController::class, 'search'])->name('menu.search');
