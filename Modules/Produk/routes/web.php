<?php

use Illuminate\Support\Facades\Route;
use Modules\Produk\Http\Controllers\ProdukController;

Route::middleware(['auth', 'role:admin,user'])
    ->prefix('produk')
    ->name('produk.')
    ->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('index');
        Route::get('/data', [ProdukController::class, 'data'])->name('data');
        Route::get('/{produk}', [ProdukController::class, 'show'])->whereNumber('produk')->name('show');
        Route::post('/', [ProdukController::class, 'store'])->name('store');
        Route::match(['put', 'patch', 'post'], '/{produk}', [ProdukController::class, 'update'])->whereNumber('produk')->name('update');
        Route::delete('/{produk}', [ProdukController::class, 'destroy'])->whereNumber('produk')->name('destroy');
    });
