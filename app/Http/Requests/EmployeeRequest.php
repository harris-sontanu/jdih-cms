<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
        return [
            'name'      => 'required|max:255',
            'position'  => 'required',
            'email'     => 'nullable|email',
            'picture'   => 'nullable|image|max:2048',
            'groups'    => 'required|array',
        ];
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
            'position'      => 'Jabatan',
            'email'         => 'Email',
            'picture'       => 'Foto',
            'groups'        => 'Grup',
        ];
    }
}
