<?php

namespace Database\Seeders;

use App\Models\Webinar;
use Illuminate\Database\Seeder;

class WebinarSeeder extends Seeder
{
    public function run(): void
    {
        $webinars = [
            [
                'title' => 'Webinar Karier: Membangun Portofolio Digital untuk Siswa SMK',
                'slug' => 'webinar-membangun-portofolio-digital-siswa-smk',
                'description' => 'Belajar cara membangun portofolio digital yang menarik untuk rekrut perusahaan.',
                'speaker' => 'Rina Prameswari, Product Designer di Tokopedia',
                'location' => 'Google Meet',
                'start_date' => now()->addDays(7)->toDateString(),
                'start_time' => '16:00:00',
            ],
            [
                'title' => 'Webinar Lowongan Kerja: Tips CV untuk Lulusan SMKN 1 Surabaya',
                'slug' => 'webinar-tips-cv-lulusan-smkn-1-surabaya',
                'description' => 'Tips menulis CV yang tepat untuk seleksi perusahaan.',
                'speaker' => 'Bagus Setiawan, HRD PT Telkom Surabaya',
                'location' => 'Zoom Meeting',
                'start_date' => now()->addDays(14)->toDateString(),
                'start_time' => '15:30:00',
            ],
            [
                'title' => 'Webinar Magang: Persiapan Interview Lowongan PKL',
                'slug' => 'webinar-persiapan-interview-lowongan-pkl',
                'description' => 'Persiapan interview magang di perusahaan nama besar.',
                'speaker' => 'Siti Nurhaliza, Recruiter PT Gudang Garam',
                'location' => 'Google Meet',
                'start_date' => now()->addDays(21)->toDateString(),
                'start_time' => '14:00:00',
            ],
        ];

        foreach ($webinars as $webinar) {
            Webinar::updateOrCreate(
                ['slug' => $webinar['slug']],
                $webinar + ['platform' => 'online', 'is_published' => true]
            );
        }
    }
}
