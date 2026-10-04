<?php

namespace Tests\Feature\Admin\Blud;

use App\Models\ProdukBlud;
use App\Models\ProdukBludPenawaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PesananAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $blud;

    private ProdukBludPenawaran $pesanan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->blud = User::factory()->blud()->create();

        $produk = ProdukBlud::create([
            'slug' => 'produk-pesanan',
            'tipe' => ProdukBlud::TIPE_KUSTOM,
            'title' => 'Kaos Kustom',
            'jurusan_nama' => 'DKV',
            'jurusan_slug' => 'dkv',
            'deskripsi' => 'Deskripsi',
        ]);

        $this->pesanan = ProdukBludPenawaran::create([
            'produk_blud_id' => $produk->id,
            'nama' => 'Budi Client',
            'kontak' => '0812345678',
            'pesan' => 'Saya ingin pesan 50 kaos',
        ]);
    }

    public function test_guest_and_other_roles_cannot_access(): void
    {
        $this->get(route('admin.pesanan-blud.index'))->assertRedirect(route('login'));

        $this->actingAs(User::factory()->spmb()->create())
            ->get(route('admin.pesanan-blud.index'))
            ->assertForbidden();
    }

    public function test_index_lists_and_filters_by_status(): void
    {
        $this->actingAs($this->blud)
            ->get(route('admin.pesanan-blud.index'))
            ->assertOk()
            ->assertSee('Budi Client');

        $this->actingAs($this->blud)
            ->get(route('admin.pesanan-blud.index', ['status' => 'selesai']))
            ->assertOk()
            ->assertDontSee('Budi Client');
    }

    public function test_index_can_search_by_name(): void
    {
        $this->actingAs($this->blud)
            ->get(route('admin.pesanan-blud.index', ['q' => 'Budi']))
            ->assertOk()
            ->assertSee('Budi Client');

        $this->actingAs($this->blud)
            ->get(route('admin.pesanan-blud.index', ['q' => 'tidak-ada']))
            ->assertDontSee('Budi Client');
    }

    public function test_show_displays_whatsapp_link(): void
    {
        $this->actingAs($this->blud)
            ->get(route('admin.pesanan-blud.show', $this->pesanan))
            ->assertOk()
            ->assertSee('https://wa.me/62812345678', false);
    }

    public function test_update_changes_status_note_and_handler(): void
    {
        $this->actingAs($this->blud)
            ->patch(route('admin.pesanan-blud.update', $this->pesanan), [
                'status' => 'dihubungi',
                'catatan_internal' => 'Sudah dihubungi via WA',
            ])
            ->assertRedirect(route('admin.pesanan-blud.show', $this->pesanan));

        $this->assertDatabaseHas('produk_blud_penawarans', [
            'id' => $this->pesanan->id,
            'status' => 'dihubungi',
            'catatan_internal' => 'Sudah dihubungi via WA',
            'ditangani_oleh' => $this->blud->id,
        ]);
    }

    public function test_update_rejects_invalid_status(): void
    {
        $this->actingAs($this->blud)
            ->patch(route('admin.pesanan-blud.update', $this->pesanan), ['status' => 'ngawur'])
            ->assertSessionHasErrors('status');
    }

    public function test_destroy_removes_pesanan(): void
    {
        $this->actingAs($this->blud)
            ->delete(route('admin.pesanan-blud.destroy', $this->pesanan))
            ->assertRedirect(route('admin.pesanan-blud.index'));

        $this->assertDatabaseMissing('produk_blud_penawarans', ['id' => $this->pesanan->id]);
    }
}
