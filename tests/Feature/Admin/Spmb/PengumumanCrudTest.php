<?php

namespace Tests\Feature\Admin\Spmb;

use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PengumumanCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $spmbUser;

    private User $adminUser;

    private User $humasUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->spmbUser = User::factory()->create(['role' => User::ROLE_SPMB]);
        $this->adminUser = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->humasUser = User::factory()->create(['role' => User::ROLE_HUMAS]);
    }

    public function test_spmb_user_can_view_pengumuman_index(): void
    {
        Pengumuman::create([
            'judul' => 'Pengumuman Awal',
            'slug' => 'pengumuman-awal',
            'konten' => 'Konten pengumuman',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->spmbUser)->get(route('admin.pengumuman.index'));
        $response->assertOk();
        $response->assertSee('Pengumuman Awal');
    }

    public function test_spmb_user_can_create_pengumuman(): void
    {
        $response = $this->actingAs($this->spmbUser)->post(route('admin.pengumuman.store'), [
            'judul' => 'Jadwal Daftar Ulang SPMB 2026',
            'konten' => 'Daftar ulang dimulai pada tanggal 10 Juli 2026.',
            'is_published' => 1,
        ]);

        $response->assertRedirect(route('admin.pengumuman.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('pengumumans', [
            'judul' => 'Jadwal Daftar Ulang SPMB 2026',
            'slug' => 'jadwal-daftar-ulang-spmb-2026',
            'is_published' => true,
        ]);
    }

    public function test_spmb_user_can_update_and_toggle_publish_pengumuman(): void
    {
        $pengumuman = Pengumuman::create([
            'judul' => 'Judul Lama',
            'slug' => 'judul-lama',
            'konten' => 'Konten lama',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->spmbUser)->put(route('admin.pengumuman.update', $pengumuman), [
            'judul' => 'Judul Baru Diperbarui',
            'konten' => 'Konten baru yang telah diperbarui.',
            'is_published' => 1,
        ]);

        $response->assertRedirect(route('admin.pengumuman.index'));
        $this->assertDatabaseHas('pengumumans', [
            'id' => $pengumuman->id,
            'judul' => 'Judul Baru Diperbarui',
        ]);

        // Toggle publish
        $toggleResponse = $this->actingAs($this->spmbUser)->patch(route('admin.pengumuman.toggle-publish', $pengumuman));
        $toggleResponse->assertRedirect();
        $this->assertFalse($pengumuman->fresh()->is_published);
    }

    public function test_spmb_user_can_delete_pengumuman(): void
    {
        $pengumuman = Pengumuman::create([
            'judul' => 'Pengumuman Hapus',
            'slug' => 'pengumuman-hapus',
            'konten' => 'Konten',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->spmbUser)->delete(route('admin.pengumuman.destroy', $pengumuman));
        $response->assertRedirect(route('admin.pengumuman.index'));

        $this->assertDatabaseMissing('pengumumans', ['id' => $pengumuman->id]);
    }
}
