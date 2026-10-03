<?php

namespace Tests\Feature\Admin\Blud;

use App\Models\ProdukBlud;
use App\Models\ProdukBludKomentar;
use App\Models\ProdukBludLaporkan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModerasiAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    private User $spmbUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->spmbUser = User::factory()->create(['role' => User::ROLE_SPMB]);
    }

    public function test_only_blud_staff_and_admin_can_access_moderasi_blud(): void
    {
        $responseGuest = $this->get(route('admin.moderasi-blud.index'));
        $responseGuest->assertRedirect(route('login'));

        $responseSpmb = $this->actingAs($this->spmbUser)->get(route('admin.moderasi-blud.index'));
        $responseSpmb->assertForbidden();

        $responseAdmin = $this->actingAs($this->adminUser)->get(route('admin.moderasi-blud.index'));
        $responseAdmin->assertOk();
    }

    public function test_admin_can_view_and_delete_komentar(): void
    {
        $produk = ProdukBlud::create([
            'slug' => 'produk-sample-1',
            'tipe' => ProdukBlud::TIPE_SHOWCASE,
            'title' => 'Sample Produk 1',
            'jurusan_nama' => 'RPL',
            'jurusan_slug' => 'rpl',
            'deskripsi' => 'Deskripsi',
        ]);

        $komentar = ProdukBludKomentar::create([
            'produk_blud_id' => $produk->id,
            'nama' => 'Spammer',
            'komentar' => 'Komentar spam tidak pantas',
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('admin.moderasi-blud.index', ['tab' => 'komentar']));
        $response->assertOk();
        $response->assertSee('Komentar spam tidak pantas');

        $deleteResponse = $this->actingAs($this->adminUser)->delete(route('admin.moderasi-blud.destroy-komentar', $komentar));
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('produk_blud_komentars', ['id' => $komentar->id]);
    }

    public function test_admin_can_view_and_delete_laporan(): void
    {
        $produk = ProdukBlud::create([
            'slug' => 'produk-sample-3',
            'tipe' => ProdukBlud::TIPE_SHOWCASE,
            'title' => 'Sample Produk 3',
            'jurusan_nama' => 'AK',
            'jurusan_slug' => 'ak',
            'deskripsi' => 'Deskripsi',
        ]);

        $laporan = ProdukBludLaporkan::create([
            'produk_blud_id' => $produk->id,
            'kategori' => 'Produk melanggar hak cipta',
            'deskripsi' => 'Desain logo meniru brand lain',
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('admin.moderasi-blud.index', ['tab' => 'laporan']));
        $response->assertOk();
        $response->assertSee('Produk melanggar hak cipta');

        $deleteResponse = $this->actingAs($this->adminUser)->delete(route('admin.moderasi-blud.destroy-laporan', $laporan));
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('produk_blud_laporans', ['id' => $laporan->id]);
    }
}
