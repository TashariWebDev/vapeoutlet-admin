<?php

/** @noinspection PhpUnusedLocalVariableInspection */

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetLinkController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Products\GetLatestProductsCollectionController;
use App\Http\Controllers\Api\V1\Products\GetProductCollectionController;
use App\Http\Controllers\Api\V1\Products\GetProductController;
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

//Route::get('/sales', function () {
//    $customers = Customer::withWhereHas('monthlySales', function ($query) {
//        $query->whereMonth('created_at', '=', date(9));
//    })
//        ->select(['customers.id', 'customers.name', 'customers.salesperson_id'])
//        ->with('salesperson:id,name')
//        ->get()
//        ->groupBy('salesperson.name');
//
//    return response()->json(['customers' => $customers]);
//});
//
//Route::get('/product-stock-counts', function () {
//    $products = Product::where('is_active', '=', true)
//        ->select(['id', 'name', 'sku'])
//        ->withSum('stocks', 'qty')
//        ->orderBy('stocks_sum_qty')
//        ->get();
//
//    return response()->json([
//        'products' => $products,
//    ]);
//});
//
//Route::get('/get-duplicates', function () {
//    $duplicates = [];
//    $orders = Order::with('items')
//        ->whereStatus('shipped')
//        ->get();
//
//    foreach ($orders as $order) {
//        if ($order->items()->count() != $order->stocks->count()) {
//            $duplicates[] = $order;
//        }
//    }

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

//    return response()->json(['duplicates' => $duplicates]);
//});

//Route::get('/get-duplicate-transactions', function () {
//    $duplicates = [];
//    $transactions = Transaction::where('created_by', '=', 'payflex')->get();
//
//    //    foreach ($transactions as $transaction) {
//    //        if ($order->items()->count() != $order->stocks->count()) {
//    //            $duplicates[] = $order;
//    //        }
//    //    }
//
//    //    foreach ($duplicates as $duplicate) {
//    //        $duplicate->stocks()->delete();
//    //        $duplicate->decreaseStock();
//    //    }
//    //
//    //    foreach ($orders as $order) {
//    //        if ($order->items()->count() != $order->stocks->count()) {
//    //            $duplicates[] = $order;
//    //        }
//    //    }
//
//    //    $users = User::all();
//    $transactionsUnique = $transactions->unique(['reference']);
//    $transactionsDuplicates = $transactions->diff($transactionsUnique);
//    //    echo "<pre>";
//    //    print_r($transactionsDuplicates->toArray());
//
//    return response()->json([
//        'duplicates' => $transactionsDuplicates->toArray(),
//    ]);
//});

//Route::get('/get-unmatched-transactions', function () {
//    $unmatched = [];
//    $orders = Order::with('customer.transactions')->get();
//
//    foreach ($orders as $order) {
//        $transaction = Transaction::where(
//            'reference',
//            '=',
//            'INV00'.$order->id
//        )->first();
//        if ($transaction) {
//            if ($order->getTotal() != $transaction->amount) {
//                $unmatched[] = $transaction;
//            }
//        }
//    }
//
//    return response()->json([
//        'unmatched' => $unmatched,
//    ]);
//});

//Route::get('/stocks-by-date', function () {
//    $toDate = request('to');
//
//    $products = Product::whereHas('stocks', function ($query) use ($toDate) {
//        $query->whereDate('created_at', '<=', Carbon::parse($toDate));
//    })
//        ->select(['id', 'name', 'cost', 'sku', 'brand'])
//        ->withSum(
//            [
//                'stocks' => function ($query) use ($toDate) {
//                    $query->whereDate(
//                        'created_at',
//                        '<=',
//                        Carbon::parse($toDate)
//                    );
//                },
//            ],
//            'qty'
//        )
//        ->take(10)
//        ->get();
//
//    return response()->json([
//        'products' => $products,
//    ]);
//});

//Route::get('get-products', function () {
//    $products = Product::with(['features'])
//        ->inStock()
//        ->withStockCount()
//        ->where('is_active', '=', true)
//        ->paginate();
//
//    return response()->json(['data' => $products]);
//});

//Route::get('incomplete-orders', function () {
//    $orders = Order::where('status', '=', null)
//        ->withSum('stocks', 'qty')
//        ->get();
//
//    return $orders;
//});
