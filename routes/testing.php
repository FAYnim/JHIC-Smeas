<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/admin-humas-only', [DashboardController::class, 'index'])
        ->middleware('role:humas')
        ->name('testing.humas-only');

    Route::get('/admin-bkk-or-humas', [DashboardController::class, 'index'])
        ->middleware('role:bkk,humas')
        ->name('testing.bkk-or-humas');
});

Route::get('/admin', [DashboardController::class, 'index'])->middleware('auth')->name('testing.admin');

Route::get('/__login-stub', fn () => 'ok')->name('login');
