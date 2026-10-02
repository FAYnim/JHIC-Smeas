<?php

namespace App\Http\Requests\Admin\Bkk;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlumniRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nisn' => ['required', 'string', 'digits:10', 'unique:alumnis,nisn'],
            'nama' => ['required', 'string', 'max:255'],
            'jurusan' => ['required', 'string', 'max:255'],
            'tahun_lulus' => ['required', 'integer', 'min:2000', 'max:'.(date('Y') + 1)],
            'angkatan' => ['required', 'integer', 'min:2000', 'max:'.(date('Y') + 1)],
        ];
    }
}
