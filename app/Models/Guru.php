<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Guru extends Model
{
    protected $fillable = [
        'nama',
        'jabatan',
        'mapel',
        'kategori',
        'foto_path',
        'warna',
        'urutan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function getFotoUrlAttribute(): ?string
    {
        if ($this->foto_path && Storage::disk('public')->exists($this->foto_path)) {
            return Storage::disk('public')->url($this->foto_path);
        }

        return null;
    }

    public function getInitialsAttribute(): string
    {
        $words = preg_split('/\s+/', trim($this->nama));
        $initials = '';

        if (! empty($words[0])) {
            $initials .= strtoupper(substr($words[0], 0, 1));
        }

        if (isset($words[1]) && ! empty($words[1])) {
            $initials .= strtoupper(substr($words[1], 0, 1));
        }

        return $initials ?: 'SM';
    }
}
