<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'category' => $this->category,
            'price' => $this->getDiscountedPrice()
        ];
    }
}
