<?php

namespace App\Http\Livewire\Suppliers;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\SupplierTransaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use LaravelIdea\Helper\App\Models\_IH_Supplier_C;
use Livewire\Component;
use Livewire\WithPagination;
use Str;

class Show extends Component
{
    use WithPagination;
    use WithNotifications;

    public $showAddTransactionForm = false;

    public $supplierId;

    public $searchTerm = '';

    public $reference;

    public $amount;

    public $type;

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->supplierId = request('id');
    }

    public function rules(): array
    {
        return [
            'reference' => ['required'],
            'amount' => ['required'],
            'type' => ['required'],
        ];
    }

    public function save()
    {
        $additionalFields = [
            'supplier_id' => $this->supplierId,
            'uuid' => Str::uuid(),
            'created_by' => auth()->user()->name,
        ];

        $validatedData = $this->validate();
        $fields = array_merge($additionalFields, $validatedData);

        if ($this->type === 'payment') {
            $fields['amount'] = 0 - $this->amount;
        }

        SupplierTransaction::create($fields);

        $this->reset('amount', 'reference', 'type');
        $this->showAddTransactionForm = false;

        $this->notify('payment created');
    }

    public function getSupplierProperty(): _IH_Supplier_C|array|Supplier|null
    {
        return Supplier::find($this->supplierId)->load(
            'transactions',
            'purchases'
        );
    }

    public function showPurchase($invoiceNo)
    {
        $purchase = Purchase::where('invoice_no', '=', $invoiceNo)->first();

        $this->redirect("/inventory/purchases/{$purchase->id}");
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.suppliers.show', [
            'purchases' => $this->supplier
                ->purchases()
                ->whereNull('processed_date')
                ->get(),
            'transactions' => $this->supplier
                ->transactions()
                ->latest('id')
                ->when($this->searchTerm, function ($query) {
                    $query->where('reference', 'like', $this->searchTerm);
                })
                ->paginate(5),
        ]);
    }
}
