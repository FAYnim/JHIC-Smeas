<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    protected $fillable = [
        'company_name',
        'company_short',
        'is_mitra_dudi',
        'title',
        'slug',
        'location',
        'duration',
        'jurusan',
        'kuota',
        'metode_kerja',
        'deskripsi',
        'tanggung_jawab',
        'kualifikasi',
        'dokumen',
        'benefits',
        'batas_pendaftaran',
        'durasi_pelaksanaan',
        'status_kuota',
        'pokja_nama',
        'pokja_koordinator',
        'pokja_wa',
    ];

    protected function casts(): array
    {
        return [
            'is_mitra_dudi'    => 'boolean',
            'tanggung_jawab'   => 'array',
            'kualifikasi'      => 'array',
            'dokumen'          => 'array',
            'benefits'         => 'array',
            'batas_pendaftaran' => 'date',
        ];
    }
}
