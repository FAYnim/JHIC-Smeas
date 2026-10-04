<?php

namespace App\Http\Controllers;

use App\Services\MajorFinder\MajorAnalysisService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MajorFinderController extends Controller
{
    public function __construct(
        protected MajorAnalysisService $analysisService
    ) {}

    public function index(): View
    {
        $questions = $this->getQuestions();
        $majors = $this->getMajors();

        return view('temukan-jurusan', compact('questions', 'majors'));
    }

    public function analisis(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama' => ['nullable', 'string', 'max:50'],
            'top_major' => ['required', 'array'],
            'top_major.name' => ['required', 'string', 'max:100'],
            'top_major.score' => ['required', 'numeric', 'min:0', 'max:100'],
            'alternatives' => ['nullable', 'array'],
            'highlights' => ['nullable', 'array'],
        ]);

        $analysis = $this->analysisService->generate(
            nama: $validated['nama'] ?? '',
            topMajor: $validated['top_major'],
            alternatives: $validated['alternatives'] ?? [],
            highlights: $validated['highlights'] ?? []
        );

        return response()->json([
            'success' => true,
            'analysis' => $analysis,
        ]);
    }

    /**
     * @return array<int, array{id: int, text: string, primary: string, secondary: ?string}>
     */
    public function getQuestions(): array
    {
        return [
            [
                'id' => 1,
                'text' => 'Saya sangat menikmati aktivitas yang melibatkan analisis angka, pencatatan data keuangan, atau audit laporan secara teliti.',
                'primary' => 'akuntansi',
                'secondary' => 'manajemen-perkantoran',
                'category' => 'Analisis Finansial & Data',
                'icon' => '📊',
            ],
            [
                'id' => 2,
                'text' => 'Saya suka berinteraksi dengan banyak orang, melakukan tawar-menawar, negosiasi, atau menyusun strategi jualan.',
                'primary' => 'bisnis-daring-dan-pemasaran',
                'secondary' => 'perhotelan',
                'category' => 'Pemasaran & Negosiasi Bisnis',
                'icon' => '🤝',
            ],
            [
                'id' => 3,
                'text' => 'Saya adalah orang yang sangat terorganisir, suka merapikan arsip/dokumen, dan menjaga ketepatan jadwal serta agenda kerja.',
                'primary' => 'manajemen-perkantoran',
                'secondary' => 'manajemen-logistik',
                'category' => 'Administrasi & Keteraturan Kerja',
                'icon' => '📁',
            ],
            [
                'id' => 4,
                'text' => 'Saya tertarik memahami alur rantai pasok, tata kelola barang di gudang, dan efisiensi jalur distribusi logistik.',
                'primary' => 'manajemen-logistik',
                'secondary' => null,
                'category' => 'Logistik & Distribusi Barang',
                'icon' => '📦',
            ],
            [
                'id' => 5,
                'text' => 'Saya sangat antusias dengan dunia coding, menulis baris kode program, dan membangun sebuah aplikasi atau website dari nol.',
                'primary' => 'rekayasa-perangkat-lunak',
                'secondary' => null,
                'category' => 'Rekayasa Coding & Software',
                'icon' => '💻',
            ],
            [
                'id' => 6,
                'text' => 'Saya penasaran dengan cara kerja perangkat keras komputer, perakitan komponen PC, serta konfigurasi jaringan internet/router.',
                'primary' => 'teknik-komputer-dan-jaringan',
                'secondary' => null,
                'category' => 'Hardware & Infrastruktur Jaringan',
                'icon' => '⚡',
            ],
            [
                'id' => 7,
                'text' => 'Saya memiliki kepekaan estetika yang tinggi, senang menggambar, membuat ilustrasi digital, atau mendesain konten grafis.',
                'primary' => 'desain-komunikasi-visual',
                'secondary' => null,
                'category' => 'Kreativitas & Ilustrasi Visual',
                'icon' => '🎨',
            ],
            [
                'id' => 8,
                'text' => 'Saya tertarik bekerja di balik layar produksi video, penyiaran televisi/radio, penyusunan naskah, atau penyutradaraan film pendek.',
                'primary' => 'produksi-siaran-program-pertelevisian',
                'secondary' => null,
                'category' => 'Broadcasting & Produksi Media',
                'icon' => '🎬',
            ],
            [
                'id' => 9,
                'text' => 'Saya memiliki kepribadian yang ramah, berpenampilan rapi, sabar, dan senang melayani kenyamanan tamu atau pelanggan secara langsung.',
                'primary' => 'perhotelan',
                'secondary' => 'manajemen-perkantoran',
                'category' => 'Hospitality & Pelayanan Tamu',
                'icon' => '🏨',
            ],
            [
                'id' => 10,
                'text' => 'Saya lebih menyukai tugas yang menuntut akurasi perhitungan tinggi, kepatuhan pada aturan formal, dan minim ruang kesalahan.',
                'primary' => 'akuntansi',
                'secondary' => 'manajemen-logistik',
                'category' => 'Akurasi Angka & Regulasi',
                'icon' => '🔢',
            ],
            [
                'id' => 11,
                'text' => 'Saya suka mencari tren terbaru di media sosial, membuat materi promosi, atau mengelola toko online/marketplace.',
                'primary' => 'bisnis-daring-dan-pemasaran',
                'secondary' => 'desain-komunikasi-visual',
                'category' => 'E-Commerce & Media Digital',
                'icon' => '📱',
            ],
            [
                'id' => 12,
                'text' => 'Saya merasa nyaman dan teliti saat harus mengelola surat-menyurat resmi, notulen rapat, serta layanan komunikasi perkantoran.',
                'primary' => 'manajemen-perkantoran',
                'secondary' => null,
                'category' => 'Korespondensi & Tata Kelola Kantor',
                'icon' => '✉️',
            ],
            [
                'id' => 13,
                'text' => 'Saya memiliki pola pikir logis-sistematis yang kuat untuk mencari letak kesalahan (debugging) pada suatu sistem atau alur kerja yang macet.',
                'primary' => 'rekayasa-perangkat-lunak',
                'secondary' => 'teknik-komputer-dan-jaringan',
                'category' => 'Problem Solving & Logika Sistem',
                'icon' => '🧩',
            ],
            [
                'id' => 14,
                'text' => 'Saya menyukai tantangan teknis lapangan yang membutuhkan ketahanan fisik, ketelitian tinggi, dan penyelesaian masalah jaringan secara cepat.',
                'primary' => 'teknik-komputer-dan-jaringan',
                'secondary' => null,
                'category' => 'Teknisi Jaringan & Solusi Lapangan',
                'icon' => '🔧',
            ],
            [
                'id' => 15,
                'text' => 'Saya senang mengekspresikan ide-ide kreatif yang unik ke dalam bentuk visual bergerak, fotografi profesional, atau identitas merek (branding).',
                'primary' => 'desain-komunikasi-visual',
                'secondary' => 'produksi-siaran-program-pertelevisian',
                'category' => 'Karya Seni Digital & Branding',
                'icon' => '✨',
            ],
        ];
    }

    /**
     * @return array<string, array{name: string, code: string, slug: string, career: string, icon: string}>
     */
    public function getMajors(): array
    {
        return [
            'rekayasa-perangkat-lunak' => [
                'name' => 'Rekayasa Perangkat Lunak',
                'code' => 'RPL',
                'slug' => 'rekayasa-perangkat-lunak',
                'career' => 'Software Developer, Web Engineer, Mobile App Creator',
                'icon' => 'code',
            ],
            'teknik-komputer-dan-jaringan' => [
                'name' => 'Teknik Komputer dan Jaringan',
                'code' => 'TKJ',
                'slug' => 'teknik-komputer-dan-jaringan',
                'career' => 'Network Administrator, Cloud Technician, System Support',
                'icon' => 'network',
            ],
            'desain-komunikasi-visual' => [
                'name' => 'Desain Komunikasi Visual',
                'code' => 'DKV',
                'slug' => 'desain-komunikasi-visual',
                'career' => 'Graphic Designer, UI/UX Specialist, Digital Illustrator',
                'icon' => 'palette',
            ],
            'akuntansi' => [
                'name' => 'Akuntansi dan Keuangan Lembaga',
                'code' => 'AK',
                'slug' => 'akuntansi',
                'career' => 'Junior Auditor, Financial Staff, Tax Administration',
                'icon' => 'calculator',
            ],
            'bisnis-daring-dan-pemasaran' => [
                'name' => 'Bisnis Daring dan Pemasaran',
                'code' => 'BDP',
                'slug' => 'bisnis-daring-dan-pemasaran',
                'career' => 'Digital Marketer, E-Commerce Specialist, Business Development',
                'icon' => 'trending-up',
            ],
            'manajemen-perkantoran' => [
                'name' => 'Manajemen Perkantoran',
                'code' => 'MP',
                'slug' => 'manajemen-perkantoran',
                'career' => 'Executive Secretary, Document Controller, Office Administrator',
                'icon' => 'file-text',
            ],
            'manajemen-logistik' => [
                'name' => 'Manajemen Logistik',
                'code' => 'MLOG',
                'slug' => 'manajemen-logistik',
                'career' => 'Supply Chain Officer, Warehouse Coordinator, Inventory Analyst',
                'icon' => 'box',
            ],
            'perhotelan' => [
                'name' => 'Perhotelan',
                'code' => 'PH',
                'slug' => 'perhotelan',
                'career' => 'Front Office Leader, Hospitality Officer, Food & Beverage Lead',
                'icon' => 'home',
            ],
            'produksi-siaran-program-pertelevisian' => [
                'name' => 'Produksi Siaran Pertelevisian',
                'code' => 'PSPT',
                'slug' => 'produksi-siaran-program-pertelevisian',
                'career' => 'Broadcast Director, Video Editor, Scriptwriter, Cameraperson',
                'icon' => 'video',
            ],
        ];
    }
}
