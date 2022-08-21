<?php

namespace App\Http\Livewire\Warehouse;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Order;
use Http;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithNotifications;

    public $searchTerm = "";

    public function pushToDispatch(Order $order)
    {
        $order->updateStatus("packed");
        $this->notify("order ready for shipping");
    }

    public function getDocument(Order $order)
    {
        Http::get(config("app.admin_url") . "/webhook/pick-lists/{$order->id}");

        $this->redirect("/warehouse?page={$this->page}");
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.warehouse.index", [
            "orders" => Order::query()
                ->with("delivery", "customer", "customer.transactions", "items")
                ->when(
                    $this->searchTerm,
                    fn($query) => $query->search($this->searchTerm)
                )
                ->where("status", "=", "processed")
                ->latest()
                ->paginate(5),
        ]);
    }
}
