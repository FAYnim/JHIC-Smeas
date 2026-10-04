<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MajorFinderController extends Controller
{
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

        $nama = ! empty($validated['nama']) ? trim($validated['nama']) : 'Sobat SMEAS';
        $topName = $validated['top_major']['name'];
        $topScore = $validated['top_major']['score'];

        $fallbackText = "Halo {$nama}! Berdasarkan analisis minat dan gaya berpikirmu, kamu memiliki potensi luar biasa pada bidang {$topName} dengan tingkat kecocokan mencapai {$topScore}%. Kemampuan logika, ketelitian, dan motivasimu sangat sejalan dengan kurikulum vokasi unggulan di SMKN 1 Surabaya. Jangan ragu untuk memperdalam potensimu dan jadilah profesional muda berprestasi bersama kami!";

        return response()->json([
            'success' => true,
            'analysis' => $fallbackText,
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
            ],
            [
                'id' => 2,
                'text' => 'Saya suka berinteraksi dengan banyak orang, melakukan tawar-menawar, negosiasi, atau menyusun strategi jualan.',
                'primary' => 'bisnis-daring-dan-pemasaran',
                'secondary' => 'perhotelan',
            ],
            [
                'id' => 3,
                'text' => 'Saya adalah orang yang sangat terorganisir, suka merapikan arsip/dokumen, dan menjaga ketepatan jadwal serta agenda kerja.',
                'primary' => 'manajemen-perkantoran',
                'secondary' => 'manajemen-logistik',
            ],
            [
                'id' => 4,
                'text' => 'Saya tertarik memahami alur rantai pasok, tata kelola barang di gudang, dan efisiensi jalur distribusi logistik.',
                'primary' => 'manajemen-logistik',
                'secondary' => null,
            ],
            [
                'id' => 5,
                'text' => 'Saya sangat antusias dengan dunia coding, menulis baris kode program, dan membangun sebuah aplikasi atau website dari nol.',
                'primary' => 'rekayasa-perangkat-lunak',
                'secondary' => null,
            ],
            [
                'id' => 6,
                'text' => 'Saya penasaran dengan cara kerja perangkat keras komputer, perakitan komponen PC, serta konfigurasi jaringan internet/router.',
                'primary' => 'teknik-komputer-dan-jaringan',
                'secondary' => null,
            ],
            [
                'id' => 7,
                'text' => 'Saya memiliki kepekaan estetika yang tinggi, senang menggambar, membuat ilustrasi digital, atau mendesain konten grafis.',
                'primary' => 'desain-komunikasi-visual',
                'secondary' => null,
            ],
            [
                'id' => 8,
                'text' => 'Saya tertarik bekerja di balik layar produksi video, penyiaran televisi/radio, penyusunan naskah, atau penyutradaraan film pendek.',
                'primary' => 'produksi-siaran-program-pertelevisian',
                'secondary' => null,
            ],
            [
                'id' => 9,
                'text' => 'Saya memiliki kepribadian yang ramah, berpenampilan rapi, sabar, dan senang melayani kenyamanan tamu atau pelanggan secara langsung.',
                'primary' => 'perhotelan',
                'secondary' => 'manajemen-perkantoran',
            ],
            [
                'id' => 10,
                'text' => 'Saya lebih menyukai tugas yang menuntut akurasi perhitungan tinggi, kepatuhan pada aturan formal, dan minim ruang kesalahan.',
                'primary' => 'akuntansi',
                'secondary' => 'manajemen-logistik',
            ],
            [
                'id' => 11,
                'text' => 'Saya suka mencari tren terbaru di media sosial, membuat materi promosi, atau mengelola toko online/marketplace.',
                'primary' => 'bisnis-daring-dan-pemasaran',
                'secondary' => 'desain-komunikasi-visual',
            ],
            [
                'id' => 12,
                'text' => 'Saya merasa nyaman dan teliti saat harus mengelola surat-menyurat resmi, notulen rapat, serta layanan komunikasi perkantoran.',
                'primary' => 'manajemen-perkantoran',
                'secondary' => null,
            ],
            [
                'id' => 13,
                'text' => 'Saya memiliki pola pikir logis-sistematis yang kuat untuk mencari letak kesalahan (debugging) pada suatu sistem atau alur kerja yang macet.',
                'primary' => 'rekayasa-perangkat-lunak',
                'secondary' => 'teknik-komputer-dan-jaringan',
            ],
            [
                'id' => 14,
                'text' => 'Saya menyukai tantangan teknis lapangan yang membutuhkan ketahanan fisik, ketelitian tinggi, dan penyelesaian masalah jaringan secara cepat.',
                'primary' => 'teknik-komputer-dan-jaringan',
                'secondary' => null,
            ],
            [
                'id' => 15,
                'text' => 'Saya senang mengekspresikan ide-ide kreatif yang unik ke dalam bentuk visual bergerak, fotografi profesional, atau identitas merek (branding).',
                'primary' => 'desain-komunikasi-visual',
                'secondary' => 'produksi-siaran-program-pertelevisian',
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
