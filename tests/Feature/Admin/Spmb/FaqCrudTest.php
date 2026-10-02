<?php

namespace Tests\Feature\Admin\Spmb;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaqCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $spmbUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->spmbUser = User::factory()->create(['role' => User::ROLE_SPMB]);
    }

    public function test_can_view_faq_index_and_create_faq(): void
    {
        $response = $this->actingAs($this->spmbUser)->get(route('admin.faq.index'));
        $response->assertOk();

        $createResponse = $this->actingAs($this->spmbUser)->post(route('admin.faq.store'), [
            'kategori' => 'Pendaftaran',
            'pertanyaan' => 'Kapan pendaftaran ditutup?',
            'jawaban' => 'Pendaftaran ditutup tanggal 30 Juni.',
            'urutan' => 1,
            'is_active' => 1,
        ]);

        $createResponse->assertRedirect(route('admin.faq.index'));
        $this->assertDatabaseHas('faqs', [
            'pertanyaan' => 'Kapan pendaftaran ditutup?',
            'kategori' => 'Pendaftaran',
        ]);
    }

    public function test_can_update_and_delete_faq(): void
    {
        $faq = Faq::create([
            'kategori' => 'Umum',
            'pertanyaan' => 'Pertanyaan Lama?',
            'jawaban' => 'Jawaban Lama',
            'urutan' => 1,
            'is_active' => true,
        ]);

        $updateResponse = $this->actingAs($this->spmbUser)->put(route('admin.faq.update', $faq), [
            'kategori' => 'Umum',
            'pertanyaan' => 'Pertanyaan Diperbarui?',
            'jawaban' => 'Jawaban Diperbarui',
            'urutan' => 2,
            'is_active' => 1,
        ]);

        $updateResponse->assertRedirect(route('admin.faq.index'));
        $this->assertDatabaseHas('faqs', [
            'id' => $faq->id,
            'pertanyaan' => 'Pertanyaan Diperbarui?',
        ]);

        $deleteResponse = $this->actingAs($this->spmbUser)->delete(route('admin.faq.destroy', $faq));
        $deleteResponse->assertRedirect(route('admin.faq.index'));
        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }
}
