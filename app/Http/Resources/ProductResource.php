<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Product */
class ProductResource extends JsonResource
{
    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'brand' => $this->brand,
            'category' => $this->category,
            'image' => asset($this->image),
            'sku' => $this->sku,
            'description' => $this->description,
            'retail_price' => $this->retail_price,
            'old_retail_price' => $this->old_retail_price,
            'wholesale_price' => $this->wholesale_price,
            'old_wholesale_price' => $this->old_wholesale_price,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'is_sale' => $this->is_sale,
            'oldwholesale_price' => $this->oldwholesale_price,
            'qty' => $this->qtyAvailableInWarehouse(),
            'product_collection_id' => $this->product_collection_id,
            'features' => FeatureResource::collection($this->features),
            'images' => ProductImageResource::collection($this->images),
        ];
    }
}
