<?php

namespace App\Http\Livewire\Orders;

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

    public $showAddOrderForm = false;

    public $searchTerm = "";

    public $filter = "received";

    public function getDocument($transactionId)
    {
        Http::get(
            config("app.admin_url") . "/webhook/save-document/{$transactionId}"
        );

        $this->redirect(
            "orders?page={$this->page}&filter={$this->filter}&searchTerm={$this->searchTerm}"
        );
    }

    public function mount()
    {
        if (request()->has("filter")) {
            $this->filter = request("filter");
        }

        if (request()->has("searchTerm")) {
            $this->searchTerm = request("searchTerm");
        }
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.orders.index", [
            "orders" => Order::query()
                ->with([
                    "delivery:id,type",
                    "customer.transactions:id,customer_id,reference,uuid",
                ])
                //                ->whereNotNull("status")
                ->whereStatus($this->filter)
                ->search($this->searchTerm)
                //                ->orderBy("placed_at", "desc")
                ->paginate(6),
        ]);
    }
}
