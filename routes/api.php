<?php

use App\Models\Customer;
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
