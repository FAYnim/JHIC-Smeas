<?php

use App\Http\Controllers\Admin\Bkk\LamaranController;
use App\Http\Controllers\Admin\Bkk\LowonganController;
use App\Http\Controllers\Admin\Bkk\MitraController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('role:bkk')->group(function () {
    Route::get('lamaran', [LamaranController::class, 'index'])->name('lamaran.index');
    Route::patch('lamaran/{application}/status', [LamaranController::class, 'updateStatus'])->name('lamaran.update-status');

    Route::patch('lowongan/{lowongan}/toggle-publish', [LowonganController::class, 'togglePublish'])->name('lowongan.toggle-publish');
    Route::resource('lowongan', LowonganController::class);

    Route::resource('mitra', MitraController::class);
});
