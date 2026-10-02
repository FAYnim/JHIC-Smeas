<?php

namespace Database\Factories;

use App\Models\Lowongan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Lowongan>
 */
class LowonganFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $company = fake()->company();

        return [
            'company_name' => $company,
            'company_short' => fake()->companySuffix(),
            'is_mitra_dudi' => true,
            'title' => fake()->jobTitle(),
            'slug' => Str::slug($company.'-'.fake()->unique()->numberBetween(1, 999999)),
            'location' => 'Surabaya, Jatim',
            'duration' => '6 Bulan',
            'jurusan' => 'RPL',
            'kuota' => fake()->numberBetween(1, 5),
            'metode_kerja' => 'On-site (Surabaya)',
            'deskripsi' => fake()->paragraph(),
            'tanggung_jawab' => ['Mengerjakan tugas harian'],
            'kualifikasi' => ['Siswa aktif'],
            'dokumen' => [['name' => 'CV.pdf', 'desc' => 'Dokumen', 'type' => 'pdf']],
            'benefits' => ['Uang saku'],
            'batas_pendaftaran' => now()->addMonths(2)->toDateString(),
            'durasi_pelaksanaan' => '6 Bulan',
            'status_kuota' => 'Tersedia',
            'pokja_nama' => 'Pokja PKL',
            'pokja_koordinator' => 'Bpk. Uji',
            'pokja_wa' => '6281234567890',
        ];
    }
}
