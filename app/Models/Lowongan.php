<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lowongan extends Model
{
    use HasFactory;

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
        'jenis',
        'deskripsi',
        'tanggung_jawab',
        'kualifikasi',
        'dokumen',
        'benefits',
        'batas_pendaftaran',
        'status_kuota',
        'pokja_nama',
        'pokja_koordinator',
        'pokja_wa',
        'gaji_min',
        'gaji_max',
        'tipe_pekerjaan',
        'pengalaman',
        'bidang_industri',
        'jenjang_pendidikan',
        'fresh_graduate_ok',
        'logo_color',
        'mitra_id',
        'is_published',
        'logo_path',
    ];

    protected function casts(): array
    {
        return [
            'is_mitra_dudi' => 'boolean',
            'tanggung_jawab' => 'array',
            'kualifikasi' => 'array',
            'dokumen' => 'array',
            'benefits' => 'array',
            'batas_pendaftaran' => 'date',
            'fresh_graduate_ok' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo_path ? asset('storage/'.$this->logo_path) : null;
    }

    public function applications()
    {
        return $this->hasMany(MagangApplication::class);
    }

    public function mitra(): BelongsTo
    {
        return $this->belongsTo(MitraPerusahaan::class, 'mitra_id');
    }
}
