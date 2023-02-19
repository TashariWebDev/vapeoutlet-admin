<?php

namespace App\Http\Livewire\Suppliers;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\SupplierCredit;
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

    public $searchQuery = '';

    protected $listeners = ['refresh_data' => '$refresh'];

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->supplierId = request('id');
    }

    public function getSupplierProperty(): _IH_Supplier_C|array|Supplier|null
    {
        return Supplier::query()
            ->with('transactions')
            ->where('id', $this->supplierId)
            ->first();
    }

    public function getTransactionsProperty()
    {
        return $this->supplier->transactions();
    }

    public function getCreditsProperty()
    {
        return $this->supplier->transactions->where(
            'type',
            '=',
            'supplier_credit'
        );
    }

    public function getInvoicesProperty()
    {
        return $this->supplier->transactions->where('type', '=', 'purchase');
    }

    public function getExpensesProperty()
    {
        return $this->supplier->transactions->where('type', '=', 'expense');
    }

    public function getPaymentsProperty()
    {
        return $this->supplier->transactions->where('type', '=', 'payment');
    }

    public function showPurchase($invoiceNo)
    {
        $purchase = Purchase::where('invoice_no', '=', $invoiceNo)->first();

        $this->redirect("/purchases/$purchase->id");
    }

    public function showSupplierCredit($creditNumber)
    {
        $creditId = Str::after($creditNumber, 'SC00');

        $this->redirect("/supplier-credits/show/$creditId");
    }

    public function createCredit()
    {
        $credit = SupplierCredit::firstOrCreate(
            [
                'supplier_id' => $this->supplier->id,
                'processed_at' => null,
            ],
            [
                'created_by' => auth()->user()->name,
            ]
        );

        return redirect()->route('supplier-credits/create', $credit->id);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.suppliers.show', [
            'purchases' => Purchase::query()
                ->with(['items'])
                ->whereNull('processed_date')
                ->whereBelongsTo($this->supplier)
                ->latest('id')
                ->get(),
            'supplierTransactions' => $this->transactions
                ->when($this->searchQuery, function ($query) {
                    $query->where(
                        'reference',
                        'like',
                        $this->searchQuery.'%'
                    );
                })
                ->latest('id')
                ->whereBelongsTo($this->supplier)
                ->paginate(5),
        ]);
    }
}
