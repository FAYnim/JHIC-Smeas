<?php

namespace Database\Seeders;

use App\Models\TracerMitraAlumnus;
use App\Models\TracerSetting;
use App\Models\TracerStatusLulusan;
use Illuminate\Database\Seeder;

class TracerSeeder extends Seeder
{
    public function run(): void
    {
        TracerSetting::updateOrCreate(['id' => 1], [
            'tingkat_keterserapan' => '91,8%',
            'keterserapan_trend' => '↑ 3,2% dari tahun lalu',
            'keterserapan_trend_warna' => 'green',
            'masa_tunggu' => '1,8 Bln',
            'masa_tunggu_sub' => 'Lulusan langsung terserap DUDI',
            'masa_tunggu_sub_warna' => 'blue',
            'kesesuaian' => '86,4%',
            'kesesuaian_sub' => 'Linear dengan program keahlian',
            'kesesuaian_sub_warna' => 'slate',
            'total_alumni' => '2.450+',
            'total_alumni_sub' => 'Database aktif BKK sekolah',
            'total_alumni_sub_warna' => 'blue',
            'catatan_bmw' => '📌 Data diperbarui otomatis setiap semester melalui sinkronisasi sistem BKK & Kemendikbud.',
        ]);

        $statuses = [
            [
                'nama' => 'Bekerja di Dunia Usaha / Industri',
                'persen' => 62,
                'warna' => '#1d4ed8',
                'urutan' => 1,
            ],
            [
                'nama' => 'Melanjutkan Pendidikan / Kuliah',
                'persen' => 21,
                'warna' => '#0ea5e9',
                'urutan' => 2,
            ],
            [
                'nama' => 'Berwirausaha / Rintisan Usaha',
                'persen' => 11,
                'warna' => '#f59e0b',
                'urutan' => 3,
            ],
            [
                'nama' => 'Lainnya / Mencari Kerja',
                'persen' => 6,
                'warna' => '#64748b',
                'urutan' => 4,
            ],
        ];

        foreach ($statuses as $status) {
            TracerStatusLulusan::updateOrCreate(['nama' => $status['nama']], $status);
        }

        $mitras = [
            [
                'nama' => 'TELKOM INDONESIA',
                'jumlah_alumni' => 45,
                'catatan' => null,
                'warna' => '#dc2626',
                'urutan' => 1,
            ],
            [
                'nama' => 'BANK JATIM',
                'jumlah_alumni' => 38,
                'catatan' => null,
                'warna' => '#2563eb',
                'urutan' => 2,
            ],
            [
                'nama' => 'ASTRA MOTOR',
                'jumlah_alumni' => 30,
                'catatan' => null,
                'warna' => '#334155',
                'urutan' => 3,
            ],
            [
                'nama' => 'SHOPEE EXPRESS',
                'jumlah_alumni' => 24,
                'catatan' => null,
                'warna' => '#ea580c',
                'urutan' => 4,
            ],
            [
                'nama' => 'POLITEKNIK ELEKTRONIKA',
                'jumlah_alumni' => 50,
                'catatan' => 'Lanjut Studi (PENS)',
                'warna' => '#16a34a',
                'urutan' => 5,
            ],
        ];

        foreach ($mitras as $mitra) {
            TracerMitraAlumnus::updateOrCreate(['nama' => $mitra['nama']], $mitra);
        }
    }
}
