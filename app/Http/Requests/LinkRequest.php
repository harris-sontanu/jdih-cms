<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class LinkRequest extends FormRequest
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
            'type'  => 'required',
            'image' => 'required|image|max:2048',
            'title' => 'required',
            'url'   => 'required|url',
            'desc'  => 'nullable',
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['image'] = 'image|max:2048';
                break;
        }

        if (request()->type === 'youtube') {
            $rules = Arr::except($rules, ['image']);
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
            'title' => 'Judul',
            'desc'  => 'Keterangan',
            'url'   => 'URL',
            'image' => 'Gambar',
            'type'  => 'Jenis',
        ];
    }
}
