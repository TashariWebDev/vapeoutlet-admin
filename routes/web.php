<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $products = Product::all();
    return view('welcome', [
        'products' => $products,
    ]);
});

Route::get('/update-prices', function () {
//    $products = Product::all();
//
//    foreach ($products as $product) {
//        $product->update([
//            'retail_price' => $product->retail_price / 100,
//            'wholesale_price' => $product->wholesale_price / 100,
//            'cost' => $product->cost / 100,
//        ]);
//    }
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
