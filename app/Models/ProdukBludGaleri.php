<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProdukBludGaleri extends Model
{
    protected $fillable = [
        'produk_blud_id',
        'image_url',
        'caption',
        'urutan',
    ];

    public function produkBlud(): BelongsTo
    {
        return $this->belongsTo(ProdukBlud::class, 'produk_blud_id');
    }
}
