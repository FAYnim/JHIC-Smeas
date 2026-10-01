<?php

namespace Tests\Feature;

use App\Models\CalonSiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpmbSaveDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_biodata_can_be_saved_to_database(): void
    {
        $siswa = CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Siswa Lama',
            'asal_sekolah' => 'SMP Lama',
        ]);

        $response = $this->withSession(['spmb_nisn' => '1234567890'])
            ->post(route('spmb.save-biodata'), [
                'nisn' => '1234567890',
                'nama' => 'Budi Santoso',
                'jenis_kelamin' => 'Pria',
                'status' => 'Lulusan SMP',
                'alamat' => 'Jl. Merdeka No 10',
                'wa' => '08123456789',
                'email' => 'budi@example.com',
                'sekolah' => 'SMPN 1 Surabaya',
            ]);

        $response->assertRedirect(route('spmb.biodata'));

        $this->assertDatabaseHas('calon_siswas', [
            'nisn' => '1234567890',
            'nama_lengkap' => 'Budi Santoso',
            'jenis_kelamin' => 'Pria',
            'alamat' => 'Jl. Merdeka No 10',
            'nomor_telepon' => '08123456789',
            'email' => 'budi@example.com',
            'asal_sekolah' => 'SMPN 1 Surabaya',
        ]);
    }

    public function test_orang_tua_data_can_be_saved_to_database(): void
    {
        $siswa = CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Budi Santoso',
            'asal_sekolah' => 'SMPN 1 Surabaya',
        ]);

        $response = $this->withSession(['spmb_nisn' => '1234567890'])
            ->post(route('spmb.save-orang-tua'), [
                'status_ayah' => 'Masih Hidup',
                'nama_ayah' => 'Ayah Budi',
                'pendidikan_ayah' => 'S1',
                'pekerjaan_ayah' => 'Wiraswasta',
                'penghasilan_ayah' => '5 Juta',
                'wa_ayah' => '08111111111',
                'status_ibu' => 'Masih Hidup',
                'nama_ibu' => 'Ibu Budi',
                'pendidikan_ibu' => 'D3',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ibu' => '0',
                'wa_ibu' => '08222222222',
            ]);

        $response->assertRedirect(route('spmb.orang-tua'));

        $this->assertDatabaseHas('calon_siswas', [
            'nisn' => '1234567890',
            'nama_ayah' => 'Ayah Budi',
            'pekerjaan_ayah' => 'Wiraswasta',
            'wa_ayah' => '08111111111',
            'nama_ibu' => 'Ibu Budi',
            'pekerjaan_ibu' => 'Ibu Rumah Tangga',
            'wa_ibu' => '08222222222',
        ]);
    }

    public function test_formulir_data_can_be_saved_to_database(): void
    {
        $siswa = CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Budi Santoso',
            'asal_sekolah' => 'SMPN 1 Surabaya',
        ]);

        $response = $this->withSession(['spmb_nisn' => '1234567890'])
            ->post(route('spmb.save-formulir'), [
                'jalur' => 'Prestasi',
                'jurusan' => 'RPL',
                'deklarasi' => '1',
            ]);

        $response->assertRedirect(route('spmb.formulir'));

        $this->assertDatabaseHas('calon_siswas', [
            'nisn' => '1234567890',
            'jalur_pendaftaran' => 'Prestasi',
            'jurusan_pilihan' => 'RPL',
        ]);
    }
}
