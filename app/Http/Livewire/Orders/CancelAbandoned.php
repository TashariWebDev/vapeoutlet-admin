<?php

namespace App\Http\Livewire\Orders;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CancelAbandoned extends Component
{
    use WithNotifications;

    public $modal = false;

    public Order $order;

    public function cancel()
    {
        if (
            $this->order->status != null &&
            $this->order->stocks()->count() != 0
        ) {
            $this->notify('unable to cancel this order');

            return back();
        }

        $this->order->updateStatus('cancelled');

        $this->notify('order cancelled');

    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.orders.cancel-abandoned');
    }
}
