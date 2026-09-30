<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'kategori',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }
}
