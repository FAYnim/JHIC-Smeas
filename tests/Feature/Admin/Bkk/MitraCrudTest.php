<?php

namespace Tests\Feature\Admin\Bkk;

use App\Models\MitraPerusahaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MitraCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_bkk_user_can_view_mitra_list(): void
    {
        $bkk = User::factory()->bkk()->create();
        MitraPerusahaan::create([
            'name' => 'PT Surya Telekomunikasi',
            'slug' => 'pt-surya-telekomunikasi',
            'short_name' => 'SuryaTel',
            'sector' => 'Telekomunikasi',
            'city' => 'Surabaya',
        ]);

        $response = $this->actingAs($bkk)->get(route('admin.mitra.index'));
        $response->assertOk();
        $response->assertSee('PT Surya Telekomunikasi');
    }

    public function test_bkk_user_can_create_mitra_with_logo_and_programs(): void
    {
        Storage::fake('public');
        $bkk = User::factory()->bkk()->create();

        $logo = UploadedFile::fake()->image('mitra.png');

        $response = $this->actingAs($bkk)->post(route('admin.mitra.store'), [
            'name' => 'PT Tekno Maju Bersama',
            'short_name' => 'TeknoMaju',
            'sector' => 'Software House',
            'city' => 'Surabaya',
            'description' => 'Perusahaan software house mitra SMKN 1 Surabaya',
            'website' => 'https://teknomaju.example.com',
            'is_mou_active' => '1',
            'mou_until' => now()->addYears(2)->format('Y-m-d'),
            'kemitraan_sejak' => 2021,
            'programs' => "Tempat PKL Resmi\nKelas Industri",
            'narahubung_nama' => 'Hendra Setiawan',
            'narahubung_jabatan' => 'HR Manager',
            'narahubung_wa' => '081234567890',
            'logo' => $logo,
        ]);

        $response->assertRedirect(route('admin.mitra.index'));
        $this->assertDatabaseHas('mitra_perusahaans', [
            'name' => 'PT Tekno Maju Bersama',
            'slug' => 'pt-tekno-maju-bersama',
            'is_mou_active' => 1,
        ]);

        $mitra = MitraPerusahaan::where('slug', 'pt-tekno-maju-bersama')->firstOrFail();
        $this->assertNotNull($mitra->logo_path);
        Storage::disk('public')->assertExists($mitra->logo_path);
        $this->assertContains('Tempat PKL Resmi', $mitra->programs);
    }

    public function test_bkk_user_can_update_mitra(): void
    {
        $bkk = User::factory()->bkk()->create();
        $mitra = MitraPerusahaan::create([
            'name' => 'PT Awal',
            'slug' => 'pt-awal',
            'short_name' => 'Awal',
            'sector' => 'IT',
            'city' => 'Surabaya',
        ]);

        $response = $this->actingAs($bkk)->put(route('admin.mitra.update', $mitra), [
            'name' => 'PT Awal Diperbarui',
            'short_name' => 'AwalNew',
            'sector' => 'Fintech',
            'city' => 'Sidoarjo',
            'is_mou_active' => '0',
        ]);

        $response->assertRedirect(route('admin.mitra.index'));
        $this->assertDatabaseHas('mitra_perusahaans', [
            'id' => $mitra->id,
            'name' => 'PT Awal Diperbarui',
            'sector' => 'Fintech',
            'is_mou_active' => 0,
        ]);
    }

    public function test_bkk_user_can_delete_mitra(): void
    {
        $bkk = User::factory()->bkk()->create();
        $mitra = MitraPerusahaan::create([
            'name' => 'PT Hapus',
            'slug' => 'pt-hapus',
            'short_name' => 'Hapus',
            'sector' => 'IT',
            'city' => 'Surabaya',
        ]);

        $response = $this->actingAs($bkk)->delete(route('admin.mitra.destroy', $mitra));
        $response->assertRedirect(route('admin.mitra.index'));
        $this->assertDatabaseMissing('mitra_perusahaans', ['id' => $mitra->id]);
    }

    public function test_store_with_invalid_data_shows_field_errors(): void
    {
        $bkk = User::factory()->bkk()->create();

        $response = $this->actingAs($bkk)->post(route('admin.mitra.store'), [
            'name' => 'PT Uji Validasi',
            'short_name' => str_repeat('X', 60),
            'sector' => str_repeat('Y', 150),
            'city' => 'Surabaya',
            'website' => 'bukan-url-valid',
            'kemitraan_sejak' => 1900,
        ]);

        $response->assertSessionHasErrors(['short_name', 'sector', 'website', 'kemitraan_sejak']);

        $response = $this->actingAs($bkk)->get(route('admin.mitra.create'));
        $response->assertSee('URL tidak valid');
    }
}
