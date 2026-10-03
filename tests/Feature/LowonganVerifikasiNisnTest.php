<?php

namespace Tests\Feature;

use App\Models\CalonSiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LowonganVerifikasiNisnTest extends TestCase
{
    use RefreshDatabase;

    public function test_registered_nisn_returns_valid_with_name(): void
    {
        CalonSiswa::create([
            'nisn' => '0051234567',
            'nama_lengkap' => 'Siswa Uji Khusus',
            'asal_sekolah' => 'SMP Uji Khusus',
        ]);

        $this->postJson(route('pusat-karir.verifikasi-nisn'), ['nisn' => '0051234567'])
            ->assertOk()
            ->assertJson(['valid' => true, 'nama' => 'Siswa Uji Khusus']);
    }

    public function test_unknown_nisn_returns_valid_false(): void
    {
        $this->postJson(route('pusat-karir.verifikasi-nisn'), ['nisn' => '9999999999'])
            ->assertOk()
            ->assertJson(['valid' => false]);
    }

    public function test_bad_format_returns_422(): void
    {
        $this->postJson(route('pusat-karir.verifikasi-nisn'), ['nisn' => '123'])
            ->assertStatus(422);
    }
}
