<?php

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/sales', function () {
    $customers = Customer::withWhereHas('monthlySales', function ($query) {
        $query->whereMonth('created_at', '=', date(9));
    })
        ->select(['customers.id', 'customers.name', 'customers.salesperson_id'])
        ->with('salesperson:id,name')
        ->get()
        ->groupBy('salesperson.name');

    return response()->json(['customers' => $customers]);
});

Route::get('/poduct-stock-counts', function () {
    $products = Product::where('is_active', '=', true)
        ->select(['id', 'name', 'sku'])
        ->withSum('stocks', 'qty')
        ->orderBy('stocks_sum_qty')
        ->get();

    return response()->json([
        'products' => $products,
    ]);
});

Route::get('/get-duplicates', function () {
    $duplicates = [];
    $orders = Order::with('items')
        ->whereStatus('shipped')
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

    return response()->json(['duplicates' => $duplicates]);
});

Route::get('/get-duplicate-transactions', function () {
    $duplicates = [];
    $transactions = Transaction::where('created_by', '=', 'payflex')->get();

    //    foreach ($transactions as $transaction) {
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
    $transactionsUnique = $transactions->unique(['reference']);
    $transactionsDuplicates = $transactions->diff($transactionsUnique);
    //    echo "<pre>";
    //    print_r($transactionsDuplicates->toArray());

    return response()->json([
        'duplicates' => $transactionsDuplicates->toArray(),
    ]);
});

Route::get('/get-unmatched-transactions', function () {
    $unmatched = [];
    $orders = Order::with('customer.transactions')->get();

    foreach ($orders as $order) {
        $transaction = Transaction::where(
            'reference',
            '=',
            'INV00'.$order->id
        )->first();
        if ($transaction) {
            if ($order->getTotal() != $transaction->amount) {
                $unmatched[] = $transaction;
            }
        }
    }

    return response()->json([
        'unmatched' => $unmatched,
    ]);
});

Route::get('/stocks-by-date', function () {
    $toDate = request('to');

    $products = Product::whereHas('stocks', function ($query) use ($toDate) {
        $query->whereDate('created_at', '<=', Carbon::parse($toDate));
    })
        ->select(['id', 'name', 'cost', 'sku', 'brand'])
        ->withSum(
            [
                'stocks' => function ($query) use ($toDate) {
                    $query->whereDate(
                        'created_at',
                        '<=',
                        Carbon::parse($toDate)
                    );
                },
            ],
            'qty'
        )
        ->take(10)
        ->get();

    return response()->json([
        'products' => $products,
    ]);
});
