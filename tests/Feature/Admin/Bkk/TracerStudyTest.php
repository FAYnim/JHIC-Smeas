<?php

namespace Tests\Feature\Admin\Bkk;

use App\Models\Alumni;
use App\Models\KuesionerTracer;
use App\Models\TracerSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TracerStudyTest extends TestCase
{
    use RefreshDatabase;

    public function test_bkk_user_can_view_tracer_dashboard_and_alumni_list(): void
    {
        $bkk = User::factory()->bkk()->create();
        Alumni::create([
            'nisn' => '0012345678',
            'nama' => 'Ahmad Dani',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'tahun_lulus' => 2024,
            'angkatan' => 2021,
        ]);

        $response = $this->actingAs($bkk)->get(route('admin.tracer.index'));
        $response->assertOk();
        $response->assertSee('Ahmad Dani');
        $response->assertSee('0012345678');
    }

    public function test_bkk_user_can_create_and_update_alumni(): void
    {
        $bkk = User::factory()->bkk()->create();

        $response = $this->actingAs($bkk)->post(route('admin.tracer.alumni.store'), [
            'nisn' => '0098765432',
            'nama' => 'Rina Salsabila',
            'jurusan' => 'Desain Komunikasi Visual',
            'tahun_lulus' => 2025,
            'angkatan' => 2022,
        ]);

        $response->assertRedirect(route('admin.tracer.index', ['tab' => 'alumni']));
        $this->assertDatabaseHas('alumnis', [
            'nisn' => '0098765432',
            'nama' => 'Rina Salsabila',
        ]);
    }

    public function test_bkk_user_can_toggle_kuesioner_confirmation(): void
    {
        $bkk = User::factory()->bkk()->create();
        $kuesioner = KuesionerTracer::create([
            'nisn' => '0012345678',
            'nama' => 'Ahmad Dani',
            'jurusan' => 'RPL',
            'tahun_lulus' => 2024,
            'status_pekerjaan' => 'Bekerja',
            'relevansi' => 'Relevan',
            'is_konfirmasi' => false,
        ]);

        $response = $this->actingAs($bkk)->patch(route('admin.tracer.kuesioner.toggle-confirm', $kuesioner));
        $response->assertRedirect();
        $this->assertTrue($kuesioner->fresh()->is_konfirmasi);
    }

    public function test_bkk_user_can_update_tracer_settings(): void
    {
        $bkk = User::factory()->bkk()->create();
        TracerSetting::create([
            'tingkat_keterserapan' => '85%',
            'keterserapan_trend' => 'trend',
            'keterserapan_trend_warna' => 'green',
            'masa_tunggu' => '2 Bln',
            'masa_tunggu_sub' => 'sub',
            'masa_tunggu_sub_warna' => 'blue',
            'kesesuaian' => '80%',
            'kesesuaian_sub' => 'sub',
            'kesesuaian_sub_warna' => 'slate',
            'total_alumni' => '1000',
            'total_alumni_sub' => 'sub',
            'total_alumni_sub_warna' => 'blue',
        ]);

        $response = $this->actingAs($bkk)->put(route('admin.tracer.settings.store'), [
            'tingkat_keterserapan' => '92.5%',
            'masa_tunggu' => '2.1 Bulan',
            'kesesuaian' => '88%',
            'total_alumni' => '1.450+',
        ]);

        $response->assertRedirect(route('admin.tracer.index', ['tab' => 'settings']));
        $this->assertEquals('92.5%', TracerSetting::first()->tingkat_keterserapan);
    }
}
