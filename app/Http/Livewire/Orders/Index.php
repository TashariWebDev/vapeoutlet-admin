<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use App\Models\Transaction;
use Http;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use LaravelIdea\Helper\App\Models\_IH_Order_QB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $showAddOrderForm = false;

    public $quickViewCustomerAccountModal = false;

    public $selectedCustomerLatestTransactions = [];

    public $searchTerm = "";

    public $filter = "received";

    public $direction = "desc";

    public function selectedCustomerLatestTransactions()
    {
        if ($this->quickViewCustomerAccountModal === false) {
            $this->selectedCustomerLatestTransactions = [];
        }
    }

    public function quickViewCustomerAccount($customerId)
    {
        $this->selectedCustomerLatestTransactions = Transaction::query()
            ->where("customer_id", "=", $customerId)
            ->latest()
            ->take(5)
            ->get();

        $this->quickViewCustomerAccountModal = true;
    }

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

    public function filteredOrders(): Builder|_IH_Order_QB
    {
        $orders = Order::query()
            ->with([
                "delivery:id,type",
                "customer.transactions:id,customer_id,reference,uuid",
            ])
            ->whereNotNull("status")
            ->orderBy("created_at", $this->direction);

        if ($this->filter) {
            $orders->whereStatus($this->filter);
        }

        if ($this->searchTerm) {
            $orders->search($this->searchTerm);
        }

        return $orders;
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.orders.index", [
            "orders" => $this->filteredOrders()->paginate(6),
        ]);
    }
}
