<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KuesionerTracer extends Model
{
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
