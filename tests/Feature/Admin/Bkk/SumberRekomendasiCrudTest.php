<?php

namespace Tests\Feature\Admin\Bkk;

use App\Models\SumberRekomendasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SumberRekomendasiCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $bkk;

    private User $humas;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->bkk = User::factory()->create(['role' => User::ROLE_BKK]);
        $this->humas = User::factory()->create(['role' => User::ROLE_HUMAS]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.sumber-rekomendasi.index'))->assertRedirect(route('login'));
    }

    public function test_humas_is_forbidden(): void
    {
        $this->actingAs($this->humas)->get(route('admin.sumber-rekomendasi.index'))->assertForbidden();
    }

    public function test_bkk_and_admin_can_access_index(): void
    {
        $this->actingAs($this->bkk)->get(route('admin.sumber-rekomendasi.index'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.sumber-rekomendasi.index'))->assertOk();
    }

    public function test_store_creates_record(): void
    {
        $response = $this->actingAs($this->bkk)->post(route('admin.sumber-rekomendasi.store'), [
            'title' => 'Portal Karir Unik',
            'url' => 'https://example.com/karir',
            'kategori' => 'Lowongan Kerja',
        ]);

        $response->assertRedirect(route('admin.sumber-rekomendasi.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('sumber_rekomendasis', [
            'title' => 'Portal Karir Unik',
            'url' => 'https://example.com/karir',
        ]);
    }

    public function test_store_with_invalid_url_shows_error(): void
    {
        $this->actingAs($this->bkk)
            ->from(route('admin.sumber-rekomendasi.index'))
            ->post(route('admin.sumber-rekomendasi.store'), [
                'title' => 'Tanpa URL',
                'url' => 'bukan-url',
            ])
            ->assertSessionHasErrors('url');

        $this->assertDatabaseCount('sumber_rekomendasis', 0);
    }

    public function test_destroy_removes_record(): void
    {
        $sumber = SumberRekomendasi::create([
            'title' => 'Akan Dihapus',
            'url' => 'https://example.com/hapus',
            'urutan' => 1,
            'is_active' => true,
        ]);

        $this->actingAs($this->bkk)
            ->delete(route('admin.sumber-rekomendasi.destroy', $sumber))
            ->assertRedirect(route('admin.sumber-rekomendasi.index'));

        $this->assertDatabaseMissing('sumber_rekomendasis', ['id' => $sumber->id]);
    }
}
