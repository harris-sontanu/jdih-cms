<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoryRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'type_id'   => 'required',
            'name'      => 'required|max:255',
            'slug'      => 'unique:categories',
            'abbrev'    => 'nullable|unique:categories',
            'code'      => 'nullable',
            'desc'      => 'nullable',
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['slug'] = [Rule::unique('categories')->ignore($this->route('category'))];

                $rules['abbrev'] = [
                    'nullable',
                    Rule::unique('categories')->ignore($this->route('category'))
                ];
                break;
        }

        return $rules;
    }


    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->name),
        ]);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'type_id'   => 'Tipe',
            'name'      => 'Nama',
            'slug'      => 'Nama',
            'abbrev'    => 'Singkatan',
            'code'      => 'Kode',
            'desc'      => 'Deskripsi'
        ];
    }
}
