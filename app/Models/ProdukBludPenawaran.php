<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProdukBludPenawaran extends Model
{
    public const STATUS_BARU = 'baru';

    public const STATUS_DIHUBUNGI = 'dihubungi';

    public const STATUS_DIPROSES = 'diproses';

    public const STATUS_SELESAI = 'selesai';

    public const STATUS_BATAL = 'batal';

    public const STATUSES = [
        self::STATUS_BARU => 'Baru',
        self::STATUS_DIHUBUNGI => 'Dihubungi',
        self::STATUS_DIPROSES => 'Diproses',
        self::STATUS_SELESAI => 'Selesai',
        self::STATUS_BATAL => 'Batal',
    ];

    protected $fillable = [
        'produk_blud_id',
        'nama',
        'kontak',
        'pesan',
        'status',
        'catatan_internal',
        'ditangani_oleh',
    ];

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
