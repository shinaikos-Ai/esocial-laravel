<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'name'     => ['required', 'string', 'min:3', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'nr_insc'  => ['nullable', 'string', 'regex:/^\d{8,14}$/'],
            'role'     => ['nullable', 'in:admin,operador'],
        ];
    }

    public function messages(): array
    {
        return [
            'nr_insc.regex' => 'O número de inscrição deve conter entre 8 e 14 dígitos numéricos.',
        ];
    }
}
