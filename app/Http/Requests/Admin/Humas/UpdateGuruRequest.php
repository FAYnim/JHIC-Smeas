<?php

namespace App\Http\Requests\Admin\Humas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'mapel' => ['nullable', 'string', 'max:255'],
            'kategori' => ['required', 'in:guru,tendik'],
            'warna' => ['nullable', 'string', 'max:100'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
