<?php

namespace Tests\Feature;

use App\Models\CalonSiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SpmbDokumenTest extends TestCase
{
    use RefreshDatabase;

    public function test_documents_are_saved_with_structured_names_and_reported(): void
    {
        Storage::fake('public');
        $siswa = CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Budi',
            'asal_sekolah' => 'SMPN 1',
        ]);

        $this->withSession(['spmb_nisn' => '1234567890'])
            ->post(route('spmb.save-dokumen'), ['docs' => [
                'akta' => UploadedFile::fake()->create('a.pdf', 50, 'application/pdf'),
                'kartu_keluarga' => UploadedFile::fake()->create('b.jpg', 50, 'image/jpeg'),
                'ijazah_smp' => UploadedFile::fake()->create('c.png', 50, 'image/png'),
            ]])
            ->assertRedirect(route('spmb.dokumen'));

        Storage::disk('public')->assertExists('spmb/1234567890/akta.pdf');
        Storage::disk('public')->assertExists('spmb/1234567890/kartu_keluarga.jpg');
        Storage::disk('public')->assertExists('spmb/1234567890/ijazah_smp.png');

        $status = $siswa->dokumenStatus();
        $this->assertTrue($status['akta']['uploaded']);
        $this->assertSame('kartu_keluarga.jpg', $status['kartu_keluarga']['name']);
    }

    public function test_reupload_replaces_previous_extension(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('spmb/1234567890/akta.pdf', 'lama');
        CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Budi',
            'asal_sekolah' => 'SMPN 1',
        ]);

        $this->withSession(['spmb_nisn' => '1234567890'])
            ->post(route('spmb.save-dokumen'), ['docs' => [
                'akta' => UploadedFile::fake()->create('a.png', 50, 'image/png'),
                'kartu_keluarga' => UploadedFile::fake()->create('b.png', 50, 'image/png'),
                'ijazah_smp' => UploadedFile::fake()->create('c.png', 50, 'image/png'),
            ]]);

        Storage::disk('public')->assertMissing('spmb/1234567890/akta.pdf');
        Storage::disk('public')->assertExists('spmb/1234567890/akta.png');
    }

    public function test_missing_status_when_nothing_uploaded(): void
    {
        Storage::fake('public');
        $siswa = CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Budi',
            'asal_sekolah' => 'SMPN 1',
        ]);

        $this->assertFalse($siswa->dokumenStatus()['akta']['uploaded']);
    }
}
