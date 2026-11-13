<?php

use Illuminate\Support\Facades\Route;
use Modules\Produk\Http\Controllers\ProdukController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('produks', ProdukController::class)->names('produk');
});
