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
                'nama' => 'Budi Santoso',
                'jenis_kelamin' => 'Pria',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2008-01-15',
                'alamat' => 'Jl. Merdeka No 10',
                'wa' => '08123456789',
                'email' => 'budi@example.com',
                'sekolah' => 'SMPN 1 Surabaya',
                'deklarasi' => '1',
            ]);

        $response->assertRedirect(route('spmb.biodata'));

        $this->assertDatabaseHas('calon_siswas', [
            'nisn' => '1234567890',
            'nama_lengkap' => 'Budi Santoso',
            'jenis_kelamin' => 'Pria',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2008-01-15',
            'alamat' => 'Jl. Merdeka No 10',
            'nomor_telepon' => '08123456789',
            'email' => 'budi@example.com',
            'asal_sekolah' => 'SMPN 1 Surabaya',
        ]);
    }

    public function test_biodata_rejects_underage_student(): void
    {
        $siswa = CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Siswa Muda',
            'asal_sekolah' => 'SMP Muda',
        ]);

        $response = $this->withSession(['spmb_nisn' => '1234567890'])
            ->post(route('spmb.save-biodata'), [
                'nama' => 'Siswa Muda',
                'jenis_kelamin' => 'Pria',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => now()->subYears(10)->format('Y-m-d'),
                'alamat' => 'Jl. Muda No 1',
                'wa' => '08123456789',
                'email' => 'muda@example.com',
                'sekolah' => 'SMPN 1 Surabaya',
                'deklarasi' => '1',
            ]);

        $response->assertSessionHasErrors('tanggal_lahir');
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
                'nik_ayah' => '3578012345678901',
                'pendidikan_ayah' => 'SMA/SMK',
                'pekerjaan_ayah' => 'Wiraswasta',
                'penghasilan_ayah' => '5jt - 10jt',
                'wa_ayah' => '08111111111',
                'status_ibu' => 'Masih Hidup',
                'nama_ibu' => 'Ibu Budi',
                'nik_ibu' => '3578012345678902',
                'pendidikan_ibu' => 'SMA/SMK',
                'pekerjaan_ibu' => 'Lainnya',
                'pekerjaan_ibu_lainnya' => 'Ibu Rumah Tangga',
                'penghasilan_ibu' => '< 2jt',
                'wa_ibu' => '08222222222',
            ]);

        $response->assertRedirect(route('spmb.orang-tua'));

        $this->assertDatabaseHas('calon_siswas', [
            'nisn' => '1234567890',
            'status_ayah' => 'Masih Hidup',
            'nama_ayah' => 'Ayah Budi',
            'nik_ayah' => '3578012345678901',
            'pendidikan_ayah' => 'SMA/SMK',
            'pekerjaan_ayah' => 'Wiraswasta',
            'penghasilan_ayah' => '5jt - 10jt',
            'wa_ayah' => '08111111111',
            'status_ibu' => 'Masih Hidup',
            'nama_ibu' => 'Ibu Budi',
            'nik_ibu' => '3578012345678902',
            'pendidikan_ibu' => 'SMA/SMK',
            'pekerjaan_ibu' => 'Lainnya',
            'pekerjaan_ibu_lainnya' => 'Ibu Rumah Tangga',
            'penghasilan_ibu' => '< 2jt',
            'wa_ibu' => '08222222222',
        ]);
    }

    public function test_orang_tua_rejects_invalid_nik(): void
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
                'nik_ayah' => '123',
                'pendidikan_ayah' => 'SMA/SMK',
                'pekerjaan_ayah' => 'Wiraswasta',
                'penghasilan_ayah' => '5jt - 10jt',
                'wa_ayah' => '08111111111',
                'status_ibu' => 'Masih Hidup',
                'nama_ibu' => 'Ibu Budi',
                'nik_ibu' => '456',
                'pendidikan_ibu' => 'SMA/SMK',
                'pekerjaan_ibu' => 'Lainnya',
                'pekerjaan_ibu_lainnya' => 'Ibu Rumah Tangga',
                'penghasilan_ibu' => '< 2jt',
                'wa_ibu' => '08222222222',
            ]);

        $response->assertSessionHasErrors(['nik_ayah', 'nik_ibu']);
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
                'jalur' => 'Prestasi Akademik',
                'jurusan' => 'Rekayasa Perangkat Lunak',
                'deklarasi' => '1',
            ]);

        $response->assertRedirect(route('spmb.formulir'));

        $this->assertDatabaseHas('calon_siswas', [
            'nisn' => '1234567890',
            'jalur_pendaftaran' => 'Prestasi Akademik',
            'jurusan_pilihan' => 'Rekayasa Perangkat Lunak',
        ]);
    }

    public function test_login_rejects_unregistered_nisn(): void
    {
        $response = $this->post(route('spmb.login'), [
            'nisn' => '9999999999',
        ]);

        $response->assertRedirect(route('spmb.login-page'));
        $response->assertSessionHas('spmb_error');
    }

    public function test_login_accepts_registered_nisn(): void
    {
        CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Budi Santoso',
            'asal_sekolah' => 'SMPN 1 Surabaya',
        ]);

        $response = $this->post(route('spmb.login'), [
            'nisn' => '1234567890',
        ]);

        $response->assertRedirect(route('spmb.dashboard'));
        $this->assertEquals('1234567890', session('spmb_nisn'));
    }
}
