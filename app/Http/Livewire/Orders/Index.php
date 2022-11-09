<?php

namespace App\Http\Livewire\Orders;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use LaravelIdea\Helper\App\Models\_IH_Order_QB;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Browsershot\Browsershot;
use Str;

class Index extends Component
{
    use WithPagination;

    use WithNotifications;

    public $showAddOrderForm = false;

    public $quickViewCustomerAccountModal = false;

    public $selectedCustomerLatestTransactions = [];

    public $searchTerm = "";

    public $filter = "received";

    public $customerType;

    public $recordCount = 10;

    public $direction = "asc";

    public $statuses = [
        "received",
        "processed",
        "packed",
        "shipped",
        "completed",
        "cancelled",
    ];

    protected $queryString = [
        "filter",
        "customerType",
        "recordCount",
        "direction",
        "searchTerm",
    ];

    public function getTotalActiveOrdersProperty(): int
    {
        return Order::query()
            ->where("status", "=", "received")
            ->orWhere("status", "=", "processed")
            ->orWhere("status", "=", "packed")
            ->count();
    }

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

    public function pushToComplete($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->updateStatus("completed");
        $this->notify("order completed");
        $this->redirect("/orders?filter=shipped");
    }

    public function getDocument($transactionId)
    {
        $model = $transaction = Transaction::findOrFail($transactionId);

        if (
            \Illuminate\Support\Str::startsWith(
                $transaction->reference,
                "INV00"
            )
        ) {
            $model = Order::with(
                "items",
                "items.product",
                "items.product.features",
                "customer",
                "notes"
            )->find(Str::after($transaction->reference, "INV00"));
        }

        $view = view("templates.pdf.{$transaction->type}", [
            "model" => $model,
        ])->render();

        $url = storage_path("app/public/documents/{$transaction->uuid}.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia("print")
            ->format("a4")
            ->paperSize(297, 210)
            ->setScreenshotType("pdf", 100)
            ->save($url);

        $this->redirect("/storage/documents/{$transaction->uuid}.pdf");
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.orders.index", [
            "orders" => $this->filteredOrders()->paginate($this->recordCount),
        ]);
    }

    public function filteredOrders(): Builder|_IH_Order_QB
    {
        $orders = Order::query()
            ->with([
                "delivery:id,type",
                "customer.salesperson",
                "customer.transactions",
            ])
            ->addSelect([
                "order_total" => OrderItem::query()
                    ->whereColumn("order_id", "=", "orders.id")
                    ->selectRaw("sum(qty * price) as order_total"),
            ])
            ->whereNotNull("status")
            ->orderBy("created_at", $this->direction);

        if ($this->filter) {
            $orders->whereStatus($this->filter);
        }

        if ($this->customerType === true) {
            $orders->whereRelation("customer", "is_wholesale", "=", true);
        }

        if ($this->customerType === false) {
            $orders->whereRelation("customer", "is_wholesale", "=", false);
        }

        if ($this->searchTerm) {
            $orders->search($this->searchTerm);
        }

        return $orders;
    }

    public function mount()
    {
        //        dd(request()->all());
        if (request()->has("filter")) {
            $this->filter = request("filter");
        }

        if (request()->has("searchTerm")) {
            $this->searchTerm = request("searchTerm");
        }

        if (request()->has("customerType")) {
            if (request("customerType") === true) {
                $this->customerType = true;
            }
            if (request("customerType") === false) {
                $this->customerType = false;
            }
        }

        if (!request()->has("customerType")) {
            $this->customerType = null;
        }

        if (request()->has("recordCount")) {
            $this->recordCount = request("recordCount");
        }

        if (request()->has("direction")) {
            $this->direction = request("direction");
        }
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }
}
