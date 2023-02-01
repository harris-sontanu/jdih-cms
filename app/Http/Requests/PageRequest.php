<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
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
            'title'     => 'required|max:255',
            'slug'      => 'unique:posts',
            'body'      => 'required',
            'excerpt'   => 'nullable',
            'cover'     => 'image|dimensions:min_width=400|max:2048'
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['slug'] = Rule::unique('posts')->ignore($this->route('page'));

                $rules['cover'] = 'image|dimensions:min_width=400|max:2048';
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
            'slug' => Str::slug($this->title),
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
            'title'         => 'Judul',
            'slug'          => 'Judul',
            'body'          => 'Isi',
            'excerpt'       => 'Cuplikan',
            'cover'         => 'Sampul',
        ];
    }
}
