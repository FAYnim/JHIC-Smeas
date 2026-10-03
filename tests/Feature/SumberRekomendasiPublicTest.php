<?php

namespace Tests\Feature;

use App\Models\SumberRekomendasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SumberRekomendasiPublicTest extends TestCase
{
    use RefreshDatabase;

    public function test_pusat_karir_displays_active_sumber_rekomendasi_only(): void
    {
        SumberRekomendasi::create([
            'title' => 'Glints Karier Unik',
            'url' => 'https://glints.com/id',
            'kategori' => 'Lowongan Kerja',
            'urutan' => 1,
            'is_active' => true,
        ]);
        SumberRekomendasi::create([
            'title' => 'Sumber Tersembunyi Unik',
            'url' => 'https://example.com/rahasia',
            'urutan' => 2,
            'is_active' => false,
        ]);

        $response = $this->get(route('pusat-karir.index'));

        $response->assertOk();
        $response->assertSee('Glints Karier Unik');
        $response->assertDontSee('Sumber Tersembunyi Unik');
    }
}
