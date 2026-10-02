<?php

namespace App\Http\Requests\Admin\Humas;

use Illuminate\Foundation\Http\FormRequest;

class StoreArtikelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:artikels,slug'],
            'excerpt' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'kategori' => ['required', 'string', 'max:100'],
            'published_at' => ['nullable', 'date'],
            'reading_time' => ['nullable', 'string', 'max:50'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'image_url' => ['nullable', 'url', 'max:500'],
        ];
    }
}
