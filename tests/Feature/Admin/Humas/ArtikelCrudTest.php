<?php

namespace Tests\Feature\Admin\Humas;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArtikelCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $humas;

    private User $spmb;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->humas = User::factory()->create(['role' => User::ROLE_HUMAS]);
        $this->spmb = User::factory()->create(['role' => User::ROLE_SPMB]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.artikel.index'))->assertRedirect(route('login'));
    }

    public function test_spmb_is_forbidden(): void
    {
        $this->actingAs($this->spmb)->get(route('admin.artikel.index'))->assertForbidden();
    }

    public function test_humas_and_admin_can_access_index(): void
    {
        $this->actingAs($this->humas)->get(route('admin.artikel.index'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.artikel.index'))->assertOk();
    }

    public function test_can_create_artikel_with_cover_upload(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('berita.jpg');

        $response = $this->actingAs($this->humas)->post(route('admin.artikel.store'), [
            'title' => 'Siswa SMKN 1 Surabaya Juara LKS Nasional 2026',
            'slug' => '',
            'excerpt' => 'Prestasi membanggakan kembali diraih oleh kontingen SMKN 1 Surabaya.',
            'content' => 'Konten lengkap berita prestasi siswa dan dedikasi pembina.',
            'kategori' => 'Prestasi',
            'published_at' => now()->format('Y-m-d H:i:s'),
            'image' => $file,
        ]);

        $response->assertRedirect(route('admin.artikel.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('artikels', [
            'title' => 'Siswa SMKN 1 Surabaya Juara LKS Nasional 2026',
            'slug' => 'siswa-smkn-1-surabaya-juara-lks-nasional-2026',
            'kategori' => 'Prestasi',
        ]);

        $artikel = Artikel::where('slug', 'siswa-smkn-1-surabaya-juara-lks-nasional-2026')->firstOrFail();
        $this->assertNotNull($artikel->image_path);
        Storage::disk('public')->assertExists($artikel->image_path);
        $this->assertNotNull($artikel->reading_time);
    }

    public function test_can_update_artikel(): void
    {
        $artikel = Artikel::create([
            'title' => 'Judul Artikel Lama',
            'slug' => 'judul-artikel-lama',
            'excerpt' => 'Ringkasan lama',
            'content' => 'Konten lama',
            'kategori' => 'Informasi',
            'published_at' => now(),
        ]);

        $response = $this->actingAs($this->humas)->put(route('admin.artikel.update', $artikel), [
            'title' => 'Judul Artikel Baru',
            'slug' => 'judul-artikel-baru',
            'excerpt' => 'Ringkasan baru',
            'content' => 'Konten baru',
            'kategori' => 'Prestasi',
            'published_at' => now()->format('Y-m-d H:i:s'),
        ]);

        $response->assertRedirect(route('admin.artikel.index'));
        $this->assertDatabaseHas('artikels', [
            'id' => $artikel->id,
            'title' => 'Judul Artikel Baru',
            'slug' => 'judul-artikel-baru',
        ]);
    }

    public function test_can_delete_artikel_and_unlink_image(): void
    {
        Storage::fake('public');
        $filePath = 'artikels/dummy.jpg';
        Storage::disk('public')->put($filePath, 'image data');

        $artikel = Artikel::create([
            'title' => 'Artikel Hapus',
            'slug' => 'artikel-hapus',
            'excerpt' => 'Ringkasan',
            'content' => 'Konten',
            'kategori' => 'Umum',
            'published_at' => now(),
            'image_path' => $filePath,
        ]);

        $response = $this->actingAs($this->humas)->delete(route('admin.artikel.destroy', $artikel));

        $response->assertRedirect(route('admin.artikel.index'));
        $this->assertDatabaseMissing('artikels', ['id' => $artikel->id]);
        Storage::disk('public')->assertMissing($filePath);
    }
}
