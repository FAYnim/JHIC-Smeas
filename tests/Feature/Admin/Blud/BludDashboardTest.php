<?php

namespace Tests\Feature\Admin\Blud;

use App\Models\ProdukBlud;
use App\Models\ProdukBludLaporkan;
use App\Models\ProdukBludPenawaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BludDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_blud_dashboard_shows_only_blud_stats(): void
    {
        $produk = ProdukBlud::create([
            'slug' => 'produk-dash',
            'tipe' => ProdukBlud::TIPE_KUSTOM,
            'title' => 'Produk Dash',
            'jurusan_nama' => 'DKV',
            'jurusan_slug' => 'dkv',
            'deskripsi' => 'Deskripsi',
        ]);
        ProdukBludPenawaran::create([
            'produk_blud_id' => $produk->id,
            'nama' => 'Klien Dash',
            'kontak' => '0812',
            'pesan' => 'Pesan',
        ]);
        ProdukBludLaporkan::create([
            'produk_blud_id' => $produk->id,
            'kategori' => 'Spam Dash',
            'deskripsi' => 'x',
        ]);

        $this->actingAs(User::factory()->blud()->create())
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Pesanan Baru')
            ->assertSee('Laporan Belum Ditangani')
            ->assertSee('Klien Dash')
            ->assertSee('Spam Dash')
            ->assertDontSee('Total Lowongan');
    }
}
