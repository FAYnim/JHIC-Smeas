<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProdukBlud extends Model
{
    public const TIPE_SHOWCASE = 'showcase';

    public const TIPE_KUSTOM = 'kustom';

    protected $fillable = [
        'slug',
        'tipe',
        'title',
        'subtitle',
        'jurusan_nama',
        'jurusan_slug',
        'deskripsi',
        'harga_min',
        'harga_max',
        'rating',
        'rating_count',
        'terjual',
        'pengiriman',
        'kategori',
        'stok',
        'opsi_custom',
        'quantity_per_pack',
        'tanggal_pembuatan',
        'angkatan',
        'didukung_oleh',
        'ketua_tim',
        'anggota_tim',
        'jurusan_logo_color',
        'is_published',
        'penilaian_count',
        'produk_count',
        'presentase_chat',
        'waktu_chat',
    ];

    protected function casts(): array
    {
        return [
            'anggota_tim' => 'array',
            'is_published' => 'boolean',
            'rating' => 'float',
            'tanggal_pembuatan' => 'date',
        ];
    }

    public function galeri(): HasMany
    {
        return $this->hasMany(ProdukBludGaleri::class, 'produk_blud_id')->orderBy('urutan');
    }

    public function komentars(): HasMany
    {
        return $this->hasMany(ProdukBludKomentar::class, 'produk_blud_id')->latest();
    }

    public function penawarans(): HasMany
    {
        return $this->hasMany(ProdukBludPenawaran::class, 'produk_blud_id')->latest();
    }

    public function laporans(): HasMany
    {
        return $this->hasMany(ProdukBludLaporkan::class, 'produk_blud_id')->latest();
    }
}
