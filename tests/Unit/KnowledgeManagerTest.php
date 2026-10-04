<?php

namespace Tests\Unit;

use App\Models\Lowongan;
use App\Models\Pengumuman;
use App\Services\Chatbot\KnowledgeManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class KnowledgeManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_assembles_static_and_dynamic_knowledge_correctly(): void
    {
        Cache::flush();

        Lowongan::create([
            'company_name' => 'PT Smeas Inovasi Digital',
            'title' => 'Junior Web Developer Magang',
            'slug' => 'junior-web-developer-magang',
            'location' => 'Surabaya',
            'duration' => '6 Bulan',
            'jurusan' => 'RPL',
            'deskripsi' => 'Deskripsi',
            'batas_pendaftaran' => now()->addMonth()->toDateString(),
            'durasi_pelaksanaan' => '6 Bulan',
            'jenis' => 'magang',
            'is_published' => true,
        ]);

        Pengumuman::create([
            'judul' => 'Pengumuman Libur Hari Besar',
            'slug' => 'libur-hari-besar',
            'konten' => 'Seluruh siswa diliburkan pada hari senin.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $context = (new KnowledgeManager)->getSystemContext();

        $this->assertStringContainsString('SMKN 1 Surabaya', $context);
        $this->assertStringContainsString('Junior Web Developer Magang', $context);
        $this->assertStringContainsString('Pengumuman Libur Hari Besar', $context);
    }
}
