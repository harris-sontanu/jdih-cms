<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
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
            'title'         => 'required|max:767',
            'slug'          => 'unique:legislations',
            'author'        => 'required',
            'source'        => 'required',
            'category_id'   => 'required',
            'place'         => 'required',
            'year'          => 'required|numeric',
            'subject'       => 'required',
            'field_id'      => 'required',
            'language'      => 'nullable',
            'location'      => 'nullable',
            'published_at'  => 'nullable',
            'note'          => 'nullable|string',
            'cover'         => 'nullable|image|max:2048',
            'attachment'    => 'nullable|file|mimes:pdf|max:2048',
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['slug'] = [Rule::unique('legislations')->ignore($this->route('article'))];

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
            'category_id'   => 'Jenis Artikel',
            'title'         => 'Judul',
            'slug'          => 'Judul',
            'year'          => 'Tahun Terbit',
            'place'         => 'Tempat Terbit',
            'desc'          => 'Deskripsi Fisik',
            'field_id'      => 'Bidang Hukum',
            'source'        => 'Sumber',
            'language'      => 'Bahasa',
            'location'      => 'Lokasi',
            'author'        => 'T.E.U. Orang/Badan',
            'subject'       => 'Subjek',
            'note'          => 'Catatan',
            'published_at'  => 'Tgl. Terbit',
            'cover'         => 'Sampul',
            'attachment'    => 'Lampiran',
        ];
    }
}
