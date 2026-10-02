<?php

namespace App\Http\Requests\Admin\Humas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWebinarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $webinar = $this->route('webinar');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('webinars', 'slug')->ignore($webinar)],
            'description' => ['required', 'string'],
            'speaker' => ['required', 'string', 'max:255'],
            'platform' => ['required', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'registration_url' => ['required', 'url', 'max:500'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }
}
