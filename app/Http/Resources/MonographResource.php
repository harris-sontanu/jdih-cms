<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MonographResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'idData'    => $this->id,
            'judul'     => $this->title,
            'jenis'     => $this->category_name,
            'singkatanJenis'    => $this->category_abbrev,
        ];
    }
}
