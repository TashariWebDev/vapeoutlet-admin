<?php

namespace App\Http\Livewire\Purchases;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\_IH_Supplier_C;
use Livewire\Component;

class Create extends Component
{
    use WithNotifications;

    public $slide = false;

    public $suppliers = [];

    public $supplier_id;

    public $invoice_no;

    public $amount;

    public $date;

    public $taxable = true;

    public $exchange_rate;

    public $shipping_rate;

    public $currency = 'ZAR';

    public $creator_id;

    protected $listeners = [
        'supplier_updated' => 'getSuppliers',
        'refreshData' => '$refresh',
    ];

    public function rules(): array
    {
        return [
            'supplier_id' => ['required', 'integer'],
            'invoice_no' => ['required', 'unique:purchases,invoice_no'],
            'amount' => ['required'],
            'date' => ['required', 'date'],
            'shipping_rate' => ['nullable'],
            'exchange_rate' => ['nullable'],
            'currency' => ['required'],
            'taxable' => ['required'],
            'creator_id' => ['required'],
        ];
    }

    public function mount($supplierId = null)
    {
        $this->creator_id = auth()->id();

        $this->supplier_id = $supplierId;
    }

    public function updatedSlide()
    {
        if ($this->slide === true) {
            $this->suppliers = $this->getSuppliers();
        } else {
            $this->emitSelf('refreshData');
            $this->reset('suppliers');
        }
    }

    public function getSuppliers(): _IH_Supplier_C|Collection|array
    {
        return $this->suppliers = Supplier::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();
    }

    public function save()
    {
        $validatedData = $this->validate();

        $purchase = Purchase::create($validatedData);

        $this->redirectRoute('purchases/edit', [
            'id' => $purchase->id,
        ]);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.purchases.create');
    }
}
