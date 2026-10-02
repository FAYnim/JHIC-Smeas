<?php

namespace Tests\Feature\Admin\Humas;

use App\Models\StrukturOrganisasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StrukturOrganisasiCrudTest extends TestCase
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
        $response = $this->get(route('admin.struktur-organisasi.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_spmb_role_is_forbidden(): void
    {
        $response = $this->actingAs($this->spmb)->get(route('admin.struktur-organisasi.index'));
        $response->assertForbidden();
    }

    public function test_humas_can_view_index(): void
    {
        $response = $this->actingAs($this->humas)->get(route('admin.struktur-organisasi.index'));
        $response->assertOk();
    }

    public function test_can_create_wakil_with_photo(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('wakil.jpg');

        $response = $this->actingAs($this->humas)->post(route('admin.struktur-organisasi.store'), [
            'nama' => 'Drs. H. Pimpinan Baru, M.Pd.',
            'jabatan' => 'Wakil Kepala Sekolah',
            'nip' => '19700101 199501 1 002',
            'bidang' => 'Sarana & Prasarana',
            'kategori' => 'wakil',
            'urutan' => 3,
            'foto' => $file,
        ]);

        $response->assertRedirect(route('admin.struktur-organisasi.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('struktur_organisasis', [
            'nama' => 'Drs. H. Pimpinan Baru, M.Pd.',
            'kategori' => 'wakil',
            'bidang' => 'Sarana & Prasarana',
        ]);

        $record = StrukturOrganisasi::where('nama', 'Drs. H. Pimpinan Baru, M.Pd.')->firstOrFail();
        $this->assertNotNull($record->foto_path);
        Storage::disk('public')->assertExists($record->foto_path);
    }

    public function test_can_create_bagian_unit(): void
    {
        $response = $this->actingAs($this->humas)->post(route('admin.struktur-organisasi.store'), [
            'nama' => 'Unit Publikasi & Media',
            'kategori' => 'bagian',
            'icon' => 'newspaper',
            'deskripsi' => 'Pengelolaan portal berita dan media sosial sekolah.',
            'urutan' => 7,
        ]);

        $response->assertRedirect(route('admin.struktur-organisasi.index'));
        $this->assertDatabaseHas('struktur_organisasis', [
            'nama' => 'Unit Publikasi & Media',
            'kategori' => 'bagian',
            'icon' => 'newspaper',
        ]);
    }

    public function test_can_update_struktur(): void
    {
        $item = StrukturOrganisasi::create([
            'nama' => 'Unit Lama',
            'kategori' => 'bagian',
            'deskripsi' => 'Deskripsi lama',
            'urutan' => 1,
        ]);

        $response = $this->actingAs($this->humas)->put(route('admin.struktur-organisasi.update', $item), [
            'nama' => 'Unit Terkini',
            'kategori' => 'bagian',
            'deskripsi' => 'Deskripsi baru yang diperbarui',
            'urutan' => 2,
        ]);

        $response->assertRedirect(route('admin.struktur-organisasi.index'));
        $this->assertDatabaseHas('struktur_organisasis', [
            'id' => $item->id,
            'nama' => 'Unit Terkini',
            'deskripsi' => 'Deskripsi baru yang diperbarui',
        ]);
    }

    public function test_can_delete_struktur_and_unlink_photo(): void
    {
        Storage::fake('public');
        $photoPath = 'struktur/wakil-hapus.jpg';
        Storage::disk('public')->put($photoPath, 'dummy photo');

        $item = StrukturOrganisasi::create([
            'nama' => 'Wakil Dihapus',
            'kategori' => 'wakil',
            'foto_path' => $photoPath,
            'urutan' => 1,
        ]);

        $response = $this->actingAs($this->humas)->delete(route('admin.struktur-organisasi.destroy', $item));

        $response->assertRedirect(route('admin.struktur-organisasi.index'));
        $this->assertDatabaseMissing('struktur_organisasis', ['id' => $item->id]);
        Storage::disk('public')->assertMissing($photoPath);
    }
}
