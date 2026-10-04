<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BludController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\SpmbController;
use App\Models\Alumni;
use App\Models\Artikel;
use App\Models\Fasilitas;
use App\Models\Guru;
use App\Models\Lowongan;
use App\Models\MitraPerusahaan;
use App\Models\Pengumuman;
use App\Models\Setting;
use App\Models\StrukturOrganisasi;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest')->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::get('/', function () {
    $artikels = Artikel::latest('published_at')->take(4)->get();
    $gurus = Guru::where('kategori', 'guru')->where('is_active', true)
        ->orderBy('urutan')->limit(4)->get();
    $gurusCount = Guru::where('is_active', true)->count();
    $prakata = [
        'nama' => Setting::get('profil.prakata_nama', 'Dr. Drs. Anton Sujarwo, M.Pd.'),
        'quote' => Setting::get('profil.prakata_quote', 'Era globalisasi membawa perubahan yang cepat dalam berbagai aspek kehidupan. Oleh karena itu, pendidikan memiliki peran penting dalam menyiapkan sumber daya manusia yang mampu menghadapi perubahan tersebut. Sekolah perlu memiliki arah pengembangan yang jelas dan berkelanjutan, sekaligus mampu menyesuaikan diri dengan kebutuhan dan permasalahan masyarakat saat ini.'),
        'foto' => Setting::get('profil.prakata_foto', 'images/Group 198.png'),
    ];

    return view('index', compact('artikels', 'prakata', 'gurus', 'gurusCount'));
})->name('beranda');

Route::get('/visi-misi', function () {
    $visi = Setting::get('profil.visi', 'Terwujudnya SMK Negeri 1 Surabaya Yang Berkarakter Dan Unggul.');
    $misi = Setting::get('profil.misi', null);

    return view('visi-misi', compact('visi', 'misi'));
})->name('visi-misi');

Route::get('/struktur-organisasi', function () {
    $kepala = StrukturOrganisasi::where('kategori', 'kepala')->orderBy('urutan')->first();
    $wakil = StrukturOrganisasi::where('kategori', 'wakil')->orderBy('urutan')->get();
    $bagian = StrukturOrganisasi::where('kategori', 'bagian')->orderBy('urutan')->get();

    return view('struktur-organisasi', compact('kepala', 'wakil', 'bagian'));
})->name('struktur-organisasi');

Route::get('/guru-dan-tenaga-kependidikan', function () {
    $guru = Guru::where('kategori', 'guru')->where('is_active', true)->orderBy('urutan')->get();
    $tendik = Guru::where('kategori', 'tendik')->where('is_active', true)->orderBy('urutan')->get();

    return view('guru-dan-tenaga-kependidikan', compact('guru', 'tendik'));
})->name('guru-dan-tenaga-kependidikan');

Route::get('/sarana-dan-prasarana', function () {
    $fasilitasPembelajaran = Fasilitas::where('kategori', 'pembelajaran')->orderBy('urutan')->get();
    $fasilitasPendukung = Fasilitas::where('kategori', 'pendukung')->orderBy('urutan')->get();

    return view('sarana-dan-prasarana', compact('fasilitasPembelajaran', 'fasilitasPendukung'));
})->name('sarana-dan-prasarana');

Route::get('/jurusan', function () {
    $totalLowongan = Lowongan::where('is_published', true)->count();
    $totalAlumni = Alumni::count();
    $totalMitra = MitraPerusahaan::count();

    return view('jurusan.index', compact('totalLowongan', 'totalAlumni', 'totalMitra'));
})->name('jurusan');

Route::get('/jurusan/{slug}', function (string $slug) {
    $view = "jurusan.{$slug}";
    if (! view()->exists($view)) {
        abort(404);
    }

    return view($view);
})->name('jurusan.detail');

Route::get('/informasi', function () {
    $artikels = Artikel::where('kategori', 'berita')->latest('published_at')->limit(6)->get();
    $pengumumans = Pengumuman::latest()->limit(5)->get();

    return view('informasi', compact('artikels', 'pengumumans'));
})->name('informasi');

Route::get('/informasi/prestasi', function () {
    $artikels = Artikel::where('kategori', 'prestasi')->latest('published_at')->limit(6)->get();
    $pengumumans = Pengumuman::latest()->limit(5)->get();

    return view('informasi-prestasi', compact('artikels', 'pengumumans'));
})->name('informasi.prestasi');

Route::get('/informasi/akademik', function () {
    $artikels = Artikel::where('kategori', 'akademik')->latest('published_at')->limit(6)->get();
    $pengumumans = Pengumuman::latest()->limit(5)->get();

    return view('informasi-akademik', compact('artikels', 'pengumumans'));
})->name('informasi.akademik');

