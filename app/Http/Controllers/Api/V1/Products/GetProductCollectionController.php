<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Models\Product;

class GetProductCollectionController extends Controller
{
    public function index()
    {
        $products = Product::query()->where('is_active', true)->paginate();

        return new ProductCollection($products);
    }
}
