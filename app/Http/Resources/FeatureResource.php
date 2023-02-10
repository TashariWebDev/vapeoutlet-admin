<?php

namespace App\Http\Resources;

use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Feature */
class FeatureResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,

            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
