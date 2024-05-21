<?php

namespace App\Http\Resources\Api\Frontend;

use App\Http\Resources\Api\Frontend\Users\DiscountPriceResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'p_id' => $this->p_id ?? null,
            'name' => $this->name ?? null,
            'sale_price' => $this->sale_price ?? null,
            'slug' => $this->slug ?? null,
            'sku' => $this->sku ?? null,
            'image' => asset(Storage::url('products/' . $this->image)) ?? null,
            'discount' => $this->discount ?? null,
            'type' => $this->type ?? null,
            'status' => $this->status ?? null,
            'created_at' => $this->created_at ?? null,
            'expire_date' => $this->expire_date ?? null,
        ];
    }

}
