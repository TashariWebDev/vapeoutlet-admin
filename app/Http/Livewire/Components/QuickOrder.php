<?php

namespace App\Http\Livewire\Components;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class QuickOrder extends Component
{
    use WithPagination;

    public $searchModal;

    public $searchQuery;

    public function updatedSearchQuery()
    {
        $this->searchModal = true;
    }

    public function createOrder($customerId)
    {
        $order = Order::firstOrCreate([
            "customer_id" => $customerId,
            "status" => null,
            "processed_by" => auth()->user()->name,
        ]);

        $this->redirect("/orders/create/{$order->id}");
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.components.quick-order", [
            "customers" => Customer::query()
                ->where("name", "like", "%" . $this->searchQuery . "%")
                ->orWhere("email", "like", "%" . $this->searchQuery . "%")
                ->orWhere("phone", "like", "%" . $this->searchQuery . "%")
                ->orWhere("company", "like", "%" . $this->searchQuery . "%")
                ->paginate(5),
        ]);
    }
}
