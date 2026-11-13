<?php

use Illuminate\Support\Facades\Route;
use Modules\KelolaKios\Http\Controllers\KelolaKiosController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('kelola-kios')
    ->name('kelola-kios.')
    ->group(function () {
        Route::get('/', [KelolaKiosController::class, 'index'])->name('index');
        Route::get('/create', [KelolaKiosController::class, 'create'])->name('create');
        Route::post('/', [KelolaKiosController::class, 'store'])->name('store');
        Route::get('/{kios}', [KelolaKiosController::class, 'show'])->whereNumber('kios')->name('show');
        Route::get('/{kios}/edit', [KelolaKiosController::class, 'edit'])->whereNumber('kios')->name('edit');
        Route::put('/{kios}', [KelolaKiosController::class, 'update'])->whereNumber('kios')->name('update');
        Route::delete('/{kios}', [KelolaKiosController::class, 'destroy'])->whereNumber('kios')->name('destroy');
    });
