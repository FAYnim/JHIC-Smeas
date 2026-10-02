<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerMitraAlumnus extends Model
{
    protected $table = 'tracer_mitra_alumnus';

    protected $fillable = [
        'nama',
        'jumlah_alumni',
        'catatan',
        'warna',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_alumni' => 'integer',
            'urutan' => 'integer',
        ];
    }
}
