<?php

namespace Tests\Feature;

use Tests\TestCase;

class MajorFinderTest extends TestCase
{
    public function test_major_finder_page_is_accessible(): void
    {
        $response = $this->get(route('temukan-jurusan'));

        $response->assertStatus(200);
        $response->assertSee('Smeas AI Major Finder');
    }

    public function test_major_finder_analysis_endpoint_validates_payload(): void
    {
        $response = $this->postJson(route('temukan-jurusan.analisis'), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['top_major.name', 'top_major.score']);
    }

    public function test_major_finder_analysis_endpoint_returns_json_response(): void
    {
        $payload = [
            'nama' => 'Ahmad',
            'top_major' => [
                'name' => 'Rekayasa Perangkat Lunak',
                'score' => 94,
            ],
            'alternatives' => [
                ['name' => 'Teknik Komputer dan Jaringan', 'score' => 82],
                ['name' => 'Desain Komunikasi Visual', 'score' => 68],
            ],
            'highlights' => ['coding', 'debugging'],
        ];

        $response = $this->postJson(route('temukan-jurusan.analisis'), $payload);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'analysis',
        ]);
        $this->assertTrue($response->json('success'));
        $this->assertNotEmpty($response->json('analysis'));
    }

    public function test_service_generates_personalized_analysis(): void
    {
        $service = app(\App\Services\MajorFinder\MajorAnalysisService::class);
        $analysis = $service->generate(
            nama: 'Budi',
            topMajor: ['name' => 'Rekayasa Perangkat Lunak', 'score' => 95],
            alternatives: [['name' => 'Teknik Komputer dan Jaringan', 'score' => 80]],
            highlights: ['coding', 'debugging']
        );

        $this->assertNotEmpty($analysis);
        $this->assertStringContainsString('Budi', $analysis);
        $this->assertStringContainsString('Rekayasa Perangkat Lunak', $analysis);
    }
}
