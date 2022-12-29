<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierPurchaseMedicinesResource extends JsonResource
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
            'id' => $this->id,
            'price_per_unit' => $this->price_per_unit,
            'total_units' => $this->total_units,
            'expiry' => $this->expiry,
            'medicien' => new MedicineResource($this->medicine),
        ];
    }
}
