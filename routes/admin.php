<?php

use App\Http\Controllers\Admin\Bkk\BimbinganController;
use App\Http\Controllers\Admin\Bkk\LamaranController;
use App\Http\Controllers\Admin\Bkk\LowonganController;
use App\Http\Controllers\Admin\Bkk\MitraController;
use App\Http\Controllers\Admin\Bkk\SumberRekomendasiController;
use App\Http\Controllers\Admin\Bkk\TracerController;
use App\Http\Controllers\Admin\Blud\ModerasiController;
use App\Http\Controllers\Admin\Blud\PesananController;
use App\Http\Controllers\Admin\Blud\ProdukBludController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Humas\ArtikelController;
use App\Http\Controllers\Admin\Humas\FasilitasController;
use App\Http\Controllers\Admin\Humas\GuruController;
use App\Http\Controllers\Admin\Humas\StrukturOrganisasiController;
use App\Http\Controllers\Admin\Humas\WebinarController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\Spmb\CalonSiswaController;
use App\Http\Controllers\Admin\Spmb\FaqController;
use App\Http\Controllers\Admin\Spmb\PengumumanController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('role:bkk')->group(function () {
    Route::get('lamaran', [LamaranController::class, 'index'])->name('lamaran.index');
    Route::patch('lamaran/{application}/status', [LamaranController::class, 'updateStatus'])->name('lamaran.update-status');

    Route::patch('lowongan/{lowongan}/toggle-publish', [LowonganController::class, 'togglePublish'])->name('lowongan.toggle-publish');
    Route::resource('lowongan', LowonganController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('mitra', MitraController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('bimbingan', BimbinganController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::prefix('tracer')->name('tracer.')->group(function () {
        Route::get('/', [TracerController::class, 'index'])->name('index');
        Route::get('alumni/create', [TracerController::class, 'createAlumni'])->name('alumni.create');
        Route::post('alumni', [TracerController::class, 'storeAlumni'])->name('alumni.store');
        Route::get('alumni/{alumni}/edit', [TracerController::class, 'editAlumni'])->name('alumni.edit');
        Route::put('alumni/{alumni}', [TracerController::class, 'updateAlumni'])->name('alumni.update');
        Route::delete('alumni/{alumni}', [TracerController::class, 'destroyAlumni'])->name('alumni.destroy');

        Route::patch('kuesioner/{kuesioner}/toggle-confirm', [TracerController::class, 'toggleConfirmKuesioner'])->name('kuesioner.toggle-confirm');
        Route::put('settings', [TracerController::class, 'updateSettings'])->name('settings.store');
    });

    Route::get('sumber-rekomendasi', [SumberRekomendasiController::class, 'index'])->name('sumber-rekomendasi.index');
    Route::post('sumber-rekomendasi', [SumberRekomendasiController::class, 'store'])->name('sumber-rekomendasi.store');
    Route::delete('sumber-rekomendasi/{sumberRekomendasi}', [SumberRekomendasiController::class, 'destroy'])->name('sumber-rekomendasi.destroy');
});

Route::middleware('role:humas')->group(function () {
    Route::patch('guru/{guru}/toggle-active', [GuruController::class, 'toggleActive'])->name('guru.toggle-active');
    Route::resource('guru', GuruController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('struktur-organisasi', StrukturOrganisasiController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('fasilitas', FasilitasController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('artikel', ArtikelController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::patch('webinar/{webinar}/toggle-publish', [WebinarController::class, 'togglePublish'])->name('webinar.toggle-publish');
    Route::resource('webinar', WebinarController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

Route::middleware('role:spmb')->group(function () {
    Route::get('calon-siswa', [CalonSiswaController::class, 'index'])->name('calon-siswa.index');
    Route::get('calon-siswa/{calonSiswa}', [CalonSiswaController::class, 'show'])->name('calon-siswa.show');
    Route::patch('calon-siswa/{calonSiswa}/verifikasi', [CalonSiswaController::class, 'updateVerifikasi'])->name('calon-siswa.update-verifikasi');

    Route::patch('pengumuman/{pengumuman}/toggle-publish', [PengumumanController::class, 'togglePublish'])->name('pengumuman.toggle-publish');
    Route::resource('pengumuman', PengumumanController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('faq', FaqController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

Route::middleware('role:blud')->group(function () {
    Route::get('produk-blud', [ProdukBludController::class, 'index'])->name('produk-blud.index');
    Route::get('produk-blud/create', [ProdukBludController::class, 'create'])->name('produk-blud.create');
    Route::post('produk-blud', [ProdukBludController::class, 'store'])->name('produk-blud.store');
    Route::get('produk-blud/{produkBlud}/edit', [ProdukBludController::class, 'edit'])->name('produk-blud.edit');
    Route::put('produk-blud/{produkBlud}', [ProdukBludController::class, 'update'])->name('produk-blud.update');
    Route::delete('produk-blud/{produkBlud}', [ProdukBludController::class, 'destroy'])->name('produk-blud.destroy');
    Route::patch('produk-blud/{produkBlud}/toggle-publish', [ProdukBludController::class, 'togglePublish'])->name('produk-blud.toggle-publish');

    Route::get('pesanan-blud', [PesananController::class, 'index'])->name('pesanan-blud.index');
    Route::get('pesanan-blud/{pesanan}', [PesananController::class, 'show'])->name('pesanan-blud.show');
    Route::patch('pesanan-blud/{pesanan}', [PesananController::class, 'update'])->name('pesanan-blud.update');
    Route::delete('pesanan-blud/{pesanan}', [PesananController::class, 'destroy'])->name('pesanan-blud.destroy');

    Route::get('moderasi-blud', [ModerasiController::class, 'index'])->name('moderasi-blud.index');
    Route::patch('moderasi-blud/komentar/{komentar}/tindak-lanjut', [ModerasiController::class, 'tindakLanjutKomentar'])->name('moderasi-blud.tindak-lanjut-komentar');
    Route::patch('moderasi-blud/laporan/{laporan}/tindak-lanjut', [ModerasiController::class, 'tindakLanjutLaporan'])->name('moderasi-blud.tindak-lanjut-laporan');
    Route::delete('moderasi-blud/komentar/{komentar}', [ModerasiController::class, 'destroyKomentar'])->name('moderasi-blud.destroy-komentar');
    Route::delete('moderasi-blud/laporan/{laporan}', [ModerasiController::class, 'destroyLaporan'])->name('moderasi-blud.destroy-laporan');
});

Route::middleware('role:admin')->group(function () {

    Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});
