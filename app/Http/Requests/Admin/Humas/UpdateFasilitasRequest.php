<?php

namespace App\Http\Requests\Admin\Humas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFasilitasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:pembelajaran,pendukung'],
            'deskripsi' => ['required', 'string'],
            'jumlah' => ['nullable', 'string', 'max:100'],
            'icon' => ['nullable', 'string', 'max:100'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
