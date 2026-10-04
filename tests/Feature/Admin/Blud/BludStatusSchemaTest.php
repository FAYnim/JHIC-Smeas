<?php

namespace Tests\Feature\Admin\Blud;

use App\Models\ProdukBlud;
use App\Models\ProdukBludKomentar;
use App\Models\ProdukBludLaporkan;
use App\Models\ProdukBludPenawaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BludStatusSchemaTest extends TestCase
{
    use RefreshDatabase;

    private function produk(): ProdukBlud
    {
        return ProdukBlud::create([
            'slug' => 'produk-status',
            'tipe' => ProdukBlud::TIPE_SHOWCASE,
            'title' => 'Produk Status',
            'jurusan_nama' => 'RPL',
            'jurusan_slug' => 'rpl',
            'deskripsi' => 'Deskripsi',
        ]);
    }

    public function test_new_records_default_to_baru(): void
    {
        $produk = $this->produk();

        $penawaran = ProdukBludPenawaran::create([
            'produk_blud_id' => $produk->id,
            'nama' => 'A',
            'kontak' => '0812',
            'pesan' => 'Pesan',
        ]);
        $laporan = ProdukBludLaporkan::create([
            'produk_blud_id' => $produk->id,
            'kategori' => 'Spam',
            'deskripsi' => 'x',
        ]);
        $komentar = ProdukBludKomentar::create([
            'produk_blud_id' => $produk->id,
            'nama' => 'B',
            'komentar' => 'Halo',
        ]);

        $this->assertSame('baru', $penawaran->fresh()->status);
        $this->assertSame('baru', $laporan->fresh()->status);
        $this->assertSame('baru', $komentar->fresh()->status);
    }
}
