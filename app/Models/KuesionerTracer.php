<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KuesionerTracer extends Model
{
    public const STATUS_PEKERJAAN = ['Bekerja', 'Melanjutkan Kuliah', 'Wirausaha', 'Mencari kerja'];

    public const RELEVANSI = ['Relevan', 'Cukup Relevan', 'Tidak Relevan'];

    public const MASA_TUNGGU = ['Di bawah 1 Bulan', '1 - 3 Bulan', '4 - 6 Bulan', '7 - 12 Bulan', 'Lebih dari 12 Bulan'];

    public const RENTANG_GAJI = ['Di bawah Rp 2.000.000', 'Rp 2.000.000 - Rp 4.500.000', 'Rp 4.500.000 - Rp 6.000.000', 'Rp 6.000.000 - Rp 10.000.000', 'Lebih dari Rp 10.000.000', 'Belum / Tidak Berpenghasilan'];

    protected $fillable = [
        'alumnis_id',
        'nisn',
        'nama',
        'jurusan',
        'tahun_lulus',
        'status_pekerjaan',
        'nama_perusahaan',
        'posisi',
        'masa_tunggu',
        'rentang_gaji',
        'relevansi',
        'saran',
        'is_konfirmasi',
    ];

    protected function casts(): array
    {
        return [
            'tahun_lulus' => 'integer',
            'is_konfirmasi' => 'boolean',
        ];
    }

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class, 'alumnis_id');
    }
}
