<?php

namespace App\Http\Requests\Admin\Bkk;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAlumniRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $alumniId = $this->route('alumni')?->id ?? $this->route('alumni');

        return [
            'nisn' => [
                'required',
                'string',
                'digits:10',
                Rule::unique('alumnis', 'nisn')->ignore($alumniId),
            ],
            'nama' => ['required', 'string', 'max:255'],
            'jurusan' => ['required', 'string', 'max:255'],
            'tahun_lulus' => ['required', 'integer', 'min:2000', 'max:'.(date('Y') + 1)],
            'angkatan' => ['required', 'integer', 'min:2000', 'max:'.(date('Y') + 1)],
        ];
    }
}
