<?php

use App\Http\Controllers\LowonganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pusat-karir', [LowonganController::class, 'index'])->name('pusat-karir.index');
Route::get('/pusat-karir/{slug}', [LowonganController::class, 'show'])->name('pusat-karir.detail');
