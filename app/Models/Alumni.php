<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumni extends Model
{
    protected $table = 'alumnis';

    protected $fillable = [
        'nisn',
        'nama',
        'jurusan',
        'tahun_lulus',
        'angkatan',
    ];

    protected function casts(): array
    {
        return [
            'tahun_lulus' => 'integer',
            'angkatan' => 'integer',
        ];
    }

    public function kuesionerTracers(): HasMany
    {
        return $this->hasMany(KuesionerTracer::class, 'alumnis_id');
    }
}
