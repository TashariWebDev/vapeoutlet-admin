<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Hook Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Web Hook routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("/save-document/{transaction}", [
    DocumentController::class,
    "saveDocument",
]);

Route::get("/price-list/{customer}", [
    DocumentController::class,
    "getPriceList",
]);
Route::get("/pick-lists/{order}", [DocumentController::class, "getPickList"]);

Route::get("/delivery-note/{order}", [
    DocumentController::class,
    "getDeliveryNote",
]);
Route::get("/stock-takes/{stockTake}", [
    DocumentController::class,
    "getStockTake",
]);

Route::get("/stock-counts/{stockTake}", [
    DocumentController::class,
    "getStockCount",
]);

Route::get("/documents/debtor-list", [
    DocumentController::class,
    "getDebtorsList",
]);

Route::get("/documents/creditors-list", [
    DocumentController::class,
    "getCreditorsList",
]);

Route::get("/documents/expenses", [
    DocumentController::class,
    "getExpensesList",
]);
