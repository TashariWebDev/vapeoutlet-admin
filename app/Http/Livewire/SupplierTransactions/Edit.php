<?php

namespace App\Http\Livewire\SupplierTransactions;

use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\UpdateSupplierRunningBalanceJob;
use App\Models\SupplierTransaction;
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

    public SupplierTransaction $transaction;

    public $supplier;

    public function rules(): array
    {
        return [
            'transaction.reference' => 'required',
            'transaction.description' => 'sometimes',
            'transaction.date' => 'required',
            'transaction.amount' => 'required',
            'transaction.type' => 'required',
        ];
    }

    public function mount(): void
    {
        $this->transaction = SupplierTransaction::findOrFail(request('id'));
        $this->supplier = $this->transaction->supplier_id;

        if (
            $this->transaction->type == 'payment'
        ) {
            $this->transaction->amount = 0 - $this->transaction->amount;
        }

    }

    public function update(): Redirector|Application|RedirectResponse
    {

        if (
            $this->transaction->type == 'payment'
        ) {
            $this->transaction->amount = 0 - $this->transaction->amount;
        }

        $this->validate();

        $this->transaction->save();

        UpdateSupplierRunningBalanceJob::dispatch($this->supplier);

        $this->notify('transaction updated');

        return redirect('suppliers/'.$this->supplier);
    }

    public function delete(): Redirector|Application|RedirectResponse
    {
        $this->transaction->delete();

        UpdateSupplierRunningBalanceJob::dispatch($this->supplier);

        return redirect('suppliers/'.$this->supplier);
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.supplier-transactions.edit');
    }
}
