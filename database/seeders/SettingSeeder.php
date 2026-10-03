<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'SMKN 1 Surabaya', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Sekolah Unggul, Berkarakter, dan Berdaya Saing Global', 'group' => 'general'],
            ['key' => 'school_address', 'value' => 'Jl. SMEA No. 4, Wonokromo, Surabaya, Jawa Timur 60243', 'group' => 'general'],
            // Contact
            ['key' => 'school_phone', 'value' => '(031) 8292038', 'group' => 'contact'],
            ['key' => 'school_email', 'value' => 'info@smkn1-sby.sch.id', 'group' => 'contact'],
            ['key' => 'school_whatsapp', 'value' => '0812-3456-7890', 'group' => 'contact'],
            // Social Media
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/smkn1surabaya', 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/@smkn1surabaya', 'group' => 'social'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/smkn1surabaya', 'group' => 'social'],
            // SPMB
            ['key' => 'spmb_contact_email', 'value' => 'spmb@smkn1.surabaya.sch.id', 'group' => 'spmb'],
            ['key' => 'spmb_contact_phone', 'value' => '0812-3456-7890', 'group' => 'spmb'],
            ['key' => 'spmb_service_hours', 'value' => 'Senin–Jumat, 07.30–15.00 WIB', 'group' => 'spmb'],
            // Profil
            ['key' => 'profil.visi', 'value' => 'Terwujudnya SMK Negeri 1 Surabaya Yang Berkarakter Dan Unggul.', 'group' => 'profil'],
            ['key' => 'profil.misi', 'value' => 'Meningkatkan kompetensi peserta didik sesuai standar kompetensi lulusan dan berkarakter profil pelajar Pancasila.', 'group' => 'profil'],
            ['key' => 'profil.prakata_nama', 'value' => 'Dr. Drs. Anton Sujarwo, M.Pd.', 'group' => 'profil'],
            ['key' => 'profil.prakata_quote', 'value' => 'Era globalisasi membawa perubahan yang cepat dalam berbagai aspek kehidupan. Oleh karena itu, pendidikan memiliki peran penting dalam menyiapkan sumber daya manusia yang mampu menghadapi perubahan tersebut. Sekolah perlu memiliki arah pengembangan yang jelas dan berkelanjutan, sekaligus mampu menyesuaikan diri dengan kebutuhan dan permasalahan masyarakat saat ini.', 'group' => 'profil'],
            ['key' => 'profil.prakata_foto', 'value' => 'images/Group 198.png', 'group' => 'profil'],
        ];

        foreach ($settings as $setting) {
            Setting::set($setting['key'], $setting['value'], $setting['group']);
        }
    }
}
