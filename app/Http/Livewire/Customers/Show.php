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
use LaravelIdea\Helper\App\Models\_IH_Customer_C;
use Livewire\Component;
use Livewire\WithPagination;
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

    public $fromDate;

    public $toDate;

    public $searchQuery = '';

    protected $listeners = ['updateData' => '$refresh'];

    protected $queryString = ['recordCount', 'searchQuery'];

    public function mount()
    {

        $this->toDate = today();

        $this->customerId = request('id');

        if (request()->has('searchQuery')) {
            $this->searchQuery = request('searchQuery');
        }

        if (request()->has('recordCount')) {
            $this->recordCount = request('recordCount');
        }

        UpdateCustomerRunningBalanceJob::dispatch($this->customerId);
    }

    public function resetDateFilter(): void
    {
        $this->reset('fromDate');

        $this->toDate = today();
    }

    public function updatedSearchQuery(): void
    {
        $this->resetPage();
    }

    public function updatedFilter(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->resetPage();
        $this->filter = '';
    }

    public function getCustomerProperty(): Customer|_IH_Customer_C|array|null
    {
        return Customer::findOrFail($this->customerId);
    }

    public function createOrder()
    {
        $order = Order::firstOrCreate([
            'customer_id' => $this->customer->id,
            'status' => null,
            'processed_by' => auth()->user()->name,
        ]);

        $order->update([
            'created_at' => now(),
            'sales_channel_id' => auth()
                ->user()
                ->defaultSalesChannel()->id,
        ]);

        return redirect("/orders/create/$order->id");
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.customers.show', [
            'lifetimeTransactions' => $this->customer->transactions()
                ->when($this->fromDate, function ($query) {
                    $query->whereDate('created_at', '>=', $this->fromDate)
                        ->whereDate('created_at', '<=', $this->toDate);
                })
                ->get(),
            'transactions' => $this->customer
                ->transactions()
                ->when($this->searchQuery, function ($query) {
                    $query->where(function ($query) {
                        $query
                            ->where(
                                'reference',
                                'like',
                                '%'.$this->searchQuery.'%'
                            )
                            ->orWhere(
                                'amount',
                                'like',
                                '%'.$this->searchQuery.'%'
                            );
                    });
                })
                ->when($this->filter, function ($query) {
                    $query->where('type', '=', $this->filter);
                })
                ->latest()
                ->orderByDesc('id')
                ->paginate($this->recordCount),
        ]);
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getDocument(Transaction $transaction)
    {
        if ($transaction->type == 'invoice') {
            $order = Order::find(Str::after($transaction->reference, 'INV00'));

            return $order->print();
        }

        if ($transaction->type == 'credit') {
            $credit = Credit::find(Str::after($transaction->reference, 'CR00'));

            return $credit->print();
        }

        return $transaction->print();
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function printStatement()
    {
        $this->customer->getStatement($this->recordCount);
        $statement = $this->customer->statement;

        return redirect(
            '/storage/'.
            config('app.storage_folder').
            "/documents/$statement.pdf"
        );
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function sendStatement(): void
    {
        $this->customer->getStatement($this->recordCount);

        $this->customer->notify(
            (new StatementNotification($this->customer))->delay(120)
        );

        $this->notify('Statement queued to be sent (2 minutes)');
    }

    public function updateBalances()
    {
        $transactions = Transaction::where(
            'customer_id',
            $this->customerId
        )->get();

        $balance = 0;

        foreach ($transactions as $transaction) {
            $balance += $transaction->amount;
            $transaction->running_balance = $balance;
            $transaction->save();
        }

        return redirect("/customers/show/{$this->customer->id}");
    }
}
