<?php

namespace App\Http\Livewire\SupplierCredits;

use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\UpdateSupplierRunningBalanceJob;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierCredit;
use App\Models\SupplierCreditItem;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use LaravelIdea\Helper\App\Models\_IH_Supplier_C;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;
    use WithNotifications;

    public $credit;

    public $showConfirmModal = false;

    public $selectedProductsToDelete = [];

    public $products = [];

    public $sku;

    protected $listeners = ['refreshData' => '$refresh'];

    public function mount()
    {
        $this->credit = SupplierCredit::findOrfail(request('id'));
    }

    public function updatePrice(SupplierCreditItem $item, $value)
    {
        $item->update(['cost' => $value]);

        $this->emitSelf('refreshData');

        $this->notify('Price updated');
    }

    public function updateQty(SupplierCreditItem $item, $value)
    {
        if ($value > $item->product->qty()) {
            $this->notify("We only have {$item->product->qty()} in stock");
            $item->update(['qty' => $item->product->qty()]);
            $this->emitSelf('refreshData');

            return;
        }

        $item->update(['qty' => $value]);

        $this->emitSelf('refreshData');

        $this->notify('Qty updated');
    }

    public function updatedSku()
    {
        $this->validate(['sku' => 'required']);

        $product = Product::where('sku', '=', $this->sku)->first();

        if (! $product) {
            return;
        }

        $this->credit->addItem($product);
        $this->notify('Product added');

        $this->sku = '';
        $this->emit('refreshData');
    }

    public function removeProducts()
    {
        foreach ($this->selectedProductsToDelete as $selectedItem) {
            $item = SupplierCreditItem::findOrFail($selectedItem);
            $this->deleteItem($item);
        }

        $this->selectedProductsToDelete = [];
        $this->emitSelf('refreshData');
        $this->notify('Products removed');
    }

    public function deleteItem(SupplierCreditItem $item)
    {
        $item->delete();

        $this->emitSelf('refreshData');

        $this->notify('Item deleted');
    }

    public function process()
    {
        $this->showConfirmModal = false;

        $this->credit->decreaseStock();

        $this->credit->updateStatus('processed_at');

        $this->supplier->createCredit($this->credit, $this->credit->number);

        UpdateSupplierRunningBalanceJob::dispatch($this->supplier->id)->delay(
            3
        );

        $this->notify('processed');

        return redirect()->route('suppliers', $this->supplier->id);
    }

    public function cancel()
    {
        foreach ($this->credit->items as $item) {
            $item->delete();
        }

        $this->credit->cancel();

        $this->notify('Purchase deleted');

        return redirect()->route('suppliers', $this->supplier->id);
    }

    public function getSupplierProperty(): _IH_Supplier_C|array|Supplier|null
    {
        return Supplier::find($this->credit->supplier_id);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.supplier-credits.create');
    }
}
