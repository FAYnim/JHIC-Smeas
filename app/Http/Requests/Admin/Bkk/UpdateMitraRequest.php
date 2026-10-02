<?php

namespace App\Http\Requests\Admin\Bkk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMitraRequest extends FormRequest
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

    public function messages(): array
    {
        return [
            'name.required' => 'Nama perusahaan wajib diisi.',
            'name.max' => 'Nama perusahaan maksimal 255 karakter.',
            'short_name.required' => 'Nama singkat wajib diisi.',
            'short_name.max' => 'Nama singkat maksimal 50 karakter.',
            'sector.required' => 'Sektor industri wajib diisi.',
            'sector.max' => 'Sektor industri maksimal 100 karakter.',
            'city.required' => 'Kota wajib diisi.',
            'city.max' => 'Kota maksimal 100 karakter.',
            'website.url' => 'URL tidak valid — gunakan format https://contoh.com',
            'website.max' => 'URL website maksimal 255 karakter.',
            'logo_color.max' => 'Warna logo maksimal 20 karakter.',
            'logo_text.max' => 'Teks logo maksimal 10 karakter.',
            'mou_until.date' => 'Tanggal berlaku MoU tidak valid.',
            'kemitraan_sejak.integer' => 'Tahun kemitraan harus berupa angka.',
            'kemitraan_sejak.min' => 'Tahun kemitraan minimal 1950.',
            'kemitraan_sejak.max' => 'Tahun kemitraan maksimal tahun depan.',
            'narahubung_nama.max' => 'Nama narahubung maksimal 255 karakter.',
            'narahubung_jabatan.max' => 'Jabatan narahubung maksimal 100 karakter.',
            'narahubung_wa.max' => 'Nomor WhatsApp narahubung maksimal 30 karakter.',
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Format logo harus PNG, JPG, atau WEBP.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
        ];
    }
}
