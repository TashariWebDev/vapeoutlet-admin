<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use App\Models\Stock;

class GetLatestProductsCollectionController extends Controller
{
    public function index()
    {
        $latestProducts = Stock::query()
            ->with('product.features')
            ->where('type', 'purchase')
            ->withWhereHas('product', function ($query) {
                $query->where('is_active', true);
            })
            ->latest()
            ->simplePaginate(6, '*', 'latest');

        return response()->json($latestProducts);
    }
}
