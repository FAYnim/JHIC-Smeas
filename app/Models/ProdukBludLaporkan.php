<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProdukBludLaporkan extends Model
{
    protected $table = 'produk_blud_laporans';

    protected $fillable = [
        'produk_blud_id',
        'kategori',
        'deskripsi',
    ];

    public function produkBlud(): BelongsTo
    {
        return $this->belongsTo(ProdukBlud::class, 'produk_blud_id');
    }
}
