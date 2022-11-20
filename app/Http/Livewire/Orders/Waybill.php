<?php

namespace App\Http\Livewire\Orders;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Waybill extends Component
{
    use WithNotifications;

    public $modal;

    public $waybill;

    public Order $order;

    public function save()
    {
        $this->order->update([
            'waybill' => $this->waybill,
        ]);

        $this->modal = false;

        $this->notify('waybill added');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.orders.waybill');
    }
}
