<?php

namespace App\Http\Requests;

use App\Enums\LawRelationshipStatus;
use App\Enums\LegislationRelationshipType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class LawRelationshipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type'  => [
                'required',
                new Enum(LegislationRelationshipType::class)
            ],
            'statusOptions' => [
                'exclude_if:type,document',
                'required',
                new Enum(LawRelationshipStatus::class),
            ],
            'statusRelatedTo' => 'required',
            'statusNote'      => 'nullable',
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
            'type'  => 'Tipe relasi',
            'statusOptions' => 'Pilihan status',
            'statusRelatedTo'   => 'Peraturan terkait',
            'statusNote'    => 'Catatan status',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'statusOptions.required_unless' => 'Pilihan status wajib diisi',
        ];
    }
}
