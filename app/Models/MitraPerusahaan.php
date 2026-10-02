<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MitraPerusahaan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_name',
        'sector',
        'city',
        'description',
        'website',
        'logo_color',
        'logo_text',
        'is_mou_active',
        'mou_until',
        'programs',
        'stats',
        'address',
        'distance_note',
        'kemitraan_sejak',
        'narahubung_nama',
        'narahubung_jabatan',
        'narahubung_wa',
        'kelas_industri',
        'documents',
        'logo_path',
    ];

    protected function casts(): array
    {
        return [
            'is_mou_active' => 'boolean',
            'programs' => 'array',
            'stats' => 'array',
            'kelas_industri' => 'array',
            'documents' => 'array',
            'mou_until' => 'date',
            'kemitraan_sejak' => 'integer',
        ];
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo_path ? asset('storage/'.$this->logo_path) : null;
    }

    public function lowongans(): HasMany
    {
        return $this->hasMany(Lowongan::class, 'mitra_id');
    }
}
