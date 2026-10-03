<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Artikel;
use App\Models\BimbinganKarir;
use App\Models\KuesionerTracer;
use App\Models\Lowongan;
use App\Models\MagangApplication;
use App\Models\MitraPerusahaan;
use App\Models\TracerMitraAlumnus;
use App\Models\TracerSetting;
use App\Models\TracerStatusLulusan;
use App\Models\Webinar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LowonganController extends Controller
{
    public function index()
    {
        $lowongans = Lowongan::latest()->get();

        $artikels = Artikel::latest('published_at')->take(3)->get();

        $webinars = Webinar::where('is_published', true)->latest('start_date')->get();

        $upcomingWebinar = $webinars
            ->filter(fn (Webinar $w) => $w->start_date->isFuture())
            ->sortBy('start_date')
            ->first();

        $bimbinganKatalog = BimbinganKarir::with('kategori')
            ->where('is_published', true)
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'title' => $item->title,
                    'kategori' => $item->kategori->slug ?? 'umum',
                    'kategori_label' => $item->kategori->nama ?? 'Umum',
                    'type' => 'Materi',
                    'url' => $item->external_url ?? '#',
                ];
            })
            ->all();

        $categories = [
            [
                'name' => 'Magang/Internship',
                'slug' => 'magang',
                'icon' => 'briefcase',
                'count' => Lowongan::where('jenis', 'magang')->count(),
                'unit' => 'program',
                'url' => route('pusat-karir.katalog-magang'),
            ],
            [
                'name' => 'Lowongan Kerja',
                'slug' => 'lowongan',
                'icon' => 'briefcase',
                'count' => Lowongan::where('jenis', 'lowongan')->count(),
                'unit' => 'lowongan',
                'url' => route('pusat-karir.katalog-lowongan'),
            ],
            [
                'name' => 'Mitra Perusahaan',
                'slug' => 'mitra',
                'icon' => 'building-office',
                'count' => MitraPerusahaan::where('is_mou_active', true)->count(),
                'unit' => 'mitra',
                'url' => route('pusat-karir.katalog-mitra'),
            ],
            [
                'name' => 'Bimbingan Karir',
                'slug' => 'bimbingan-karir',
                'icon' => 'academic-cap',
                'count' => count($bimbinganKatalog),
                'unit' => 'materi',
                'url' => '#bimbingan-karir',
            ],
            [
                'name' => 'Study Tracer',
                'slug' => 'study-tracer',
                'icon' => 'chart-bar',
                'count' => 1,
                'unit' => 'program',
                'url' => route('pusat-karir.study-tracer'),
            ],
        ];

        return view('pusat-karir.pusat-karir', compact(
            'lowongans',
            'artikels',
            'webinars',
            'upcomingWebinar',
            'categories',
            'bimbinganKatalog'
        ));
    }

    public function show(string $slug)
    {
        $lowongan = Lowongan::where('slug', $slug)->firstOrFail();

        return view('pusat-karir.detail-lowongan', compact('lowongan'));
    }

    public function apply(string $slug)
    {
        $lowongan = Lowongan::where('slug', $slug)->firstOrFail();

        return view('pusat-karir.lamar-lowongan', compact('lowongan'));
    }

    public function storeApply(Request $request, string $slug): RedirectResponse|JsonResponse
    {
        $lowongan = Lowongan::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'nisn' => ['required', 'numeric', 'digits:10'],
        ]);

        $application = MagangApplication::create([
            'lowongan_id' => $lowongan->id,
            'nisn' => $validated['nisn'],
            'registration_code' => $this->generateRegistrationCode($lowongan->company_short ?? 'TELKOM'),
            'status' => 'pending',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ajuan lamaran magang Anda berhasil dikirim.',
                'data' => [
                    'nisn' => $application->nisn,
                    'registration_code' => $application->registration_code,
                ],
            ], 201);
        }

        return redirect()->route('pusat-karir.detail', $lowongan->slug)
            ->with('lamaran_success', [
                'nisn' => $application->nisn,
                'registration_code' => $application->registration_code,
            ]);
    }

    public function katalogLowongan(Request $request)
    {
        $tipeOptions = [
            'Full-time (Purnawaktu)',
            'Part-time (Paruhwaktu)',
            'Kontrak (PKWT)',
            'Freelance / Proyek',
        ];
        $pengalamanOptions = [
            'Fresh Graduate Welcome',
            'Minimal 1-2 Tahun',
            'Berbasis Portofolio Proyek',
        ];
        $bidangOptions = [
            'Software & IT Solusi',
            'Desain Kreatif & Media',
            'Jaringan & Infrastruktur',
            'Administrasi & Keuangan',
        ];
        $jenjangOptions = [
            'SMK / MAK Sederajat',
            'Terbuka D3 / S1 (Lanjutan)',
        ];
        $gajiOptions = [
            'semua' => 'Semua Rentang',
            'umk' => '≥ UMK Surabaya (Rp 4,7 Jt)',
            'tampil' => 'Gaji Ditampilkan Saja',
        ];

        $query = Lowongan::where('jenis', 'lowongan');

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', "%{$q}%")
                    ->orWhere('company_name', 'like', "%{$q}%");
            });
        }

        $selectedTipe = $request->input('tipe');
        if (is_array($selectedTipe)) {
            $query->whereIn('tipe_pekerjaan', $selectedTipe);
        }

        $selectedPengalaman = $request->input('pengalaman');
        if (is_array($selectedPengalaman)) {
            $query->whereIn('pengalaman', $selectedPengalaman);
        }

        $selectedBidang = $request->input('bidang');
        if (is_array($selectedBidang)) {
            $query->whereIn('bidang_industri', $selectedBidang);
        }

        $selectedJenjang = $request->input('jenjang');
        if (is_array($selectedJenjang)) {
            $query->whereIn('jenjang_pendidikan', $selectedJenjang);
        }

        $gajiFilter = $request->input('gaji');
        if ($gajiFilter === 'umk') {
            $query->where('gaji_min', '>=', 4700000);
        } elseif ($gajiFilter === 'tampil') {
            $query->whereNotNull('gaji_min');
        }

        if ($request->input('urut') === 'gaji_desc') {
            $query->orderByDesc('gaji_max')->orderByDesc('gaji_min');
        } else {
            $query->latest();
        }

        $lowongans = $query->paginate(8)->withQueryString();

        return view('pusat-karir.katalog-lowongan', [
            'lowongans' => $lowongans,
            'tipeOptions' => $tipeOptions,
            'pengalamanOptions' => $pengalamanOptions,
            'bidangOptions' => $bidangOptions,
            'jenjangOptions' => $jenjangOptions,
            'gajiOptions' => $gajiOptions,
            'selected' => [
                'tipe' => $selectedTipe ?: [],
                'pengalaman' => $selectedPengalaman ?: [],
                'bidang' => $selectedBidang ?: [],
                'jenjang' => $selectedJenjang ?: [],
                'gaji' => $gajiFilter,
                'q' => $request->input('q'),
                'urut' => $request->input('urut'),
            ],
        ]);
    }

    public function katalogMagang(Request $request)
    {
        $jurusanOptions = [
            'Rekayasa Perangkat Lunak',
            'Sist. Inform., Jar. & Apl (SIJA)',
            'Desain Komunikasi Visual',
            'Animasi & 3D',
            'Akuntansi & Keuangan',
            'Bisnis Daring & Pemasaran',
        ];
        $skemaOptions = [
            'On-site (Surabaya)',
            'Hybrid',
        ];
        $durasiOptions = [
            '6 Bulan (1 Semester Penuh)',
            '3 Bulan (Fase Pendek)',
        ];
        $fasilitasOptions = [
            'Uang Saku Bulanan',
            'Sertifikat Resmi Industri',
            'Mentoring 1-on-1',
        ];

        $query = Lowongan::where('jenis', 'magang');

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', "%{$q}%")
                    ->orWhere('company_name', 'like', "%{$q}%");
            });
        }

        $selectedJurusan = $request->input('jurusan');
        if (is_array($selectedJurusan)) {
            $query->where(function ($builder) use ($selectedJurusan) {
                foreach ($selectedJurusan as $j) {
                    $builder->orWhere('jurusan', 'like', '%'.$j.'%');
                }
            });
        }

        $skema = $request->input('skema');
        if ($skema) {
            $query->where(function ($builder) use ($skema) {
                $builder->where('metode_kerja', 'like', '%'.$skema.'%')
                    ->orWhere('metode_kerja', 'like', '%Hybrid%');
                if (str_contains(strtolower($skema), 'on-site')) {
                    $builder->orWhere('metode_kerja', 'like', '%On-site%');
                }
            });
        }

        $durasi = $request->input('durasi');
        if ($durasi) {
            $query->where('durasi_pelaksanaan', 'like', '%'.Str::before($durasi, ' ').'%');
        }

        $selectedFasilitas = $request->input('fasilitas');
        if (is_array($selectedFasilitas)) {
            $query->where(function ($builder) use ($selectedFasilitas) {
                foreach ($selectedFasilitas as $f) {
                    $builder->orWhere('benefits', 'like', '%'.$f.'%');
                }
            });
        }

        if ($request->boolean('kuota')) {
            $query->where('kuota', '>', 0);
        }

        $query->latest();

        $lowongans = $query->paginate(8)->withQueryString();

        return view('pusat-karir.katalog-magang', [
            'lowongans' => $lowongans,
            'jurusanOptions' => $jurusanOptions,
            'skemaOptions' => $skemaOptions,
            'durasiOptions' => $durasiOptions,
            'fasilitasOptions' => $fasilitasOptions,
            'selected' => [
                'jurusan' => $selectedJurusan ?: [],
                'skema' => $skema,
                'durasi' => $durasi,
                'fasilitas' => $selectedFasilitas ?: [],
                'kuota' => $request->boolean('kuota'),
                'q' => $request->input('q'),
            ],
        ]);
    }

    public function katalogMitra(Request $request)
    {
        $query = MitraPerusahaan::query();

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('city', 'like', "%{$q}%");
            });
        }

        $sector = $request->input('sector');
        if ($sector) {
            $query->where('sector', $sector);
        }

        $program = $request->input('program');
        if ($program) {
            $query->where('programs', 'like', '%'.$program.'%');
        }

        $mitras = $query->latest()->paginate(6)->withQueryString();

        return view('pusat-karir.katalog-mitra', [
            'mitras' => $mitras,
            'totalMitra' => MitraPerusahaan::where('is_mou_active', true)->count(),
            'totalSiswa' => Lowongan::where('jenis', 'magang')->sum('kuota') + 400,
            'totalKelas' => MitraPerusahaan::where('kelas_industri', 'like', '%jurusan_sasaran%')->count(),
        ]);
    }

    public function detailMitra(string $slug)
    {
        $mitra = MitraPerusahaan::where('slug', $slug)->with('lowongans')->firstOrFail();

        return view('pusat-karir.detail-mitra', compact('mitra'));
    }

    public function artikel()
    {
        $artikels = Artikel::latest('published_at')->paginate(9);

        return view('pusat-karir.artikel', [
            'artikels' => $artikels,
            'featured' => $artikels->items()[0] ?? null,
        ]);
    }

    public function detailArtikel(string $slug)
    {
        $artikel = Artikel::where('slug', $slug)->firstOrFail();

        $other = Artikel::where('id', '!=', $artikel->id)->latest('published_at')->take(2)->get();

        return view('pusat-karir.detail-artikel', compact('artikel', 'other'));
    }

    public function studyTracer(): View
    {
        return view('pusat-karir.study-tracer', [
            'setting' => TracerSetting::first(),
            'statuses' => TracerStatusLulusan::orderBy('urutan')->get(),
            'mitras' => TracerMitraAlumnus::orderBy('urutan')->get(),
        ]);
    }

    public function formKuesioner(Request $request): View|RedirectResponse
    {
        if ($request->filled('nisn') && $request->filled('tahun_lulus')) {
            $nisn = $request->string('nisn')->toString();
            $tahunLulus = (int) $request->input('tahun_lulus');

            $alumni = null;
            if (preg_match('/^\d{10}$/', $nisn)) {
                $alumni = Alumni::where('nisn', $nisn)
                    ->where('tahun_lulus', $tahunLulus)
                    ->first();
            }

            if (! $alumni) {
                return back()->withErrors([
                    'nisn' => 'Data alumni tidak ditemukan. Periksa NISN dan tahun kelulusan.',
                ]);
            }

            session(['tracer_verified' => [
                'alumnis_id' => $alumni->id,
                'nisn' => $alumni->nisn,
                'nama' => $alumni->nama,
                'jurusan' => $alumni->jurusan,
                'tahun_lulus' => $alumni->tahun_lulus,
            ]]);

            return view('pusat-karir.kuesioner-tracer', [
                'alumni' => $alumni,
                'verified' => session('tracer_verified'),
                'statusPekerjaanOptions' => KuesionerTracer::STATUS_PEKERJAAN,
                'relevansiOptions' => KuesionerTracer::RELEVANSI,
                'masaTungguOptions' => KuesionerTracer::MASA_TUNGGU,
                'rentangGajiOptions' => KuesionerTracer::RENTANG_GAJI,
            ]);
        }

        return view('pusat-karir.kuesioner-tracer', [
            'alumni' => null,
            'verified' => session('tracer_verified'),
            'statusPekerjaanOptions' => KuesionerTracer::STATUS_PEKERJAAN,
            'relevansiOptions' => KuesionerTracer::RELEVANSI,
            'masaTungguOptions' => KuesionerTracer::MASA_TUNGGU,
            'rentangGajiOptions' => KuesionerTracer::RENTANG_GAJI,
        ]);
    }

    public function storeKuesioner(Request $request): RedirectResponse
    {
        $verified = session('tracer_verified', []);

        $validated = $request->validate([
            'alumnis_id' => ['nullable', 'integer', 'exists:alumnis,id'],
            'nisn' => ['required', 'string', 'digits:10'],
            'nama' => ['required', 'string', 'max:255'],
            'jurusan' => ['required', 'string', 'max:255'],
            'tahun_lulus' => ['required', 'integer'],
            'status_pekerjaan' => ['required', Rule::in(KuesionerTracer::STATUS_PEKERJAAN)],
            'nama_perusahaan' => ['nullable', 'string', 'max:255'],
            'posisi' => ['nullable', 'string', 'max:255'],
            'masa_tunggu' => ['nullable', Rule::in(KuesionerTracer::MASA_TUNGGU)],
            'rentang_gaji' => ['nullable', Rule::in(KuesionerTracer::RENTANG_GAJI)],
            'relevansi' => ['required', Rule::in(KuesionerTracer::RELEVANSI)],
            'saran' => ['nullable', 'string'],
            'is_konfirmasi' => ['required', 'accepted'],
        ]);

        if ($verified !== []) {
            $validated['alumnis_id'] = $verified['alumnis_id'] ?? null;
            $validated['nisn'] = $verified['nisn'];
            $validated['nama'] = $verified['nama'];
            $validated['jurusan'] = $verified['jurusan'];
            $validated['tahun_lulus'] = $verified['tahun_lulus'];
        }

        KuesionerTracer::create([
            'alumnis_id' => $validated['alumnis_id'] ?? null,
            'nisn' => $validated['nisn'],
            'nama' => $validated['nama'],
            'jurusan' => $validated['jurusan'],
            'tahun_lulus' => $validated['tahun_lulus'],
            'status_pekerjaan' => $validated['status_pekerjaan'],
            'nama_perusahaan' => $validated['nama_perusahaan'] ?? null,
            'posisi' => $validated['posisi'] ?? null,
            'masa_tunggu' => $validated['masa_tunggu'] ?? null,
            'rentang_gaji' => $validated['rentang_gaji'] ?? null,
            'relevansi' => $validated['relevansi'],
            'saran' => $validated['saran'] ?? null,
            'is_konfirmasi' => true,
        ]);

        session()->forget('tracer_verified');

        return redirect()->route('pusat-karir.study-tracer')
            ->with('success', 'Terima kasih! Data kuesioner Anda telah tersimpan.');
    }

    protected function generateRegistrationCode(string $companyShort): string
    {
        $prefix = strtoupper(Str::substr(preg_replace('/[^A-Za-z]/', '', $companyShort) ?: 'TELKOM', 0, 5));

        do {
            $code = 'PKL-'.$prefix.'-'.now()->format('Ymd').'-'.strtoupper(Str::random(8));
        } while (MagangApplication::where('registration_code', $code)->exists());

        return $code;
    }
}
