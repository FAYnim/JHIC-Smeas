<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\KuesionerTracer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudyTracerTest extends TestCase
{
    use RefreshDatabase;

    public function test_study_tracer_landing_page_returns_success(): void
    {
        $response = $this->get(route('pusat-karir.study-tracer'));

        $response->assertOk();
        $response->assertSee('Study Tracer');
        $response->assertSee('Distribusi Status Lulusan');
        $response->assertSee('Mitra Penerima Lulusan');
    }

    public function test_kuesioner_form_page_returns_success(): void
    {
        $response = $this->get(route('pusat-karir.study-tracer.kuesioner'));

        $response->assertOk();
        $response->assertSee('Kuesioner Tracer Study');
        $response->assertSee('Apakah status pekerjaan anda saat ini?');
    }

    public function test_verification_with_valid_nisn_shows_form(): void
    {
        $alumni = Alumni::create([
            'nisn' => '0067182910',
            'nama' => 'John Doe',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'tahun_lulus' => 2025,
            'angkatan' => 25,
        ]);

        $response = $this->from(route('pusat-karir.study-tracer'))
            ->get(route('pusat-karir.study-tracer.kuesioner', [
                'nisn' => $alumni->nisn,
                'tahun_lulus' => $alumni->tahun_lulus,
            ]));

        $response->assertOk();
        $response->assertSee('John Doe');
        $response->assertSee('Rekayasa Perangkat Lunak');
        $response->assertSessionHas('tracer_verified');
    }

    public function test_verification_with_invalid_nisn_redirects_with_error(): void
    {
        $response = $this->from(route('pusat-karir.study-tracer'))
            ->get(route('pusat-karir.study-tracer.kuesioner', [
                'nisn' => '9999999999',
                'tahun_lulus' => 2025,
            ]));

        $response->assertRedirect(route('pusat-karir.study-tracer'));
        $response->assertSessionHasErrors('nisn');
    }

    public function test_store_kuesioner_creates_record_and_redirects(): void
    {
        $response = $this->from(route('pusat-karir.study-tracer'))
            ->post(route('pusat-karir.study-tracer.store'), [
                'alumnis_id' => null,
                'nisn' => '0067182910',
                'nama' => 'John Doe',
                'jurusan' => 'Rekayasa Perangkat Lunak',
                'tahun_lulus' => 2025,
                'status_pekerjaan' => 'Bekerja',
                'nama_perusahaan' => 'PT Telkom Indonesia',
                'posisi' => 'Junior Web Developer',
                'masa_tunggu' => '1 - 3 Bulan',
                'rentang_gaji' => 'Rp 2.000.000 - Rp 4.500.000',
                'relevansi' => 'Relevan',
                'saran' => 'Tambahkan magang cloud computing.',
                'is_konfirmasi' => '1',
            ]);

        $response->assertRedirect(route('pusat-karir.study-tracer'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('kuesioner_tracers', [
            'nisn' => '0067182910',
            'nama' => 'John Doe',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'tahun_lulus' => 2025,
            'status_pekerjaan' => 'Bekerja',
            'nama_perusahaan' => 'PT Telkom Indonesia',
            'posisi' => 'Junior Web Developer',
            'masa_tunggu' => '1 - 3 Bulan',
            'rentang_gaji' => 'Rp 2.000.000 - Rp 4.500.000',
            'relevansi' => 'Relevan',
            'saran' => 'Tambahkan magang cloud computing.',
            'is_konfirmasi' => true,
        ]);

        $this->assertSame(1, KuesionerTracer::count());
    }

    public function test_store_kuesioner_rejects_invalid_masa_tunggu(): void
    {
        $response = $this->from(route('pusat-karir.study-tracer'))
            ->post(route('pusat-karir.study-tracer.store'), [
                'alumnis_id' => null,
                'nisn' => '0067182910',
                'nama' => 'John Doe',
                'jurusan' => 'Rekayasa Perangkat Lunak',
                'tahun_lulus' => 2025,
                'status_pekerjaan' => 'Bekerja',
                'masa_tunggu' => 'Sewenang-wenang',
                'rentang_gaji' => 'Rp 2.000.000 - Rp 4.500.000',
                'relevansi' => 'Relevan',
                'is_konfirmasi' => '1',
            ]);

        $response->assertSessionHasErrors('masa_tunggu');
        $this->assertSame(0, KuesionerTracer::count());
    }

    public function test_pusat_karir_category_links_to_study_tracer(): void
    {
        $response = $this->get(route('pusat-karir.index'));

        $response->assertOk();
        $response->assertSee(route('pusat-karir.study-tracer'), false);
    }
}
