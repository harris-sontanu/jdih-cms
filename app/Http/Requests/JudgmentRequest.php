<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class JudgmentRequest extends FormRequest
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
            'title'         => 'required|max:767',
            'slug'          => 'unique:legislations',
            'code_number'   => 'required',
            'number'        => 'required',
            'author'        => 'required',
            'source'        => 'required',
            'category_id'   => 'required',
            'place'         => 'required',
            'year'          => 'required',
            'published'     => 'required|date_format:d-m-Y',
            'subject'       => 'required',
            'status'        => 'required',
            'field_id'      => 'required',
            'language'      => 'nullable',
            'justice'       => 'nullable',
            'published_at'  => 'nullable',
            'note'          => 'nullable|string',
            'master'        => 'nullable|file|mimes:pdf|max:2048',
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['slug'] = Rule::unique('legislations')->ignore($this->route('judgment'));

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
            'category_id'   => 'Jenis Putusan',
            'title'         => 'Judul',
            'slug'          => 'Judul',
            'code_number'   => 'Nomor Putusan',
            'number'        => 'Nomor Urut Putusan',
            'justice'       => 'Jenis Peradilan',
            'year'          => 'Tahun Terbit',
            'published'     => 'Tgl. Dibacakan',
            'place'         => 'Tempat Peradilan',
            'source'        => 'Sumber',
            'status'        => 'Status',
            'field_id'      => 'Bidang Hukum',
            'language'      => 'Bahasa',
            'author'        => 'T.E.U. Badan',
            'subject'       => 'Subjek',
            'note'          => 'Catatan',
            'published_at'  => 'Tgl. Terbit',
            'master'        => 'Lampiran',
        ];
    }
}
