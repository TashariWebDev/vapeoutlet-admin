<?php

namespace App\Http\Livewire\Customers;

use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\UpdateCustomerRunningBalanceJob;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Transaction;
use Http;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Str;

class Show extends Component
{
    use WithPagination;
    use WithNotifications;

    public $showAddTransactionForm = false;

    public $customerId;

    public $filter;

    public $searchTerm = "";

    public $reference;

    public $type;

    public $amount;

    public function rules(): array
    {
        return [
            "reference" => ["required"],
            "type" => ["required"],
            "amount" => ["required"],
        ];
    }

    public function save()
    {
        $additionalFields = [
            "customer_id" => $this->customerId,
            "uuid" => Str::uuid(),
            "created_by" => auth()->user()->name,
        ];

        $validatedData = $this->validate();
        $fields = array_merge($additionalFields, $validatedData);

        if ($this->type == "refund" || $this->type == "payment") {
            $fields["amount"] = 0 - $this->amount;
        }

        Transaction::create($fields);

        UpdateCustomerRunningBalanceJob::dispatch($this->customerId);

        $this->reset("amount", "reference", "type");

        $this->notify("transaction created");
        $this->showAddTransactionForm = false;

        sleep(3);
        $this->redirect("/customers/show/{$this->customerId}");
    }

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->resetPage();
        $this->filter = "";
    }

    public function mount()
    {
        $this->customerId = request("id");
    }

    public function getCustomerProperty()
    {
        return Customer::find($this->customerId)->load(
            "transactions",
            "orders",
            "latestTransaction",
            "invoices",
            "debits",
            "credits",
            "refunds",
            "payments"
        );
    }

    public function createOrder()
    {
        $order = Order::firstOrCreate([
            "customer_id" => $this->customer->id,
            "status" => null,
            "processed_by" => auth()->user()->name,
        ]);

        $this->redirect("/orders/create/{$order->id}");
    }

    public function getDocument($transactionId)
    {
        Http::get(
            config("app.admin_url") . "/webhook/save-document/{$transactionId}"
        );

        $this->redirect(
            "/customers/show/{$this->customerId}?page={$this->page}"
        );
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.customers.show", [
            "transactions" => $this->customer
                ->transactions()
                ->latest("id")
                ->when($this->filter, function ($query) {
                    $query->where("type", "=", $this->filter);
                })
                ->when($this->searchTerm, function ($query) {
                    $query
                        ->where("reference", "like", $this->searchTerm . "%")
                        ->orWhere("created_by", "like", $this->searchTerm . "%")
                        ->orWhere(
                            "amount",
                            "like",
                            to_cents($this->searchTerm) . "%"
                        );
                })
                ->simplePaginate(5),
        ]);
    }
}
