<?php

namespace App\Http\Livewire\Customers;

use App\Http\Livewire\Traits\WithNotifications;
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

    public $searchTerm = '';

    protected $listeners = ['updateData' => '$refresh'];

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
        $this->filter = '';
    }

    public function mount()
    {
        $this->customerId = request('id');
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

        $this->redirect("/orders/create/$order->id");
    }

    public function getTransactionsProperty()
    {
        return $this->customer->transactions();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.customers.show', [
            'lifetimeTransactions' => $this->customer->transactions()->get(),
            'transactions' => $this->customer
                ->transactions()
                ->when($this->searchTerm, function ($query) {
                    $query->where(function ($query) {
                        $query
                            ->where(
                                'reference',
                                'like',
                                '%'.$this->searchTerm.'%'
                            )
                            ->orWhere(
                                'amount',
                                'like',
                                '%'.$this->searchTerm.'%'
                            );
                    });
                })
                ->when($this->filter, function ($query) {
                    $query->where('type', '=', $this->filter);
                })
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

        return redirect("/storage/documents/$statement.pdf");
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function sendStatement()
    {
        $this->customer->getStatement($this->recordCount);

        $this->customer->notify(
            (new StatementNotification($this->customer))->delay(120)
        );

        $this->notify('Statement queued to be sent (2 minutes)');
    }

    public function updateBalances()
    {
        $this->customer->load('transactions');
        $balance = 0;
        foreach ($this->customer->transactions as $transaction) {
            $balance += $transaction->amount;
            $transaction->running_balance = $balance;
            $transaction->save();
        }

        $this->redirect("/customers/show/{$this->customer->id}");
    }
}
