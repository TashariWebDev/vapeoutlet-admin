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

Route::get('/save-document/{transaction}', [DocumentController::class, 'saveDocument']);
Route::get('/price-list/{customer}', [DocumentController::class, 'getPriceList']);
Route::get('/pick-lists/{order}', [DocumentController::class, 'getPickList']);
Route::get('/delivery-note/{order}', [DocumentController::class, 'getDeliveryNote']);
