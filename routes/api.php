<?php

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});

Route::get("/sales", function () {
    $customers = Customer::withWhereHas("monthlySales", function ($query) {
        $query->whereMonth("created_at", "=", date(9));
    })
        ->select(["customers.id", "customers.name", "customers.salesperson_id"])
        ->with("salesperson:id,name")
        ->get()
        ->groupBy("salesperson.name");
    return response()->json(["customers" => $customers]);
});

Route::get("/poduct-stock-counts", function () {
    $products = Product::where("is_active", "=", true)
        ->select(["id", "name", "sku"])
        ->withSum("stocks", "qty")
        ->orderBy("stocks_sum_qty")
        ->get();
    return response()->json(["products" => $products]);
});

Route::get("/get-duplicates", function () {
    $duplicates = [];
    $orders = Order::with("items")
        ->whereStatus("processed")
        ->get();

    foreach ($orders as $order) {
        if ($order->items()->count() != $order->stocks->count()) {
            $duplicates[] = $order;
        }
    }

    //    foreach ($duplicates as $duplicate) {
    //        $duplicate->stocks()->delete();
    //        $duplicate->decreaseStock();
    //    }
    //
    //    foreach ($orders as $order) {
    //        if ($order->items()->count() != $order->stocks->count()) {
    //            $duplicates[] = $order;
    //        }
    //    }

    //    $users = User::all();
    //    $usersUnique = $users->unique(['user_name']);
    //    $userDuplicates = $users->diff($usersUnique);
    //    echo "<pre>";
    //    print_r($userDuplicates->toArray());

    return response()->json(["duplicates" => $duplicates]);
});
