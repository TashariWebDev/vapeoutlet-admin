<?php

namespace App\Http\Livewire\StockTransfers;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Product;
use App\Models\StockTransfer;
use App\Models\StockTransferItem;
use Livewire\Component;
use Livewire\WithPagination;

class Edit extends Component
{
    use WithPagination;
    use WithNotifications;

    public $showConfirmModal = false;

    public $searchQuery;

    public $selectedProducts = [];

    public $selectedProductsToDelete = [];

    public $products = [];

    public $sku;

    public $transfer;

    protected $listeners = ['refreshData' => '$refresh'];

    public function mount()
    {
        $this->transfer = StockTransfer::findOrFail(request('id'));
    }

    public function removeProducts()
    {
        foreach ($this->selectedProductsToDelete as $selectedItem) {
            $item = StockTransferItem::findOrFail($selectedItem);
            $this->deleteItem($item);
        }

        $this->selectedProductsToDelete = [];
        $this->emitSelf('refreshData');
        $this->notify('Products removed');
    }

    public function updatedSku()
    {
        $this->validate(['sku' => 'required']);

        $product = Product::where('sku', '=', $this->sku)->first();

        if (! $product) {
            return;
        }

        $this->transfer->addItem($product);
        $this->notify('Product added');

        $this->sku = '';
        $this->emit('refreshData');
    }

    public function updateQty(StockTransferItem $item, $qty, $available)
    {
        if ($qty == '' || $qty == 0) {
            $this->notify('Please enter a valid qty');

            return;
        }

        if ($qty <= $available) {
            $item->update(['qty' => $qty]);
            $this->notify('Qty updated');
        } else {
            $item->update(['qty' => $available]);
            $this->notify("Max Qty of $available added");
        }

        $this->transfer->refresh();
        $this->emitSelf('refreshData');
    }

    public function deleteItem(StockTransferItem $item)
    {
        $item->delete();

        $this->emitSelf('refreshData');
        $this->notify('Item deleted');
    }

    public function process()
    {
        $this->showConfirmModal = false;
        $this->notify('Processing');

        $this->transfer->transferStock();
        $this->transfer->markAsProcessed();

        $this->notify('processed');

        $this->redirect('/stock-transfers');
    }

    public function cancel()
    {
        foreach ($this->transfer->items as $item) {
            $item->delete();
        }

        $this->transfer->cancel();
        $this->notify('Transfer cancelled');

        $this->redirect('/stock-transfers');
    }

    public function render()
    {
        return view('livewire.stock-transfers.edit', [
            'stockTransfer' => $this->transfer->load([
                'items',
                'items.product' => function ($query) {
                    $query->withSum(
                        [
                            'stocks as total_available' => function ($query) {
                                $query->where(
                                    'sales_channel_id',
                                    $this->transfer->dispatcher_id
                                );
                            },
                        ],
                        'qty'
                    );
                },
            ]),
        ]);
    }
}
