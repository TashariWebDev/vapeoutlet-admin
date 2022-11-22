<?php

namespace App\Http\Livewire\Orders;

use App\Exceptions\QtyNotAvailableException;
use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class AddProduct extends Component
{
    use WithNotifications;
    use WithPagination;

    public $modal = false;

    public $searchQuery = '';

    public $selectedProducts = [];

    public Order $order;

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    /**
     * @throws QtyNotAvailableException
     */
    public function addProducts()
    {
        $query = Product::query()
            ->withStockCount()
            ->whereIn('id', $this->selectedProducts);

        $query->chunkById(10, function ($products) {
            foreach ($products as $product) {
                if ($product->total_available > 0) {
                    $this->order->addItem($product);
                } else {
                    $this->notify(
                        $product->fullName().' currently out of stock'
                    );
                }
            }
        });

        $this->resetPage();
        $this->searchQuery = '';
        $this->selectedProducts = [];
        $this->emit('refreshData');
        $this->modal = false;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.orders.add-product', [
            'products' => Product::query()
                ->select('id', 'name', 'sku', 'brand')
                ->with('features:id,product_id,name')
                ->withStockCount()
                ->inStock()
                ->when(
                    $this->searchQuery,
                    fn ($query) => $query->search($this->searchQuery)
                )
                ->orderBy('brand')
                ->simplePaginate(10),
        ]);
    }
}
