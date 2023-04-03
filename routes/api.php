<?php

/** @noinspection PhpUnusedLocalVariableInspection */

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetLinkController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Products\GetLatestProductsCollectionController;
use App\Http\Controllers\Api\V1\Products\GetProductCollectionController;
use App\Http\Controllers\Api\V1\Products\GetProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
 * Api V1
 *
 */

Route::middleware('auth:sanctum')->get('/v1/user', function (Request $request) {
    return $request->user();
});

Route::post('/v1/login', [LoginController::class, 'store']);
Route::post('/v1/register', [RegisterController::class, 'store']);
Route::post('/v1/password-reset-link', [
    PasswordResetLinkController::class,
    'store',
]);
Route::post('/v1/password-reset', [PasswordResetController::class, 'store']);
Route::middleware('auth:sanctum')->post('/v1/logout', [
    LoginController::class,
    'destroy',
]);

Route::get('/v1/get-product/{id}', [GetProductController::class, 'index']);
Route::get('/v1/get-products', [
    GetProductCollectionController::class,
    'index',
]);
Route::get('/v1/get-latest-products', [
    GetLatestProductsCollectionController::class,
    'index',
]);

Route::get('/reset-product-cost', function () {
    $products = Product::withTrashed()->get();

    foreach ($products as $product) {
        $product->update([
            'cost' => 0,
        ]);
    }
});
