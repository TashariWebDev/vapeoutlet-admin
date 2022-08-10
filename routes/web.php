<?php

use App\Http\Livewire\Customers\Edit;
use App\Http\Livewire\Dashboard\Index;
use App\Http\Livewire\Purchases\Create;
use App\Http\Livewire\Settings\Delivery;
use App\Http\Livewire\Settings\Marketing\Banners;
use App\Http\Livewire\Settings\Marketing\Notifications;
use App\Http\Livewire\Users\Show;
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
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', Index::class)
        ->name('dashboard');

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

    //Settings
    Route::middleware('permission:view settings')->group(function () {
        Route::get('settings/delivery', Delivery\Index::class)
            ->name('settings/delivery');

        Route::get('settings/marketing/notifications', Notifications::class)
            ->name('settings/marketing/notifications');

        Route::get('settings/marketing/banners', Banners::class)
            ->name('settings/marketing/banners');

        Route::get('settings', \App\Http\Livewire\Settings\Index::class)
            ->name('settings');
    });

    Route::get('reports', \App\Http\Livewire\Reports\Index::class)
        ->name('reports')
        ->middleware('permission:view reports');

    Route::get('expenses', \App\Http\Livewire\Expenses\Index::class)
        ->name('expenses')
        ->middleware('permission:view expenses');

    Route::get('profile', \App\Http\Livewire\Profile\Index::class)
        ->name('profile');

    Route::get('users', \App\Http\Livewire\Users\Index::class)
        ->name('users')
        ->middleware('permission:view users');

    Route::get('users/show/{id}', Show::class)
        ->name('users/show')
        ->middleware('permission:view users');

    Route::get('inventory/purchases/{id}', Create::class)
        ->name('purchases/create')
        ->middleware('permission:create purchase');

    Route::middleware('permission:view suppliers')->group(function () {
        Route::get('inventory/suppliers', \App\Http\Livewire\Suppliers\Index::class)
            ->name('suppliers');

        Route::get('inventory/suppliers/{id}', \App\Http\Livewire\Suppliers\Show::class)
            ->name('suppliers/show');
    });

    Route::get('warehouse', \App\Http\Livewire\Warehouse\Index::class)
        ->name('warehouse')
        ->middleware('permission:view warehouse');

    Route::get('dispatch', \App\Http\Livewire\Dispatch\Index::class)
        ->name('dispatch')
        ->middleware('permission:view dispatch');
});

require __DIR__.'/auth.php';
