<?php

use App\Http\Livewire\Banners\Index as BannersIndex;
use App\Http\Livewire\Brands\Index as BrandsIndex;
use App\Http\Livewire\Categories\Index as CategoriesIndex;
use App\Http\Livewire\Credit\Create;
use App\Http\Livewire\Customers\Edit;
use App\Http\Livewire\Customers\Index as CustomersIndex;
use App\Http\Livewire\Customers\Show as CustomersShow;
use App\Http\Livewire\Dashboard\Index;
use App\Http\Livewire\Delivery\Index as DeliveryIndex;
use App\Http\Livewire\Expenses\Index as ExpensesIndex;
use App\Http\Livewire\Notifications\Index as NotificationsIndex;
use App\Http\Livewire\Orders\CashUp as OrdersCashUp;
use App\Http\Livewire\Orders\Create as OrdersCreate;
use App\Http\Livewire\Orders\Index as OrdersIndex;
use App\Http\Livewire\Orders\Show as OrdersShow;
use App\Http\Livewire\Products\Edit as ProductsEdit;
use App\Http\Livewire\Products\Index as ProductsIndex;
use App\Http\Livewire\Products\Tracking;
use App\Http\Livewire\Profile\Index as ProfileIndex;
use App\Http\Livewire\Purchases\Edit as PurchasesEdit;
use App\Http\Livewire\Purchases\Pending;
use App\Http\Livewire\Reports\Index as ReportsIndex;
use App\Http\Livewire\SalesChannels\Index as SalesChannelsIndex;
use App\Http\Livewire\Settings\Index as SettingsIndex;
use App\Http\Livewire\StockTakes\Index as StockTakesIndex;
use App\Http\Livewire\StockTakes\Show as StockTakesShow;
use App\Http\Livewire\StockTransfers\Edit as StockTransfersEdit;
use App\Http\Livewire\StockTransfers\Index as StockTransfersIndex;
use App\Http\Livewire\SupplierCredits\Create as SupplierCreditsCreate;
use App\Http\Livewire\SupplierCredits\Show as SupplierCreditsShow;
use App\Http\Livewire\Suppliers\Edit as SuppliersEdit;
use App\Http\Livewire\Suppliers\Index as SuppliersIndex;
use App\Http\Livewire\Suppliers\Show as SuppliersShow;
use App\Http\Livewire\Transactions\Edit as TransactionsEdit;
use App\Http\Livewire\Users\Index as UsersIndex;
use App\Http\Livewire\Users\Show;
use App\Http\Livewire\Warehouse\Index as WarehouseIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', Index::class)->name('dashboard');

    Route::get('orders', OrdersIndex::class)
        ->name('orders')
        ->middleware('permission:view orders');

    Route::get('orders/{id}', OrdersShow::class)
        ->name('orders/show')
        ->middleware('permission:view orders');

    Route::get('orders/create/{id}', OrdersCreate::class)
        ->name('orders/create')
        ->middleware('permission:create orders');

    Route::get('cash-up', OrdersCashUp::class)
        ->name('cash-up')
        ->middleware('permission:complete orders');

    Route::get('products', ProductsIndex::class)
        ->name('products')
        ->middleware('permission:view products');

    Route::get('products/{id}', ProductsEdit::class)
        ->name('products/edit')
        ->middleware('permission:view products');

    Route::get('products/tracking/{id}', Tracking::class)
        ->name('products/tracking')
        ->middleware('permission:view products');

    Route::get('customers', CustomersIndex::class)
        ->name('customers')
        ->middleware('permission:view customers');

    Route::get('customers/show/{id}', CustomersShow::class)
        ->name('customers/show')
        ->middleware('permission:edit customers');

    Route::get('customers/edit/{id}', Edit::class)
        ->name('customers/edit')
        ->middleware('permission:edit customers');

    Route::get('credits/{id}', Create::class)
        ->name('credits/create')
        ->middleware('permission:create credit');

    Route::get('transactions/edit/{id}', TransactionsEdit::class)
        ->name('transactions/edit')
        ->middleware('permission:edit transactions');

    //Settings
    Route::middleware('permission:view settings')->group(function () {
        Route::get('delivery', DeliveryIndex::class)->name('delivery');

        Route::get('notifications', NotificationsIndex::class)->name(
            'notifications'
        );

        Route::get('banners', BannersIndex::class)->name('banners');

        Route::get('categories', CategoriesIndex::class)->name('categories');

        Route::get('brands', BrandsIndex::class)->name('brands');

        Route::get('settings', SettingsIndex::class)->name('settings');
    });

    Route::get('reports', ReportsIndex::class)
        ->name('reports')
        ->middleware('permission:view reports');

    Route::get('stock-takes', StockTakesIndex::class)
        ->name('stock-takes')
        ->middleware('permission:view reports');

    Route::get('stock-takes/{id}', StockTakesShow::class)
        ->name('stock-takes/show')
        ->middleware('permission:view reports');

    Route::get('expenses', ExpensesIndex::class)
        ->name('expenses')
        ->middleware('permission:view expenses');

    Route::get('profile', ProfileIndex::class)->name('profile');

    Route::get('users', UsersIndex::class)
        ->name('users')
        ->middleware('permission:view users');

    Route::get('users/show/{id}', Show::class)
        ->name('users/show')
        ->middleware('permission:view users');

    Route::get('purchases/pending', Pending::class)
        ->name('purchases/pending')
        ->middleware('permission:create purchase');

    Route::get('purchases/{id}', PurchasesEdit::class)
        ->name('purchases/edit')
        ->middleware('permission:create purchase');

    Route::get('supplier-credits/{id}', SupplierCreditsCreate::class)
        ->name('supplier-credits/create')
        ->middleware('permission:create purchase');

    Route::get('supplier-credits/show/{id}', SupplierCreditsShow::class)
        ->name('supplier-credits/show')
        ->middleware('permission:create purchase');

    Route::middleware('permission:view suppliers')->group(function () {
        Route::get('suppliers', SuppliersIndex::class)->name('suppliers');

        Route::get('suppliers/{id}', SuppliersShow::class)->name(
            'suppliers/show'
        );

        Route::get('suppliers/edit/{id}', SuppliersEdit::class)->name(
            'suppliers/edit'
        );
    });

    Route::get('warehouse', WarehouseIndex::class)
        ->name('warehouse')
        ->middleware('permission:view warehouse');

    Route::get('sales-channels', SalesChannelsIndex::class)
        ->name('sales-channels')
        ->middleware('permission:edit sales channels');

    Route::get('stock-transfers', StockTransfersIndex::class)
        ->name('stock-transfers')
        ->middleware('permission:transfer stock');

    Route::get('stock-transfers/edit/{id}', StockTransfersEdit::class)
        ->name('stock-transfers/edit')
        ->middleware('permission:transfer stock');

    Route::get('dashboard', Index::class)->name('dashboard');
});

Route::get('/imitate/{id}', function () {
    Auth::loginUsingId(request('id'));

    return redirect('/dashboard');
})
    ->name('imitate')
    ->middleware('auth');

require __DIR__.'/auth.php';
