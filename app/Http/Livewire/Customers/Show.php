<?php

namespace App\Http\Livewire\Customers;

use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\UpdateCustomerRunningBalanceJob;
use App\Models\Credit;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Transaction;
use App\Notifications\StatementNotification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Str;

class Show extends Component
{
    use WithPagination;
    use WithNotifications;

    public $recordCount = 10;

    public $showAddTransactionForm = false;

    public $customerId;

    public $filter;

    public $searchTerm = "";

    public $reference;

    public $type;

    public $amount;

    public $date;

    public function rules(): array
    {
        return [
            "reference" => ["required"],
            "type" => ["required"],
            "amount" => ["required"],
            "date" => ["sometimes"],
        ];
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
        return Customer::find($this->customerId)
            ->load("transactions", "salesperson:id,name")
            ->loadCount("transactions");
    }

    public function getTransactionsProperty()
    {
        return $this->customer->transactions;
    }

    public function getInvoicesProperty()
    {
        return $this->transactions->where("type", "=", "invoice");
    }

    public function getDebitsProperty()
    {
        return $this->transactions->where("type", "=", "debit");
    }

    public function getCreditsProperty()
    {
        return $this->transactions->where("type", "=", "credit");
    }

    public function getRefundsProperty()
    {
        return $this->transactions->where("type", "=", "refund");
    }

    public function getPaymentsProperty()
    {
        return $this->transactions->where("type", "=", "payment");
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

    /**
     * @throws CouldNotTakeBrowsershot
     */
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

        if (Str::startsWith($transaction->reference, "CR00")) {
            $model = Credit::with("items", "items.product", "customer")->find(
                Str::after($transaction->reference, "CR00")
            );
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
        return view("livewire.customers.show", [
            "transactions" => Transaction::query()
                ->when($this->filter, function ($query) {
                    $query->where("type", "=", $this->filter);
                })
                ->when($this->searchTerm, function ($query) {
                    $query
                        ->where("customer_id", "=", $this->customerId)
                        ->where(
                            "reference",
                            "like",
                            "%" . $this->searchTerm . "%"
                        )
                        ->orWhere("created_by", "like", $this->searchTerm . "%")
                        ->orWhere(
                            "amount",
                            "like",
                            to_cents($this->searchTerm) . "%"
                        );
                })
                ->latest("id")
                ->where("customer_id", "=", $this->customerId)
                ->paginate($this->recordCount),
        ]);
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

        $this->reset("amount", "reference", "type", "date");

        $this->notify("transaction created");
        $this->showAddTransactionForm = false;

        $this->redirect("/customers/show/{$this->customerId}");
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function printStatement()
    {
        $this->getStatement();

        $email = $this->customer->email;

        $this->redirect("/storage/documents/$email.pdf");
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getStatement()
    {
        $view = view("templates.pdf.statement", [
            "customer" => $this->customer,
            "transactions" => Transaction::query()
                ->latest("id")
                ->where("customer_id", "=", $this->customerId)
                ->take($this->recordCount)
                ->get(),
        ])->render();

        $email = $this->customer->email;
        $url = storage_path("app/public/documents/$email.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia("print")
            ->format("a4")
            ->paperSize(297, 210)
            ->setScreenshotType("pdf", 90)
            ->save($url);
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function sendStatement()
    {
        $this->getStatement();

        $this->customer->notify(
            (new StatementNotification($this->customer))->delay(120)
        );

        $this->notify("Statement queued to be sent (2 minutes)");
    }

    public function updateBalances()
    {
        $this->customer->load("transactions");
        $balance = 0;
        foreach ($this->customer->transactions as $transaction) {
            $balance += $transaction->amount;
            $transaction->running_balance = $balance;
            $transaction->save();
        }

        $this->redirect("/customers/show/{$this->customer->id}");
    }
}
