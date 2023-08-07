<?php

namespace App\Http\Livewire\SupplierTransactions;

use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\UpdateSupplierRunningBalanceJob;
use App\Models\Supplier;
use App\Models\SupplierTransaction;
use Livewire\Component;

class Create extends Component
{
    use WithNotifications;

    public $modal = false;

    public $amount;

    public $reference;

    public $type;

    public $date;

    public $description;

    public Supplier $supplier;

    public function rules(): array
    {
        return [
            'reference' => ['required'],
            'amount' => ['required'],
            'type' => ['required'],
            'date' => ['sometimes', 'date'],
            'description' => ['sometimes'],
        ];
    }

    public function save()
    {
        $additionalFields = [
            'supplier_id' => $this->supplier->id,
            'created_by' => auth()->user()->name,
        ];

        $validatedData = $this->validate();

        $fields = array_merge($additionalFields, $validatedData);

        if ($this->type === 'payment') {
            $fields['amount'] = 0 - $this->amount;
        }

        SupplierTransaction::create($fields);

        UpdateSupplierRunningBalanceJob::dispatch($this->supplier->id)->delay(
            2
        );

        $this->reset('amount', 'reference', 'type', 'date', 'description');
        $this->modal = false;

        $this->emit('refresh_data');

        $this->notify('payment created');
    }

    public function render()
    {
        return view('livewire.supplier-transactions.create');
    }
}
