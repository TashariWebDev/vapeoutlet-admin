<?php

namespace App\Http\Livewire\Orders;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Quick extends Component
{
    use WithPagination;

    public $modal = false;

    public $searchQuery;

    public $customers = [];

    protected $listeners = ['newOrder' => 'toggle'];

    public function toggle()
    {
        $this->modal = true;
    }

    public function updatedSearchQuery()
    {
        $this->modal = true;

        if ($this->searchQuery) {
            $this->customers = Customer::query()
                ->where('name', 'like', '%'.$this->searchQuery.'%')
                ->orWhere('email', 'like', '%'.$this->searchQuery.'%')
                ->orWhere('phone', 'like', '%'.$this->searchQuery.'%')
                ->orWhere('company', 'like', '%'.$this->searchQuery.'%')
                ->get();
        } else {
            $this->customers = [];
        }
    }

    public function createOrder($customerId)
    {
        $order = Order::firstOrCreate([
            'customer_id' => $customerId,
            'status' => null,
            'processed_by' => auth()->user()->name,
        ]);

        $this->redirect("/orders/create/$order->id");
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.orders.quick');
    }
}
