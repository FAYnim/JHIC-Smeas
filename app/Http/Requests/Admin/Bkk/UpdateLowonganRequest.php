<?php

namespace App\Http\Requests\Admin\Bkk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLowonganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'company_short' => ['nullable', 'string', 'max:50'],
            'is_mitra_dudi' => ['nullable', 'boolean'],
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'string', 'max:100'],
            'jurusan' => ['required', 'string', 'max:255'],
            'kuota' => ['required', 'integer', 'min:0'],
            'metode_kerja' => ['required', 'string', 'max:50'],
            'jenis' => ['required', 'in:magang,lowongan'],
            'deskripsi' => ['required', 'string'],
            'tanggung_jawab' => ['nullable', 'string'],
            'kualifikasi' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'batas_pendaftaran' => ['required', 'date'],
            'status_kuota' => ['nullable', 'string', 'max:50'],
            'pokja_nama' => ['nullable', 'string', 'max:255'],
            'pokja_koordinator' => ['nullable', 'string', 'max:255'],
            'pokja_wa' => ['nullable', 'string', 'max:30'],
            'gaji_min' => ['nullable', 'integer', 'min:0'],
            'gaji_max' => ['nullable', 'integer', 'min:0'],
            'tipe_pekerjaan' => ['nullable', 'string', 'max:100'],
            'pengalaman' => ['nullable', 'string', 'max:100'],
            'bidang_industri' => ['nullable', 'string', 'max:100'],
            'jenjang_pendidikan' => ['nullable', 'string', 'max:100'],
            'fresh_graduate_ok' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
            'mitra_id' => ['nullable', 'exists:mitra_perusahaans,id'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ];
    }
}
