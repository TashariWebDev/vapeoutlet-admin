<?php

namespace App\Http\Livewire\Purchases;

use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\UpdateSupplierRunningBalanceJob;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use LaravelIdea\Helper\App\Models\_IH_Purchase_C;
use Livewire\Component;
use Livewire\WithPagination;

class Edit extends Component
{
    use WithPagination;
    use WithNotifications;

    public $purchaseId;

    public $showConfirmModal = false;

    public $selectedProducts = [];

    public $selectedProductsToDelete = [];

    public $sku;

    protected $listeners = ['refreshData' => '$refresh'];

    public function mount()
    {
        $this->purchaseId = request('id');
    }

    public function getPurchaseProperty(): Purchase|array|_IH_Purchase_C|null
    {
        return Purchase::where('purchases.id', $this->purchaseId)->first();
    }

    public function updatePrice(PurchaseItem $item, $value)
    {
        if ($value == '' || $value <= 0) {
            $this->notify('Please enter a valid price');

            return;
        }

        $item->update(['price' => $value]);
        $this->emitSelf('refreshData');
        $this->notify('Price updated');
    }

    public function updatedSku()
    {
        $this->validate(['sku' => 'required']);

        $product = Product::where('sku', '=', $this->sku)->first();

        if (! $product) {
            return;
        }

        $this->purchase->addItem($product);
        $this->notify('Product added');

        $this->sku = '';
        $this->emit('refreshData');
    }

    public function updateQty(PurchaseItem $item, $value)
    {
        if ($value == '' || $value <= 0) {
            $this->notify('Please enter a valid qty');

            return;
        }

        $item->update(['qty' => $value]);
        $this->emitSelf('refreshData');
        $this->notify('Qty updated');
    }

    public function removeProducts()
    {
        foreach ($this->selectedProductsToDelete as $selectedItem) {
            $item = PurchaseItem::findOrFail($selectedItem);
            $this->deleteItem($item);
        }

        $this->selectedProductsToDelete = [];
        $this->emitSelf('refreshData');
        $this->notify('Products removed');
    }

    public function deleteItem(PurchaseItem $item)
    {
        $item->delete();

        $this->emitSelf('refreshData');

        $this->notify('Item deleted');
    }

    public function process()
    {
        $items = $this->purchase->items()->get();

        foreach ($items as $item) {
            if ($item->qty == 0 || $item->price == 0) {
                $this->showConfirmModal = false;
                $this->notify(
                    'There are items with 0 quantities or a price of 0, Please update or remove the item'
                );

                return;
            }
        }

        $this->notify('Processing');

        foreach ($items as $item) {
            $item->bringIntoStock();
            $item->product->averageCost($item);
            $item->product->sendStockAlerts();
            $this->purchase->update(['processed_date' => today()]);
            $this->purchase->supplier->createTransactionFrom($this->purchase);
            UpdateSupplierRunningBalanceJob::dispatch(
                $this->purchase->supplier_id
            )->delay(2);
        }
        $this->notify('processed');
        $this->showConfirmModal = false;
    }

    public function cancel()
    {
        if ($this->purchase->exists('items')) {
            foreach ($this->purchase->items as $item) {
                $item->delete();
            }
        }

        $this->purchase->delete();
        $this->notify('Purchase deleted');

        $this->redirectRoute('products');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.purchases.edit');
    }
}
