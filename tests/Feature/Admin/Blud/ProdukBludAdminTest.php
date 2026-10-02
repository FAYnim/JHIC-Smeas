<?php

namespace Tests\Feature\Admin\Blud;

use App\Models\ProdukBlud;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdukBludAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    private User $bkkUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->bkkUser = User::factory()->create(['role' => User::ROLE_BKK]);
    }

    public function test_only_admin_can_access_produk_blud_admin(): void
    {
        $responseGuest = $this->get(route('admin.produk-blud.index'));
        $responseGuest->assertRedirect(route('login'));

        $responseBkk = $this->actingAs($this->bkkUser)->get(route('admin.produk-blud.index'));
        $responseBkk->assertForbidden();

        $responseAdmin = $this->actingAs($this->adminUser)->get(route('admin.produk-blud.index'));
        $responseAdmin->assertOk();
    }

    public function test_admin_can_view_and_filter_produk_blud(): void
    {
        ProdukBlud::create([
            'slug' => 'aplikasi-kasir-pos',
            'tipe' => ProdukBlud::TIPE_SHOWCASE,
            'title' => 'Aplikasi Kasir POS',
            'jurusan_nama' => 'Rekayasa Perangkat Lunak',
            'jurusan_slug' => 'rpl',
            'deskripsi' => 'Aplikasi kasir berbasis cloud',
            'is_published' => true,
        ]);

        ProdukBlud::create([
            'slug' => 'kaos-sablon-kustom',
            'tipe' => ProdukBlud::TIPE_KUSTOM,
            'title' => 'Kaos Sablon Kustom',
            'jurusan_nama' => 'Desain Komunikasi Visual',
            'jurusan_slug' => 'dkv',
            'deskripsi' => 'Kaos sablon desain suka-suka',
            'is_published' => false,
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('admin.produk-blud.index'));
        $response->assertOk();
        $response->assertSee('Aplikasi Kasir POS');
        $response->assertSee('Kaos Sablon Kustom');

        // Filter tipe
        $responseTipe = $this->actingAs($this->adminUser)->get(route('admin.produk-blud.index', ['tipe' => 'kustom']));
        $responseTipe->assertOk();
        $responseTipe->assertDontSee('Aplikasi Kasir POS');
        $responseTipe->assertSee('Kaos Sablon Kustom');

        // Filter published status
        $responseStatus = $this->actingAs($this->adminUser)->get(route('admin.produk-blud.index', ['status' => 'draft']));
        $responseStatus->assertOk();
        $responseStatus->assertDontSee('Aplikasi Kasir POS');
        $responseStatus->assertSee('Kaos Sablon Kustom');
    }

    public function test_admin_can_toggle_published_status(): void
    {
        $produk = ProdukBlud::create([
            'slug' => 'jasa-perbaikan-pc',
            'tipe' => ProdukBlud::TIPE_SHOWCASE,
            'title' => 'Jasa Perbaikan PC',
            'jurusan_nama' => 'Teknik Komputer Jaringan',
            'jurusan_slug' => 'tkj',
            'deskripsi' => 'Service PC & Laptop',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->adminUser)->patch(route('admin.produk-blud.toggle-publish', $produk));
        $response->assertRedirect();

        $this->assertFalse($produk->fresh()->is_published);

        $response2 = $this->actingAs($this->adminUser)->patch(route('admin.produk-blud.toggle-publish', $produk));
        $response2->assertRedirect();

        $this->assertTrue($produk->fresh()->is_published);
    }
}
