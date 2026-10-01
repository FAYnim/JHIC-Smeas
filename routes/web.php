<?php

use App\Http\Controllers\LowonganController;
use App\Http\Controllers\SpmbController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('beranda');

Route::get('/visi-misi', function () {
    return view('visi-misi');
})->name('visi-misi');

Route::get('/struktur-organisasi', function () {
    return view('struktur-organisasi');
})->name('struktur-organisasi');

Route::get('/guru-dan-tenaga-kependidikan', function () {
    return view('guru-dan-tenaga-kependidikan');
})->name('guru-dan-tenaga-kependidikan');

Route::get('/sarana-dan-prasarana', function () {
    return view('sarana-dan-prasarana');
})->name('sarana-dan-prasarana');

Route::get('/jurusan', function () {
    return view('jurusan');
})->name('jurusan');

Route::get('/jurusan/{slug}', function ($slug) {
    return view("jurusan.{$slug}");
})->name('jurusan.detail');

Route::get('/informasi', function () {
    return view('informasi');
})->name('informasi');

Route::get('/informasi/prestasi', function () {
    return view('informasi-prestasi');
})->name('informasi.prestasi');

Route::get('/informasi/akademik', function () {
    return view('informasi-akademik');
})->name('informasi.akademik');

Route::get('/pusat-karir', [LowonganController::class, 'index'])->name('pusat-karir.index');
Route::get('/pusat-karir/lowongan', [LowonganController::class, 'katalogLowongan'])->name('pusat-karir.katalog-lowongan');
Route::get('/pusat-karir/magang', [LowonganController::class, 'katalogMagang'])->name('pusat-karir.katalog-magang');
Route::get('/pusat-karir/mitra', [LowonganController::class, 'katalogMitra'])->name('pusat-karir.katalog-mitra');
Route::get('/pusat-karir/mitra/{slug}', [LowonganController::class, 'detailMitra'])->name('pusat-karir.detail-mitra');
Route::get('/pusat-karir/artikel', [LowonganController::class, 'artikel'])->name('pusat-karir.artikel');
Route::get('/pusat-karir/artikel/{slug}', [LowonganController::class, 'detailArtikel'])->name('pusat-karir.detail-artikel');
Route::get('/pusat-karir/{slug}', [LowonganController::class, 'show'])->name('pusat-karir.detail');
Route::get('/pusat-karir/{slug}/lamar', [LowonganController::class, 'apply'])->name('pusat-karir.lamar');
Route::post('/pusat-karir/{slug}/lamar', [LowonganController::class, 'storeApply'])->name('pusat-karir.store-lamar');

// BLUD - Marketplace produk & jasa jurusan
Route::get('/blud', function () {
    return view('blud.index');
})->name('blud.index');

// SPMB Routes
Route::get('/spmb', [SpmbController::class, 'index'])->name('spmb.index');
Route::get('/spmb/login', [SpmbController::class, 'index'])->name('spmb.login-page');
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
