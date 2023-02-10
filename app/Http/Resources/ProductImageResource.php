<?php

namespace App\Http\Resources;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Image */
class ProductImageResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'url' => asset($this->url),
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
