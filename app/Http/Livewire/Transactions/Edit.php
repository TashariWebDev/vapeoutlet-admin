<?php

namespace App\Http\Livewire\Transactions;

use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\UpdateCustomerRunningBalanceJob;
use App\Models\Transaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Component;

class Edit extends Component
{
    use WithNotifications;

    public $confirmDelete = false;

    public Transaction $transaction;

    public $customer;

    public function rules(): array
    {
        return [
            "transaction.reference" => "required",
            "transaction.date" => "sometimes",
            "transaction.amount" => "required",
            "transaction.type" => "required",
        ];
    }

    public function mount()
    {
        $this->transaction = Transaction::findOrFail(request("id"));
        $this->customerId = $this->transaction->customer_id;
        if (
            $this->transaction->type == "refund" ||
            $this->transaction->type == "payment"
        ) {
            $this->transaction->amount = 0 - $this->transaction->amount;
        }
    }

    public function update()
    {
        if (
            $this->transaction->type == "refund" ||
            $this->transaction->type == "payment"
        ) {
            $this->transaction->amount = 0 - $this->transaction->amount;
        }

        $this->validate();

        $this->transaction->save();

        UpdateCustomerRunningBalanceJob::dispatch($this->customerId);

        $this->notify("transaction updated");
    }

    public function delete(): Redirector|Application|RedirectResponse
    {
        $this->transaction->delete();

        UpdateCustomerRunningBalanceJob::dispatch($this->customerId);

        return redirect("customers/show/" . $this->customerId);
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.transactions.edit");
    }
}
