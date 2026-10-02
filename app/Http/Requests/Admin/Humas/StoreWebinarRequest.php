<?php

namespace App\Http\Requests\Admin\Humas;

use Illuminate\Foundation\Http\FormRequest;

class StoreWebinarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:webinars,slug'],
            'description' => ['required', 'string'],
            'speaker' => ['required', 'string', 'max:255'],
            'platform' => ['required', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'start_time' => ['required', 'string', 'max:50'],
            'registration_url' => ['required', 'url', 'max:500'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }
}
