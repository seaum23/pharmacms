<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicineSaleResource extends JsonResource
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
            'total' => $this->total,
            'total_paid' => $this->total_paid,
            'purchase_date' => $this->created_at,
            'discount' => $this->discount,
            'seller' => new UserResource($this->seller),
            'customer' => new CustomerResource($this->customer),
            'saleDetails' => MedicineSaleDetailsResource::collection($this->whenLoaded('saleDetails')),            
        ];
    }
}
