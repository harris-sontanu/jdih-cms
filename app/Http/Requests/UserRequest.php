<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Enum;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'name'  => 'required|string',
            'username'  => 'required|string|min:6',
            'picture'   => 'nullable|image|max:2048',
            'email' => 'required|email|unique:users',
            'password'  => 'required|string|min:6|confirmed',
            'role'  => ['required', new Enum(UserRole::class)],
            'phone' => 'nullable',
            'www'   => 'nullable|url',
            'bio'   => 'nullable',
            'facebook'  => 'nullable|url',
            'twitter'   => 'nullable|url',
            'instagram' => 'nullable|url',
            'tiktok'    => 'nullable|url',
            'youtube'   => 'nullable|url',
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['email'] = [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($this->route('user'))
                ];
                $rules = Arr::except($rules, ['password']);
                break;
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name'          => 'Nama',
            'username'      => 'Nama Akun',
            'picture'       => 'Foto',
            'email'         => 'Email',
            'password'      => 'Kata Sandi',
            'role'          => 'Level',
            'phone'         => 'Telepon',
            'www'           => 'Website',
            'bio'           => 'Biografi',
        ];
    }
}
