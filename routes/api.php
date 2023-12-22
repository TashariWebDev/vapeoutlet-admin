<?php

/** @noinspection PhpUnusedLocalVariableInspection */

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetLinkController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Products\GetLatestProductsCollectionController;
use App\Http\Controllers\Api\V1\Products\GetProductCollectionController;
use App\Http\Controllers\Api\V1\Products\GetProductController;
use App\Mail\OrderConfirmedMail;
use App\Mail\OrderReceivedMail;
use App\Mail\OrderRecoveryMail;
use App\Mail\PaymentReceiptMail;
use App\Mail\PaymentReceivedMail;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use Carbon\Carbon;
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

Route::post('send-order-emails', function (Request $request) {
    Log::info('hit send order emails');

    $order = Order::find($request->orderId);

    Mail::to($order->customer->email)->send(
        (new OrderConfirmedMail($order->customer))
    );

    Mail::to(config('mail.from.address'))->send(
        (new OrderReceivedMail($order->customer, $order))
    );

    return response('Success', 200)
        ->header('Content-Type', 'text/plain');

});

Route::post('send-payment-emails', function (Request $request) {
    Log::info('hit send payment emails');

    $order = Order::find($request->orderId);
    $transaction = Transaction::find($request->transactionId);

    Mail::to(config('mail.from.address'))->send(
        new PaymentReceivedMail(
            $order, $transaction, $order->createdBy
        )
    );

    Mail::to($order->customer)->send(
        new PaymentReceiptMail(
            $order, $transaction, $order->createdBy
        )
    );

    return response('Success', 200)
        ->header('Content-Type', 'text/plain');

});

Route::post('send-recovery-emails', function (Request $request) {

    $abandonedOrders = Order::whereNull('status')
        ->whereDate('created_at', '=', today())
        ->get();

    foreach ($abandonedOrders as $order) {
        Mail::to($order->customer->email)->send(
            new OrderRecoveryMail($order)
        );
    }

    return response('Success', 200)
        ->header('Content-Type', 'text/plain');

});

Route::post('send-seven-day-recovery-emails', function (Request $request) {

    $abandonedOrders = Order::whereNull('status')
        ->where('created_at', '<=',
            Carbon::now()->subDays(7)->toDateTimeString())
        ->withCount('items')
        ->having('items_count', '>', 0)
        ->inRandomOrder()
        ->take(5)
        ->get();

    foreach ($abandonedOrders as $order) {
        Mail::to($order->customer->email)->send(
            new OrderRecoveryMail($order)
        );
    }

    return response('Success', 200)
        ->header('Content-Type', 'text/plain');

});

Route::get('product-by-volume', function () {
    return Stock::query()
        ->with('product')
        ->where('type', '=', 'invoice')
        ->whereMonth('created_at', '=', today()->month)
        ->whereYear('created_at', '=', today()->year)
        ->get()
        ->groupBy('product_id')
        ->map(function ($item) {
            return [
                'brand' => $item->first()->product->brand,
                'product' => $item->first()->product->name.' '.$item->first()->product->category,
                'volume' => 0 - $item->sum('qty'),
            ];
        })
        ->groupBy('brand')
        ->sortByDesc('volume');
});
