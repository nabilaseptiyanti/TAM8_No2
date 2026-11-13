<?php

use Illuminate\Support\Facades\Route;
use Modules\KelolaKios\Http\Controllers\KelolaKiosController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('kelolakios', KelolaKiosController::class)->names('kelolakios');
});
