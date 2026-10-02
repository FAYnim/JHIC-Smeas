<?php

use App\Http\Controllers\Admin\Bkk\BimbinganController;
use App\Http\Controllers\Admin\Bkk\LamaranController;
use App\Http\Controllers\Admin\Bkk\LowonganController;
use App\Http\Controllers\Admin\Bkk\MitraController;
use App\Http\Controllers\Admin\Bkk\TracerController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('role:bkk')->group(function () {
    Route::get('lamaran', [LamaranController::class, 'index'])->name('lamaran.index');
    Route::patch('lamaran/{application}/status', [LamaranController::class, 'updateStatus'])->name('lamaran.update-status');

    Route::patch('lowongan/{lowongan}/toggle-publish', [LowonganController::class, 'togglePublish'])->name('lowongan.toggle-publish');
    Route::resource('lowongan', LowonganController::class);

    Route::resource('mitra', MitraController::class);

    Route::resource('bimbingan', BimbinganController::class);

    Route::prefix('tracer')->name('tracer.')->group(function () {
        Route::get('/', [TracerController::class, 'index'])->name('index');
        Route::get('alumni/create', [TracerController::class, 'createAlumni'])->name('alumni.create');
        Route::post('alumni', [TracerController::class, 'storeAlumni'])->name('alumni.store');
        Route::get('alumni/{alumni}/edit', [TracerController::class, 'editAlumni'])->name('alumni.edit');
        Route::put('alumni/{alumni}', [TracerController::class, 'updateAlumni'])->name('alumni.update');
        Route::delete('alumni/{alumni}', [TracerController::class, 'destroyAlumni'])->name('alumni.destroy');

        Route::patch('kuesioner/{kuesioner}/toggle-confirm', [TracerController::class, 'toggleConfirmKuesioner'])->name('kuesioner.toggle-confirm');
        Route::put('settings', [TracerController::class, 'updateSettings'])->name('settings.update');
    });
});
