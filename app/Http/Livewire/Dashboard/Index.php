<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public $showModal = false;

    public function getTotalOrdersProperty()
    {
        return Order::query()
            ->without('items')
            ->where(
                'sales_channel_id',
                auth()
                    ->user()
                    ->defaultSalesChannel()->id
            )
            ->selectRaw(
                "count(case when status = 'received' then 1 end) as received"
            )
            ->selectRaw(
                "count(case when status = 'processed' then 1 end) as processed"
            )
            ->selectRaw(
                "count(case when status = 'packed' then 1 end) as packed"
            )
            ->selectRaw(
                "count(case when status = 'shipped' then 1 end) as shipped"
            )
            ->selectRaw(
                "count(case when status = 'completed' then 1 end) as completed"
            )
            ->selectRaw(
                "count(case when status = 'cancelled' then 1 end) as cancelled"
            );
    }

    public function getTopSellersProperty()
    {
        $products = Product::query()
            ->select(['id', 'name', 'brand', 'sku'])
            ->withSum(
                [
                    'stocks as sold' => function ($query) {
                        $query
                            ->where('type', 'invoice')
                            ->whereMonth('created_at', '=', date('m'))
                            ->whereYear('created_at', '=', date('Y'));
                    },
                    'stocks as available',
                ],
                'qty'
            )
            ->orderBy('sold')
            ->get();

        return $products
            ->filter(function ($product) {
                return $product->sold < 0;
            })
            ->take(10)
            ->load(['features:id,product_id,name']);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.dashboard.index', [
            'lifetime_orders' => $this->totalOrders->first(),
            'orders' => $this->totalOrders
                ->whereMonth('created_at', date('m'))
                ->first(),
            'pendingPurchases' => Purchase::query()
                ->whereNull('processed_date')
                ->count(),
            'wholesaleApplications' => Customer::query()
                ->whereNot('is_wholesale', true)
                ->where('requested_wholesale_account', true)
                ->count(),
            'topTenProducts' => $this->topSellers,
        ]);
    }
}
