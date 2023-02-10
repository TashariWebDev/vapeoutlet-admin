<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class GetProductController extends Controller
{
    public function index(Request $request)
    {
        $product = new ProductResource(Product::find($request->id));

        return response()->json($product);
    }
}
