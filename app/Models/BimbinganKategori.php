<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BimbinganKategori extends Model
{
    public function bimbinganKarirs(): HasMany
    {
        return $this->hasMany(BimbinganKarir::class, 'bimbingan_kategori_id');
    }
}
