<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Order;
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
        ]);
    }
}
