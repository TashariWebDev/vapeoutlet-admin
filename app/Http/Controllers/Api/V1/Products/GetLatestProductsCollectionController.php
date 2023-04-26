<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use App\Models\Stock;

class GetLatestProductsCollectionController extends Controller
{
    public function index()
    {
        $stocks = Stock::where('type', 'purchase')
            ->latest()
            ->limit(18)
            ->get()
            ->unique('product_id');

        $idCollection = $stocks->pluck('product_id')->toArray();

        $latestProducts = Product::query()
            ->whereIn('id', $idCollection)
            ->with(['features', 'stocks'])
            ->latest()
            ->simplePaginate(6, '*', 'latest');

        return new ProductCollection($latestProducts);
    }
}
