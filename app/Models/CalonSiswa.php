<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CalonSiswa extends Model
{
    public const DOKUMEN = [
        'akta' => 'Akta Kelahiran',
        'kartu_keluarga' => 'Kartu Keluarga',
        'ijazah_smp' => 'Ijazah SMP',
    ];

    /**
     * Status unggahan per jenis dokumen, diturunkan dari nama file terstruktur.
     *
     * @return array<string, array{label: string, uploaded: bool, name: ?string, url: ?string, size: ?int}>
     */
    public function dokumenStatus(): array
    {
        $disk = Storage::disk('public');
        $files = $disk->files("spmb/{$this->nisn}");

        $status = [];
        foreach (self::DOKUMEN as $key => $label) {
            $path = collect($files)->first(fn (string $file): bool => pathinfo($file, PATHINFO_FILENAME) === $key);

            $status[$key] = [
                'label' => $label,
                'uploaded' => $path !== null,
                'name' => $path !== null ? basename($path) : null,
                'url' => $path !== null ? $disk->url($path) : null,
                'size' => $path !== null ? $disk->size($path) : null,
            ];
        }

        return $status;
    }

    protected $fillable = [
        'nisn',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'asal_sekolah',
        'nomor_telepon',
        'email',
        'alamat',
        'status_ayah',
        'nama_ayah',
        'nik_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'pekerjaan_ayah_lainnya',
        'penghasilan_ayah',
        'wa_ayah',
        'status_ibu',
        'nama_ibu',
        'nik_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'pekerjaan_ibu_lainnya',
        'penghasilan_ibu',
        'wa_ibu',
        'jalur_pendaftaran',
        'jurusan_pilihan',
        'status_verifikasi',
        'catatan_verifikasi',
    ];
}
