<?php

namespace Database\Factories;

use App\Models\Artikel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Artikel>
 */
class ArtikelFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 999999),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(3, true),
            'kategori' => 'berita',
            'published_at' => now(),
        ];
    }
}