Route::get('/pusat-karir', [LowonganController::class, 'index'])->name('pusat-karir.index');
Route::get('/pusat-karir/lowongan', [LowonganController::class, 'katalogLowongan'])->name('pusat-karir.katalog-lowongan');
Route::get('/pusat-karir/magang', [LowonganController::class, 'katalogMagang'])->name('pusat-karir.katalog-magang');
Route::get('/pusat-karir/mitra', [LowonganController::class, 'katalogMitra'])->name('pusat-karir.katalog-mitra');
Route::get('/pusat-karir/mitra/{slug}', [LowonganController::class, 'detailMitra'])->name('pusat-karir.detail-mitra');
Route::get('/pusat-karir/artikel', [LowonganController::class, 'artikel'])->name('pusat-karir.artikel');
Route::get('/pusat-karir/artikel/{slug}', [LowonganController::class, 'detailArtikel'])->name('pusat-karir.detail-artikel');
Route::get('/pusat-karir/study-tracer', [LowonganController::class, 'studyTracer'])->name('pusat-karir.study-tracer');
Route::get('/pusat-karir/study-tracer/kuesioner', [LowonganController::class, 'formKuesioner'])->name('pusat-karir.study-tracer.kuesioner');
Route::post('/pusat-karir/study-tracer/kuesioner', [LowonganController::class, 'storeKuesioner'])->name('pusat-karir.study-tracer.store');
Route::post('/pusat-karir/verifikasi-nisn', [LowonganController::class, 'verifikasiNisn'])
    ->middleware('throttle:10,1')
    ->name('pusat-karir.verifikasi-nisn');
Route::get('/pusat-karir/{slug}', [LowonganController::class, 'show'])->name('pusat-karir.detail');
Route::get('/pusat-karir/{slug}/lamar', [LowonganController::class, 'apply'])->name('pusat-karir.lamar');
Route::post('/pusat-karir/{slug}/lamar', [LowonganController::class, 'storeApply'])->name('pusat-karir.store-lamar');
Route::get('/pusat-karir/lamaran/{registrationCode}/bukti', [LowonganController::class, 'unduhBukti'])->name('pusat-karir.bukti-lamar');

// BLUD - Marketplace produk & jasa jurusan
Route::get('/blud', [BludController::class, 'index'])->name('blud.index');
Route::get('/blud/{slug}', [BludController::class, 'detail'])->where('slug', '[a-z0-9\-]+')->name('blud.detail');
Route::post('/blud/{slug}/komentar', [BludController::class, 'storeKomentar'])
    ->where('slug', '[a-z0-9\-]+')
    ->middleware('throttle:10,1')
    ->name('blud.komentar.store');
Route::post('/blud/{slug}/penawaran', [BludController::class, 'storePenawaran'])
    ->where('slug', '[a-z0-9\-]+')
    ->middleware('throttle:10,1')
    ->name('blud.penawaran.store');
Route::post('/blud/{slug}/laporkan', [BludController::class, 'storeLaporkan'])
    ->where('slug', '[a-z0-9\-]+')
    ->middleware('throttle:10,1')
    ->name('blud.laporkan.store');

// SPMB Routes
Route::get('/spmb', [SpmbController::class, 'index'])->name('spmb.index');
Route::get('/spmb/login', fn () => redirect()->route('spmb.index'))->name('spmb.login-page');
Route::post('/spmb/login', [SpmbController::class, 'login'])->name('spmb.login');
Route::post('/spmb/logout', [SpmbController::class, 'logout'])->name('spmb.logout');

Route::middleware('spmb.auth')->group(function () {
    Route::get('/spmb/dashboard', [SpmbController::class, 'dashboard'])->name('spmb.dashboard');
    Route::get('/spmb/biodata', [SpmbController::class, 'biodata'])->name('spmb.biodata');
    Route::post('/spmb/biodata', [SpmbController::class, 'saveBiodata'])->name('spmb.save-biodata');
    Route::get('/spmb/orang-tua', [SpmbController::class, 'orangTua'])->name('spmb.orang-tua');
    Route::post('/spmb/orang-tua', [SpmbController::class, 'saveOrangTua'])->name('spmb.save-orang-tua');
    Route::get('/spmb/dokumen', [SpmbController::class, 'dokumen'])->name('spmb.dokumen');
    Route::post('/spmb/dokumen', [SpmbController::class, 'saveDokumen'])->name('spmb.save-dokumen');
    Route::get('/spmb/formulir', [SpmbController::class, 'formulir'])->name('spmb.formulir');
    Route::post('/spmb/formulir', [SpmbController::class, 'saveFormulir'])->name('spmb.save-formulir');
    Route::get('/spmb/formulir/unduh', [SpmbController::class, 'unduhFormulir'])->name('spmb.unduh-formulir');
    Route::get('/spmb/verifikasi', [SpmbController::class, 'verifikasi'])->name('spmb.verifikasi');
    Route::get('/spmb/pengumuman', [SpmbController::class, 'pengumuman'])->name('spmb.pengumuman');
    Route::get('/spmb/bantuan', [SpmbController::class, 'bantuan'])->name('spmb.bantuan');
});

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        require __DIR__.'/admin.php';
    });

if (app()->runningUnitTests()) {
    require __DIR__.'/testing.php';
}

Route::prefix('api/chatbot')->group(function () {
    Route::post('/message', [ChatbotController::class, 'sendMessage'])
        ->middleware('throttle:15,1')
        ->name('chatbot.message');
    Route::post('/reset', [ChatbotController::class, 'resetSession'])
        ->name('chatbot.reset');
});
