<?php

namespace App\Http\Requests\Admin;

use App\Models\ProdukBludPenawaran;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePesananBludRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(array_keys(ProdukBludPenawaran::STATUSES))],
            'catatan_internal' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
