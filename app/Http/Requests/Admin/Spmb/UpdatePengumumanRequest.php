<?php

namespace App\Http\Requests\Admin\Spmb;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePengumumanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'is_published' => 'nullable|boolean',
        ];
    }
}
