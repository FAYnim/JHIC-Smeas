<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProdukBludLaporkan extends Model
{
    public const STATUS_BARU = 'baru';

    public const STATUS_DITINDAKLANJUTI = 'ditindaklanjuti';

    protected $table = 'produk_blud_laporans';

    protected $fillable = [
        'produk_blud_id',
        'kategori',
        'deskripsi',
        'status',
        'catatan_internal',
        'ditangani_oleh',
        'ditangani_at',
    ];

    protected function casts(): array
    {
        return [
            'ditangani_at' => 'datetime',
        ];
    }

    public function produkBlud(): BelongsTo
    {
        return $this->belongsTo(ProdukBlud::class, 'produk_blud_id');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(ProdukBlud::class, 'produk_blud_id');
    }

    public function penangan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ditangani_oleh');
    }
}
