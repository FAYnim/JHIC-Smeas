<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerStatusLulusan extends Model
{
    protected $fillable = [
        'nama',
        'persen',
        'warna',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'persen' => 'float',
            'urutan' => 'integer',
        ];
    }
}
