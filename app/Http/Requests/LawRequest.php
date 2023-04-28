<?php

namespace App\Http\Requests;

use App\Enums\LegislationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class LawRequest extends FormRequest
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
            'title'       => 'required|max:767',
            'slug'        => 'unique:legislations',
            'author'      => 'nullable',
            'code_number' => 'required',
            'number'      => 'required|numeric',
            'category_id' => 'required',
            'place'       => 'nullable',
            'approved'    => 'required|date_format:d-m-Y',
            'published'   => 'required|date_format:d-m-Y',
            'year'        => 'required|numeric',
            'source'      => 'nullable',
            'subject'     => 'nullable',
            'status'      => ['required', new Enum(LegislationStatus::class)],
            'institute_id'=> 'nullable',
            'field_id'    => 'nullable',
            'signer'      => 'nullable',
            'language'    => 'nullable',
            'location'    => 'nullable',
            'published_at'=> 'nullable',
            'note'        => 'nullable|string',
            'master'      => 'nullable|file|mimes:pdf|max:20000',
            'abstract'    => 'nullable|file|mimes:pdf|max:20000',
            'attachment'  => 'nullable|array',
            'attachment.*'  => 'sometimes|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,rtf,txt|max:20000'
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['slug'] = Rule::unique('legislations')->ignore($this->route('law'));

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
            'category_id'   => 'Jenis Peraturan',
            'title'         => 'Judul',
            'slug'          => 'Judul',
            'code_number'   => 'Nomor Peraturan',
            'number'        => 'Nomor Urut Peraturan',
            'year'          => 'Tahun Terbit',
            'approved'      => 'Tgl. Penetapan',
            'published'     => 'Tgl. Pengundangan',
            'author'        => 'T.E.U. Badan',
            'source'        => 'Sumber',
            'place'         => 'Tempat Terbit',
            'status'        => 'Status',
            'field_id'      => 'Bidang Hukum',
            'subject'       => 'Subjek',
            'language'      => 'Bahasa',
            'location'      => 'Lokasi',
            'matter'        => 'Urusan Pemerintahan',
            'signer'        => 'Penandatangan',
            'institute_id'  => 'Pemrakarsa',
            'note'          => 'Catatan',
            'published_at'  => 'Tgl. Terbit',
            'master'        => 'Batang Tubuh',
            'abstract'      => 'Abstrak',
            'attachment'    => 'Lampiran',
        ];
    }
}
