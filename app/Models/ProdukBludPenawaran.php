<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProdukBludPenawaran extends Model
{
    protected $fillable = [
        'produk_blud_id',
        'nama',
        'kontak',
        'pesan',
    ];

    public function produkBlud(): BelongsTo
    {
        return $this->belongsTo(ProdukBlud::class, 'produk_blud_id');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(ProdukBlud::class, 'produk_blud_id');
    }
}
