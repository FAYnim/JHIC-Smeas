<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BimbinganKategori extends Model
{
    protected $table = 'bimbingan_kategori';

    protected $fillable = [
        'nama',
        'slug',
        'icon',
    ];

    public function bimbinganKarirs(): HasMany
    {
        return $this->hasMany(BimbinganKarir::class, 'bimbingan_kategori_id');
    }
}
