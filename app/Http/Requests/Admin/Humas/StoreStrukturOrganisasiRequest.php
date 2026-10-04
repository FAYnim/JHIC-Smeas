<?php

namespace App\Http\Requests\Admin\Humas;

use Illuminate\Foundation\Http\FormRequest;

class StoreStrukturOrganisasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:kepala,wakil,bagian'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:100'],
            'bidang' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:100'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
