<?php

namespace App\Http\Resources;

use App\Http\Resources\SupplierResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierPurchaseHistoryResource extends JsonResource
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
            'batch_id' => $this->batch_id,
            'total_price' => $this->total_price,
            'paid_price' => $this->paid_price,
            'cleared' => $this->cleared,
            'supplier' => new SupplierResource($this->supplier),
            'medicines' => SupplierPurchaseMedicinesResource::collection($this->whenLoaded('medicines')),
        ];
    }
}
