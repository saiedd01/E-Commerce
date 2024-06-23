<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Product_id' => $this->id,
            'Name' => $this->name,
            'Description' => $this->desc,
            'Price' => $this->price,
            'Discount' => $this->Discount,
            'Quantity' => $this->quantity,
            'Image' => asset("storage")."/".$this->image,
            "qr_code" => asset("storage")."/".$this->qr_code,
        ];
    }
}
