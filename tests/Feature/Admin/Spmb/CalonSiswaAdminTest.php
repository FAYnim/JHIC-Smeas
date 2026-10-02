<?php

namespace Tests\Feature\Admin\Spmb;

use App\Models\CalonSiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CalonSiswaAdminTest extends TestCase
{
    use RefreshDatabase;

    private User $spmbUser;

    private User $adminUser;

    private User $bkkUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->spmbUser = User::factory()->create(['role' => User::ROLE_SPMB]);
        $this->adminUser = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->bkkUser = User::factory()->create(['role' => User::ROLE_BKK]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('admin.calon-siswa.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_unauthorized_role_gets_403(): void
    {
        $response = $this->actingAs($this->bkkUser)->get(route('admin.calon-siswa.index'));
        $response->assertForbidden();
    }

    public function test_spmb_and_admin_can_access_index_and_filter(): void
    {
        CalonSiswa::create([
            'nisn' => '1111111111',
            'nama_lengkap' => 'Calon Siswa RPL',
            'asal_sekolah' => 'SMPN 1 Surabaya',
            'jurusan_pilihan' => 'Rekayasa Perangkat Lunak',
            'jalur_pendaftaran' => 'Prestasi Akademik',
            'status_verifikasi' => 'menunggu',
        ]);

        CalonSiswa::create([
            'nisn' => '2222222222',
            'nama_lengkap' => 'Calon Siswa TKJ',
            'asal_sekolah' => 'SMPN 2 Surabaya',
            'jurusan_pilihan' => 'Teknik Komputer Jaringan',
            'jalur_pendaftaran' => 'Domisili',
            'status_verifikasi' => 'terverifikasi',
        ]);

        // SPMB user can see index
        $response = $this->actingAs($this->spmbUser)->get(route('admin.calon-siswa.index'));
        $response->assertOk();
        $response->assertSee('Calon Siswa RPL');
        $response->assertSee('Calon Siswa TKJ');

        // Filter by jurusan
        $responseFilter = $this->actingAs($this->spmbUser)->get(route('admin.calon-siswa.index', ['jurusan' => 'Rekayasa Perangkat Lunak']));
        $responseFilter->assertOk();
        $responseFilter->assertSee('Calon Siswa RPL');
        $responseFilter->assertDontSee('Calon Siswa TKJ');

        // Filter by status
        $responseStatus = $this->actingAs($this->spmbUser)->get(route('admin.calon-siswa.index', ['status' => 'terverifikasi']));
        $responseStatus->assertOk();
        $responseStatus->assertDontSee('Calon Siswa RPL');
        $responseStatus->assertSee('Calon Siswa TKJ');

        // Search NISN
        $responseSearch = $this->actingAs($this->adminUser)->get(route('admin.calon-siswa.index', ['search' => '1111111111']));
        $responseSearch->assertOk();
        $responseSearch->assertSee('Calon Siswa RPL');
        $responseSearch->assertDontSee('Calon Siswa TKJ');
    }

    public function test_can_view_detail_calon_siswa_and_uploaded_documents(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('spmb/1234567890/akta.pdf', 'akta content');
        Storage::disk('public')->put('spmb/1234567890/ijazah.jpg', 'ijazah content');

        $calonSiswa = CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Dewi Sartika',
            'asal_sekolah' => 'SMPN 3 Surabaya',
            'jurusan_pilihan' => 'Bisnis Digital',
            'status_verifikasi' => 'menunggu',
        ]);

        $response = $this->actingAs($this->spmbUser)->get(route('admin.calon-siswa.show', $calonSiswa));
        $response->assertOk();
        $response->assertSee('Dewi Sartika');
        $response->assertSee('1234567890');
        $response->assertSee('akta.pdf');
        $response->assertSee('ijazah.jpg');
    }

    public function test_can_update_status_verifikasi(): void
    {
        $calonSiswa = CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Dewi Sartika',
            'asal_sekolah' => 'SMPN 3 Surabaya',
            'status_verifikasi' => 'menunggu',
        ]);

        $response = $this->actingAs($this->spmbUser)->patch(route('admin.calon-siswa.update-verifikasi', $calonSiswa), [
            'status_verifikasi' => 'terverifikasi',
            'catatan_verifikasi' => 'Seluruh berkas lengkap dan terkonfirmasi valid.',
        ]);

        $response->assertRedirect(route('admin.calon-siswa.show', $calonSiswa));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('calon_siswas', [
            'id' => $calonSiswa->id,
            'status_verifikasi' => 'terverifikasi',
            'catatan_verifikasi' => 'Seluruh berkas lengkap dan terkonfirmasi valid.',
        ]);
    }
}
