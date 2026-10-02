<?php

namespace Tests\Feature\Admin\Humas;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GuruCrudTest extends TestCase
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
        $response = $this->get(route('admin.guru.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_other_role_is_forbidden(): void
    {
        $response = $this->actingAs($this->bkk)->get(route('admin.guru.index'));
        $response->assertForbidden();
    }

    public function test_humas_and_admin_can_access_index(): void
    {
        $this->actingAs($this->humas)->get(route('admin.guru.index'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.guru.index'))->assertOk();
    }

    public function test_can_create_guru_with_photo_upload(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('guru.jpg');

        $response = $this->actingAs($this->humas)->post(route('admin.guru.store'), [
            'nama' => 'Drs. Supardi, M.Pd.',
            'jabatan' => 'Guru Produktif TKJ',
            'mapel' => 'Jaringan Komputer',
            'kategori' => 'guru',
            'urutan' => 5,
            'is_active' => '1',
            'foto' => $file,
        ]);

        $response->assertRedirect(route('admin.guru.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('gurus', [
            'nama' => 'Drs. Supardi, M.Pd.',
            'kategori' => 'guru',
            'urutan' => 5,
        ]);

        $guru = Guru::where('nama', 'Drs. Supardi, M.Pd.')->firstOrFail();
        $this->assertNotNull($guru->foto_path);
        Storage::disk('public')->assertExists($guru->foto_path);
    }

    public function test_can_update_guru(): void
    {
        $guru = Guru::create([
            'nama' => 'Guru Lama',
            'jabatan' => 'Guru Produktif',
            'mapel' => 'Dasar Desain',
            'kategori' => 'guru',
            'urutan' => 2,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->humas)->put(route('admin.guru.update', $guru), [
            'nama' => 'Guru Diperbarui',
            'jabatan' => 'Kepala Program Keahlian',
            'mapel' => 'Desain Komunikasi Visual',
            'kategori' => 'guru',
            'urutan' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.guru.index'));
        $this->assertDatabaseHas('gurus', [
            'id' => $guru->id,
            'nama' => 'Guru Diperbarui',
            'mapel' => 'Desain Komunikasi Visual',
        ]);
    }

    public function test_can_toggle_active_status(): void
    {
        $guru = Guru::create([
            'nama' => 'Guru Toggle',
            'jabatan' => 'Guru',
            'kategori' => 'guru',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->humas)->patch(route('admin.guru.toggle-active', $guru));

        $response->assertRedirect();
        $this->assertDatabaseHas('gurus', [
            'id' => $guru->id,
            'is_active' => 0,
        ]);
    }

    public function test_can_delete_guru_and_unlink_photo(): void
    {
        Storage::fake('public');
        $filePath = 'guru/dummy.jpg';
        Storage::disk('public')->put($filePath, 'image content');

        $guru = Guru::create([
            'nama' => 'Guru Hapus',
            'jabatan' => 'Guru',
            'kategori' => 'guru',
            'foto_path' => $filePath,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->humas)->delete(route('admin.guru.destroy', $guru));

        $response->assertRedirect(route('admin.guru.index'));
        $this->assertDatabaseMissing('gurus', ['id' => $guru->id]);
        Storage::disk('public')->assertMissing($filePath);
    }
}
