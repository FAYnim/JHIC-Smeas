<?php

namespace App\Http\Requests\Admin\Bkk;

use Illuminate\Foundation\Http\FormRequest;

class StoreMitraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'short_name' => ['required', 'string', 'max:50'],
            'sector' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
            'logo_color' => ['nullable', 'string', 'max:20'],
            'logo_text' => ['nullable', 'string', 'max:10'],
            'is_mou_active' => ['nullable', 'boolean'],
            'mou_until' => ['nullable', 'date'],
            'kemitraan_sejak' => ['nullable', 'integer', 'min:1950', 'max:'.(date('Y') + 1)],
            'programs' => ['nullable', 'string'],
            'narahubung_nama' => ['nullable', 'string', 'max:255'],
            'narahubung_jabatan' => ['nullable', 'string', 'max:100'],
            'narahubung_wa' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ];
    }
}
