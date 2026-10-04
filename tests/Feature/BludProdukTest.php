<?php

namespace Tests\Feature;

use App\Models\ProdukBlud;
use Database\Seeders\ProdukBludSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BludProdukTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ProdukBludSeeder::class);
    }

    public function test_blud_index_returns_success_and_lists_products(): void
    {
        $response = $this->get(route('blud.index'));

        $response->assertOk();
        $response->assertSee('Cheeseroll');
        $response->assertSee('Website Sekolah');
    }

    public function test_showcase_detail_page_returns_success(): void
    {
        $response = $this->get(route('blud.detail', 'cheeseroll'));

        $response->assertOk();
        $response->assertSee('Minta Penawaran');
        $response->assertSee('Cheeseroll');
        $response->assertSee('Spesifikasi Produk');
    }

    public function test_kustom_detail_page_returns_success(): void
    {
        $response = $this->get(route('blud.detail', 'website-sekolah'));

        $response->assertOk();
        $response->assertSee('Karya siswa');
        $response->assertSee('Ketua tim');
        $response->assertSee('Tentang Karya');
    }

    public function test_unknown_slug_returns_404(): void
    {
        $response = $this->get('/blud/tidak-ada');

        $response->assertNotFound();
    }

    public function test_blud_index_search_filters_products_backend(): void
    {
        $this->get(route('blud.index', ['q' => 'Cheeseroll']))
            ->assertOk()
            ->assertSee('Cheeseroll');

        $this->get(route('blud.index', ['q' => 'zonk-tidak-ada-produk']))
            ->assertOk()
            ->assertDontSee('Cheeseroll')
            ->assertDontSee('Website Sekolah');
    }

    public function test_post_komentar_creates_row_and_redirects(): void
    {
        $response = $this->post(route('blud.komentar.store', 'cheeseroll'), [
            'nama' => 'Tester',
            'komentar' => 'Produk sangat bagus.',
            'rating' => 5,
        ]);

        $response->assertRedirect(route('blud.detail', 'cheeseroll'));
        $response->assertSessionHas('success', 'Komentar terkirim.');

        $this->assertDatabaseHas('produk_blud_komentars', [
            'nama' => 'Tester',
            'komentar' => 'Produk sangat bagus.',
            'rating' => 5,
        ]);
    }

    public function test_post_komentar_missing_komentar_fails_validation(): void
    {
        $produk = ProdukBlud::where('slug', 'cheeseroll')->firstOrFail();
        $beforeCount = $produk->komentars()->count();

        $response = $this->from(route('blud.detail', 'cheeseroll'))
            ->post(route('blud.komentar.store', 'cheeseroll'), [
                'nama' => 'Tester',
                'komentar' => '',
                'rating' => 5,
            ]);

        $response->assertSessionHasErrors('komentar');
        $this->assertSame($beforeCount, $produk->komentars()->count());
    }

    public function test_post_komentar_rating_out_of_range_fails_validation(): void
    {
        $response = $this->post(route('blud.komentar.store', 'cheeseroll'), [
            'nama' => 'Tester',
            'komentar' => 'Rating di luar rentang.',
            'rating' => 6,
        ]);

        $response->assertSessionHasErrors('rating');
    }

    public function test_unpublished_product_detail_returns_404(): void
    {
        ProdukBlud::create([
            'slug' => 'produk-unpublished',
            'tipe' => 'showcase',
            'title' => 'Produk Unpublished',
            'jurusan_nama' => 'TKJ',
            'jurusan_slug' => 'tkj',
            'deskripsi' => 'Produk tidak dipublikasikan.',
            'is_published' => false,
        ]);

        $response = $this->get(route('blud.detail', 'produk-unpublished'));

        $response->assertNotFound();
    }

    public function test_showcase_detail_shows_related_products_from_same_jurusan(): void
    {
        $response = $this->get(route('blud.detail', 'kemasan-umkm-custom'));

        $response->assertOk();
        $response->assertSee('Produk Lain dari Desain Komunikasi Visual');
        $response->assertSee('Jasa Desain Logo');
    }

    public function test_post_penawaran_creates_row_and_redirects(): void
    {
        $response = $this->post(route('blud.penawaran.store', 'cheeseroll'), [
            'nama' => 'Pembeli',
            'kontak' => '081234567890',
            'pesan' => 'Butuh 20 pcs untuk acara sekolah.',
        ]);

        $response->assertRedirect(route('blud.detail', 'cheeseroll'));
        $response->assertSessionHas('success', 'Permintaan penawaran Anda telah terkirim.');

        $this->assertDatabaseHas('produk_blud_penawarans', [
            'nama' => 'Pembeli',
            'kontak' => '081234567890',
            'pesan' => 'Butuh 20 pcs untuk acara sekolah.',
        ]);
    }

    public function test_post_penawaran_missing_fields_fails_validation(): void
    {
        $response = $this->from(route('blud.detail', 'cheeseroll'))
            ->post(route('blud.penawaran.store', 'cheeseroll'), []);

        $response->assertSessionHasErrors(['nama', 'kontak', 'pesan']);
    }

    public function test_post_laporkan_creates_row_and_redirects(): void
    {
        $response = $this->post(route('blud.laporkan.store', 'website-sekolah'), [
            'kategori' => 'Spam',
            'deskripsi' => 'Deskripsi produk mengandung tautan spam.',
        ]);

        $response->assertRedirect(route('blud.detail', 'website-sekolah'));
        $response->assertSessionHas('success', 'Laporan Anda telah terkirim. Kami akan segera meninjau.');

        $this->assertDatabaseHas('produk_blud_laporans', [
            'kategori' => 'Spam',
            'deskripsi' => 'Deskripsi produk mengandung tautan spam.',
        ]);
    }

    public function test_post_laporkan_invalid_kategori_fails_validation(): void
    {
        $response = $this->post(route('blud.laporkan.store', 'website-sekolah'), [
            'kategori' => 'Bukan Kategori',
            'deskripsi' => 'Test.',
        ]);

        $response->assertSessionHasErrors(['kategori']);
    }

    private function unpublishAllProduk(): void
    {
        ProdukBlud::query()->update(['is_published' => false]);
    }

    private function createProdukHero(array $overrides): ProdukBlud
    {
        return ProdukBlud::create(array_merge([
            'tipe' => 'showcase',
            'jurusan_nama' => 'TKJ',
            'jurusan_slug' => 'tkj',
            'deskripsi' => 'Deskripsi produk hero.',
            'is_published' => true,
        ], $overrides));
    }

    public function test_hero_shows_highest_rated_published_product(): void
    {
        $this->unpublishAllProduk();

        $this->createProdukHero([
            'slug' => 'produk-dibatalkan',
            'title' => 'Produk Dibatalkan',
            'rating' => 5.00,
            'is_published' => false,
        ]);
        $this->createProdukHero(['slug' => 'produk-rendah', 'title' => 'Produk Rendah', 'rating' => 3.00]);
        $this->createProdukHero(['slug' => 'produk-sedang', 'title' => 'Produk Sedang', 'rating' => 4.00]);
        $this->createProdukHero(['slug' => 'produk-juara', 'title' => 'Produk Juara', 'rating' => 5.00]);

        $response = $this->get(route('blud.index'));

        $response->assertOk();
        $response->assertSee('<h1 class="blud-hero__title">Produk Juara</h1>', false);
        $response->assertDontSee('<h1 class="blud-hero__title">Produk Rendah</h1>', false);
        $response->assertDontSee('<h1 class="blud-hero__title">Produk Sedang</h1>', false);
        $response->assertDontSee('<h1 class="blud-hero__title">Produk Dibatalkan</h1>', false);
    }

    public function test_hero_hidden_when_no_published_product(): void
    {
        $this->unpublishAllProduk();

        $response = $this->get(route('blud.index'));

        $response->assertOk();
        $response->assertDontSee('<section class="blud-hero"', false);
    }

    public function test_hero_galeri_empty_falls_back_to_placeholder(): void
    {
        $this->unpublishAllProduk();
        $this->createProdukHero([
            'slug' => 'produk-tanpa-galeri',
            'title' => 'Produk Tanpa Galeri',
            'rating' => 5.00,
        ]);

        $response = $this->get(route('blud.index'));

        $response->assertOk();
        $response->assertSee('placehold.co/1600x560', false);
        $response->assertDontSee('Jasa Pentest Website', false);
        $response->assertSee('<h1 class="blud-hero__title">Produk Tanpa Galeri</h1>', false);
    }

    public function test_hero_link_points_to_detail(): void
    {
        $this->unpublishAllProduk();
        $this->createProdukHero(['slug' => 'produk-juara', 'title' => 'Produk Juara', 'rating' => 5.00]);

        $response = $this->get(route('blud.index'));

        $response->assertOk();
        $response->assertSee(
            'href="'.route('blud.detail', 'produk-juara').'" class="blud-hero__cta"',
            false
        );
    }
}
