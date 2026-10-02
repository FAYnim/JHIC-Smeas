<?php

namespace App\Http\Requests\Admin\Bkk;

use Illuminate\Foundation\Http\FormRequest;

class StoreBimbinganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bimbingan_kategori_id' => ['required', 'exists:bimbingan_kategori,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'external_url' => ['nullable', 'url', 'max:255'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }
}
