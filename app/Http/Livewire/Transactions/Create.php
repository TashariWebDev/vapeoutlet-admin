<?php

namespace App\Http\Livewire\Transactions;

use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\UpdateCustomerRunningBalanceJob;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use LaravelIdea\Helper\App\Models\_IH_Customer_C;
use Livewire\Component;

class Create extends Component
{
    use WithNotifications;

    public $modal = false;

    public $reference;

    public $type;

    public $amount;

    public $date;

    public $customerId;

    public function rules(): array
    {
        return [
            'reference' => ['required'],
            'type' => ['required'],
            'amount' => ['required'],
            'date' => ['sometimes'],
        ];
    }

    public function mount()
    {
        $this->customerId = request('id');
    }

    public function getCustomerProperty(): Customer|_IH_Customer_C|array|null
    {
        return Customer::find($this->customerId);
    }

    public function save()
    {
        $additionalFields = [
            'customer_id' => $this->customerId,
            'created_by' => auth()->user()->name,
        ];

        $validatedData = $this->validate();
        $fields = array_merge($additionalFields, $validatedData);

        if (
            $this->type == 'refund' ||
            $this->type == 'payment' ||
            $this->type == 'warranty'
        ) {
            $fields['amount'] = 0 - $this->amount;
        }

        Transaction::create($fields);

        UpdateCustomerRunningBalanceJob::dispatch($this->customerId);

        $this->reset('amount', 'reference', 'type', 'date');

        $this->notify('transaction created');

        $this->emit('updateData');

        $this->modal = true;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.transactions.create');
    }
}
