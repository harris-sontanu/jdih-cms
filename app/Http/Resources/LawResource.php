<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LawResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'idData'    => $this->id,
            'judul'     => $this->title,
            'jenis'     => $this->category_name,
            'singkatanJenis'    => $this->category_abbrev,
            'noPeraturan'   => $this->code_number,
            'tahun_pengundangan'    => $this->year,
            'tanggal_pengundangan'  => $this->published,
            'sumber'    => $this->source,
            'subjek'    => $this->subject,
            'status'    => $this->status,
            'bahasa'    => $this->language,
            'teuBadan'  => $this->author,
        ];
    }
}
