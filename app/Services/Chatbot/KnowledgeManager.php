<?php

namespace App\Services\Chatbot;

use App\Models\Lowongan;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Throwable;

class KnowledgeManager
{
    protected string $knowledgePath;

    public function __construct(?string $knowledgePath = null)
    {
        $this->knowledgePath = $knowledgePath ?? resource_path('knowledge/smeas-knowledge.md');
    }

    public function getSystemContext(): string
    {
        return Cache::remember('smeas_ai_full_context', 900, function (): string {
            $staticContent = File::exists($this->knowledgePath)
                ? File::get($this->knowledgePath)
                : '';

            return $staticContent."\n\n".$this->buildDynamicContent();
        });
    }

    protected function buildDynamicContent(): string
    {
        $lines = ['## INFORMASI TERKINI & LOWONGAN AKTIF (DATABASE LIVE)'];

        try {
            $lowongans = Lowongan::where('is_published', true)
                ->latest()
                ->take(5)
                ->get(['title', 'company_name', 'jenis', 'location', 'slug']);

            if ($lowongans->isNotEmpty()) {
                $lines[] = '### Lowongan Kerja & Magang Tersedia di Pusat Karir:';
                foreach ($lowongans as $l) {
                    $link = $l->slug ? "/pusat-karir/{$l->slug}" : '/pusat-karir';
                    $lines[] = "- [{$l->jenis}] {$l->title} di {$l->company_name} ({$l->location}) - Detail: {$link}";
                }
            }
        } catch (Throwable) {
            // Tabel belum tersedia (mis. belum migrate).
        }

        try {
            $pengumumans = Pengumuman::published()->latest()->take(3)->get(['judul']);

            if ($pengumumans->isNotEmpty()) {
                $lines[] = '### Pengumuman Terbaru:';
                foreach ($pengumumans as $p) {
                    $lines[] = "- {$p->judul}";
                }
            }
        } catch (Throwable) {
            // Tabel belum tersedia.
        }

        return implode("\n", $lines);
    }
}
