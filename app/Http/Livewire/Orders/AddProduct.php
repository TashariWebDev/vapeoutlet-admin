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

    /**
     * @throws QtyNotAvailableException
     */
    public function addProducts()
    {
        foreach ($this->selectedProducts as $productId) {
            $product = Product::findOrFail($productId);
            if ($product->outOfStock()) {
                $this->notify($product->fullName().' currently out of stock');
            }

            if ($product->inStock()) {
                $this->order->addItem($product->id);
            }
        }

        $this->modal = false;

        $this->reset(['searchQuery']);

        $this->selectedProducts = [];

        $this->emit('refreshData');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.orders.add-product', [
            'products' => Product::query()
                ->with('features')
                ->when(
                    $this->searchQuery,
                    fn ($query) => $query->search($this->searchQuery)
                )
                ->inStock()
                ->simplePaginate(10),
        ]);
    }
}
