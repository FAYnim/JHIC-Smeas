<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user') instanceof User ? $this->route('user')->id : $this->route('user');

        return [
            'name' => 'required|string|max:100',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:'.implode(',', [User::ROLE_ADMIN, User::ROLE_BKK, User::ROLE_HUMAS, User::ROLE_SPMB, User::ROLE_BLUD]),
        ];
    }
}
