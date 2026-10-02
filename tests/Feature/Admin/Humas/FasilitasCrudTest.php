<?php

namespace Tests\Feature\Admin\Humas;

use App\Models\Fasilitas;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FasilitasCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $humas;

    private User $bkk;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->humas = User::factory()->create(['role' => User::ROLE_HUMAS]);
        $this->bkk = User::factory()->create(['role' => User::ROLE_BKK]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.fasilitas.index'))->assertRedirect(route('login'));
    }

    public function test_other_role_is_forbidden(): void
    {
        $this->actingAs($this->bkk)->get(route('admin.fasilitas.index'))->assertForbidden();
    }

    public function test_humas_can_view_index(): void
    {
        $this->actingAs($this->humas)->get(route('admin.fasilitas.index'))->assertOk();
    }

    public function test_can_create_fasilitas_with_image_upload(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('lab.jpg');

        $response = $this->actingAs($this->humas)->post(route('admin.fasilitas.store'), [
            'nama' => 'Studio Animasi & Motion',
            'kategori' => 'pembelajaran',
            'deskripsi' => 'Studio lengkap dengan workstation render dan graphic tablet.',
            'jumlah' => '2 Studio',
            'icon' => 'film',
            'urutan' => 4,
            'image' => $file,
        ]);

        $response->assertRedirect(route('admin.fasilitas.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('fasilitas', [
            'nama' => 'Studio Animasi & Motion',
            'kategori' => 'pembelajaran',
            'jumlah' => '2 Studio',
        ]);

        $item = Fasilitas::where('nama', 'Studio Animasi & Motion')->firstOrFail();
        $this->assertNotNull($item->image_path);
        Storage::disk('public')->assertExists($item->image_path);
    }

    public function test_can_update_fasilitas(): void
    {
        $item = Fasilitas::create([
            'nama' => 'Kantin Lama',
            'kategori' => 'pendukung',
            'deskripsi' => 'Kantin sekolah lama',
            'jumlah' => '1 Unit',
            'icon' => 'food',
            'urutan' => 1,
        ]);

        $response = $this->actingAs($this->humas)->put(route('admin.fasilitas.update', $item), [
            'nama' => 'Pujasera Modern Smeas',
            'kategori' => 'pendukung',
            'deskripsi' => 'Food court bersih dan higienis bersertifikasi halal',
            'jumlah' => '1 Kompleks',
            'icon' => 'food',
            'urutan' => 2,
        ]);

        $response->assertRedirect(route('admin.fasilitas.index'));
        $this->assertDatabaseHas('fasilitas', [
            'id' => $item->id,
            'nama' => 'Pujasera Modern Smeas',
            'jumlah' => '1 Kompleks',
        ]);
    }

    public function test_can_delete_fasilitas_and_unlink_image(): void
    {
        Storage::fake('public');
        $imagePath = 'fasilitas/dummy.jpg';
        Storage::disk('public')->put($imagePath, 'dummy data');

        $item = Fasilitas::create([
            'nama' => 'Gudang Lama',
            'kategori' => 'pendukung',
            'deskripsi' => 'Gudang sarana prasarana',
            'image_path' => $imagePath,
            'urutan' => 1,
        ]);

        $response = $this->actingAs($this->humas)->delete(route('admin.fasilitas.destroy', $item));

        $response->assertRedirect(route('admin.fasilitas.index'));
        $this->assertDatabaseMissing('fasilitas', ['id' => $item->id]);
        Storage::disk('public')->assertMissing($imagePath);
    }
}
