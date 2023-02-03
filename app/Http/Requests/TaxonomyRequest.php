<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TaxonomyRequest extends FormRequest
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
            'type'      => 'required',
            'name'      => 'required|max:255',
            'desc'      => 'nullable',
        ];

        switch ($this->method()) {
            case 'POST':
                $rules['slug'] = Rule::unique('taxonomies')->where(fn ($query) => $query->where('type', request()->type));

                break;
            case 'PUT':
            case 'PATCH':
                $rules['slug'] = Rule::unique('taxonomies')->where(fn ($query) => $query->where('type', request()->type))->ignore($this->route('taxonomy'));
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
            'name'          => 'Nama',
            'slug'          => 'Nama',
            'desc'          => 'Deskripsi',
        ];
    }
}
