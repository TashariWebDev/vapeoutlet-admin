<?php

namespace App\Http\Livewire\StockTransfers;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Product;
use App\Models\StockTransfer;
use Livewire\Component;
use Livewire\WithPagination;

class AddProducts extends Component
{
    use WithNotifications;
    use WithPagination;

    public $modal = false;

    public $searchQuery = '';

    public $selectedProducts = [];

    public $stockTransfer;

    public $dispatcher_id;

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function mount($stockTransferId)
    {
        $this->stockTransfer = StockTransfer::findOrFail($stockTransferId);
        $this->dispatcher_id = $this->stockTransfer->dispatcher_id;
    }

    public function addProducts()
    {
        $query = Product::query()
            ->withSum(
                [
                    'stocks as total_available' => function ($query) {
                        $query->where('outlet_id', $this->dispatcher_id);
                    },
                ],
                'qty'
            )
            ->whereIn('id', $this->selectedProducts);

        $query->chunkById(10, function ($products) {
            foreach ($products as $product) {
                if ($product->total_available > 0) {
                    $this->stockTransfer->addItem($product);
                    $this->notify($product->fullName().' added to transfer.');
                } else {
                    $this->notify(
                        $product->fullName().' currently out of stock'
                    );
                }
            }
        });

        $this->reset(['searchQuery', 'selectedProducts', 'modal']);
        $this->emit('refreshData');
    }

    public function render()
    {
        return view('livewire.stock-transfers.add-products', [
            'products' => Product::query()
                ->select('id', 'name', 'sku', 'brand')
                ->with('features:id,product_id,name')
                ->whereHas(
                    'stocks',
                    fn ($query) => $query->where(
                        'outlet_id',
                        $this->dispatcher_id
                    )
                )
                ->withSum(
                    [
                        'stocks as total_available' => function ($query) {
                            $query->where('outlet_id', $this->dispatcher_id);
                        },
                    ],
                    'qty'
                )
                ->having('total_available', '>', 0)
                ->when(
                    $this->searchQuery,
                    fn ($query) => $query->search($this->searchQuery)
                )
                ->orderBy('brand')
                ->simplePaginate(10),
        ]);
    }
}
