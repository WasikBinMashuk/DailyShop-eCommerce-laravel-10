<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'Cart No.' => $this->id,
            'Customer ID' => $this->customer_id,
            'Customer Name' => $this->customer->name,
            'Product Name' => $this->product->product_name,
            'Quantity' => $this->quantity,
            'Price' => $this->price,
            'Total price' => $this->total_price,
        ];
    }
}
