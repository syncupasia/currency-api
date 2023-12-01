<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
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
            'iso_code' => $this->iso_code,
            'name' => $this->name,
            'current_rate' => $this->current_rate,
            'previous_rate' => $this->previous_rate,
            'base_currency' => $this->base_currency,
            'last_modified' => $this->updated_at
        ];
    }
}
