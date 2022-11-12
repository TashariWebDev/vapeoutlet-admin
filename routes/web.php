<?php

use App\Http\Livewire\Customers\Edit;
use App\Http\Livewire\Dashboard\Index;
use App\Http\Livewire\Purchases\Create;
use App\Http\Livewire\Users\Show;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', Index::class)->name('dashboard');

    Route::get('orders', \App\Http\Livewire\Orders\Index::class)
        ->name('orders')
        ->middleware('permission:view orders');

    Route::get('orders/{id}', \App\Http\Livewire\Orders\Show::class)
        ->name('orders/show')
        ->middleware('permission:view orders');

    Route::get('orders/create/{id}', \App\Http\Livewire\Orders\Create::class)
        ->name('orders/create')
        ->middleware('permission:create orders');

    Route::get('products', \App\Http\Livewire\Products\Index::class)
        ->name('products')
        ->middleware('permission:view products');

    Route::get('inventory', \App\Http\Livewire\Inventory\Index::class)
        ->name('inventory')
        ->middleware('permission:view inventory');

    Route::get('customers', \App\Http\Livewire\Customers\Index::class)
        ->name('customers')
        ->middleware('permission:view customers');

    Route::get('customers/show/{id}', \App\Http\Livewire\Customers\Show::class)
        ->name('customers/show')
        ->middleware('permission:edit customers');

    Route::get('customers/edit/{id}', Edit::class)
        ->name('customers/edit')
        ->middleware('permission:edit customers');

    Route::get('credits/{id}', \App\Http\Livewire\Credit\Create::class)
        ->name('credits/create')
        ->middleware('permission:create credit');

    Route::get(
        'transactions/edit/{id}',
        \App\Http\Livewire\Transactions\Edit::class
    )
        ->name('transactions/edit')
        ->middleware('permission:edit transactions');

    //Settings
    Route::middleware('permission:view settings')->group(function () {
        Route::get('delivery', \App\Http\Livewire\Delivery\Index::class)->name(
            'delivery'
        );

        Route::get(
            'notifications',
            \App\Http\Livewire\Notifications\Index::class
        )->name('notifications');

        Route::get('banners', \App\Http\Livewire\Banners\Index::class)->name(
            'banners'
        );

        Route::get(
            'categories',
            \App\Http\Livewire\Categories\Index::class
        )->name('categories');

        Route::get('brands', \App\Http\Livewire\Brands\Index::class)->name(
            'brands'
        );

        Route::get('settings', \App\Http\Livewire\Settings\Index::class)->name(
            'settings'
        );
    });

    Route::get('reports', \App\Http\Livewire\Reports\Index::class)
        ->name('reports')
        ->middleware('permission:view reports');

    Route::get('stock-takes', \App\Http\Livewire\StockTakes\Index::class)
        ->name('stock-takes')
        ->middleware('permission:view reports');

    Route::get('stock-takes/{id}', \App\Http\Livewire\StockTakes\Show::class)
        ->name('stock-takes/show')
        ->middleware('permission:view reports');

    Route::get('expenses', \App\Http\Livewire\Expenses\Index::class)
        ->name('expenses')
        ->middleware('permission:view expenses');

    Route::get('profile', \App\Http\Livewire\Profile\Index::class)->name(
        'profile'
    );

    Route::get('users', \App\Http\Livewire\Users\Index::class)
        ->name('users')
        ->middleware('permission:view users');

    Route::get('users/show/{id}', Show::class)
        ->name('users/show')
        ->middleware('permission:view users');

    Route::get('inventory/purchases/{id}', Create::class)
        ->name('purchases/create')
        ->middleware('permission:create purchase');

    Route::get(
        'supplier-credits/{id}',
        \App\Http\Livewire\Returns\Create::class
    )
        ->name('supplier-credits/create')
        ->middleware('permission:create purchase');

    Route::get(
        'supplier-credits/show/{id}',
        \App\Http\Livewire\Returns\Show::class
    )
        ->name('supplier-credits/show')
        ->middleware('permission:create purchase');

    Route::middleware('permission:view suppliers')->group(function () {
        Route::get(
            'inventory/suppliers',
            \App\Http\Livewire\Suppliers\Index::class
        )->name('suppliers');

        Route::get(
            'inventory/suppliers/{id}',
            \App\Http\Livewire\Suppliers\Show::class
        )->name('suppliers/show');

        Route::get(
            'inventory/suppliers/edit/{id}',
            \App\Http\Livewire\Suppliers\Edit::class
        )->name('suppliers/edit');
    });

    Route::get('warehouse', \App\Http\Livewire\Warehouse\Index::class)
        ->name('warehouse')
        ->middleware('permission:view warehouse');

    Route::get('dispatch', \App\Http\Livewire\Dispatch\Index::class)
        ->name('dispatch')
        ->middleware('permission:view dispatch');

    Route::get('dashboard', Index::class)->name('dashboard');
});

Route::get('/imitate/{id}', function () {
    Auth::loginUsingId(request('id'));

    return redirect('/dashboard');
})
    ->middleware('auth')
    ->name('imitate');

require __DIR__.'/auth.php';
