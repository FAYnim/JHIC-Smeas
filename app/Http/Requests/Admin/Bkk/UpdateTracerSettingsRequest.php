<?php

namespace App\Http\Requests\Admin\Bkk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTracerSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tingkat_keterserapan' => ['nullable', 'string', 'max:50'],
            'keterserapan_trend' => ['nullable', 'string', 'max:50'],
            'keterserapan_trend_warna' => ['nullable', 'string', 'max:50'],
            'masa_tunggu' => ['nullable', 'string', 'max:50'],
            'masa_tunggu_sub' => ['nullable', 'string', 'max:50'],
            'masa_tunggu_sub_warna' => ['nullable', 'string', 'max:50'],
            'kesesuaian' => ['nullable', 'string', 'max:50'],
            'kesesuaian_sub' => ['nullable', 'string', 'max:50'],
            'kesesuaian_sub_warna' => ['nullable', 'string', 'max:50'],
            'total_alumni' => ['nullable', 'string', 'max:50'],
            'total_alumni_sub' => ['nullable', 'string', 'max:50'],
            'total_alumni_sub_warna' => ['nullable', 'string', 'max:50'],
            'catatan_bmw' => ['nullable', 'string'],
        ];
    }
}
