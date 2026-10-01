<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BimbinganKarir extends Model
{
    protected $fillable = [
        'bimbingan_kategori_id',
        'title',
        'slug',
        'description',
        'image_url',
        'external_url',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(BimbinganKategori::class, 'bimbingan_kategori_id');
    }
}
