<?php

namespace App\Http\Livewire\Transactions\Warranty;

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

    public $type = 'warranty';

    public $amount;

    public $date;

    public $customerId;

    public function rules(): array
    {
        return [
            'reference' => ['required'],
            'type' => ['required'],
            'amount' => ['required'],
            'date' => ['required'],
        ];
    }

    public function getCustomerProperty(): Customer|_IH_Customer_C|array|null
    {
        return Customer::find($this->customerId);
    }

    public function save()
    {
        $additionalFields = [
            'customer_id' => $this->customer->id,
            'created_by' => auth()->user()->name,
        ];

        $validatedData = $this->validate();

        $fields = array_merge($additionalFields, $validatedData);

        $fields['amount'] = 0 - $this->amount;

        Transaction::create($fields);

        UpdateCustomerRunningBalanceJob::dispatch($this->customerId);

        $this->notify('warranty created');
        $this->reset('amount', 'reference', 'type', 'date', 'modal');
        $this->emit('updateData');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.transactions.warranty.create');
    }
}
