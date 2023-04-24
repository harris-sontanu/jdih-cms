<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class PageRequest extends FormRequest
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
            'taxonomy_id' => 'required',
            'title'     => 'required|max:255',
            'slug'      => 'unique:posts',
            'body'      => 'required',
            'excerpt'   => 'nullable',
            'author_id' => 'nullable',
            'cover'     => 'nullable|image|dimensions:min_width=400|max:2048'
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['slug'] = Rule::unique('posts')->ignore($this->route('page'));
                $rules = Arr::except($rules, ['taxonomy_id']);
                break;
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
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
    public function attributes(): array
    {
        return [
            'title'         => 'Judul',
            'slug'          => 'Judul',
            'body'          => 'Isi',
            'excerpt'       => 'Cuplikan',
            'author_id'     => 'Penulis',
            'cover'         => 'Sampul',
        ];
    }
}
