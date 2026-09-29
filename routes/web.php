<?php

use App\Http\Controllers\LowonganController;
use App\Http\Controllers\SpmbController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pusat-karir', [LowonganController::class, 'index'])->name('pusat-karir.index');
Route::get('/pusat-karir/{slug}', [LowonganController::class, 'show'])->name('pusat-karir.detail');

Route::get('/spmb', [SpmbController::class, 'index'])->name('spmb.index');
Route::post('/spmb/login', [SpmbController::class, 'login'])->name('spmb.login');

Route::get('/spmb/dashboard', [SpmbController::class, 'dashboard'])->name('spmb.dashboard');
Route::get('/spmb/biodata', [SpmbController::class, 'biodata'])->name('spmb.biodata');
Route::post('/spmb/biodata', [SpmbController::class, 'saveBiodata'])->name('spmb.save-biodata');
Route::get('/spmb/orang-tua', [SpmbController::class, 'orangTua'])->name('spmb.orang-tua');
Route::post('/spmb/orang-tua', [SpmbController::class, 'saveOrangTua'])->name('spmb.save-orang-tua');
Route::get('/spmb/dokumen', [SpmbController::class, 'dokumen'])->name('spmb.dokumen');
Route::post('/spmb/dokumen', [SpmbController::class, 'saveDokumen'])->name('spmb.save-dokumen');
Route::get('/spmb/formulir', [SpmbController::class, 'formulir'])->name('spmb.formulir');
Route::post('/spmb/formulir', [SpmbController::class, 'saveFormulir'])->name('spmb.save-formulir');
Route::get('/spmb/verifikasi', [SpmbController::class, 'verifikasi'])->name('spmb.verifikasi');
Route::get('/spmb/pengumuman', [SpmbController::class, 'pengumuman'])->name('spmb.pengumuman');
Route::get('/spmb/bantuan', [SpmbController::class, 'bantuan'])->name('spmb.bantuan');
