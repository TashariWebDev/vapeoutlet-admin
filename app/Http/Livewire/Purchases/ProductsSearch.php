<?php

namespace App\Http\Livewire\Purchases;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use LaravelIdea\Helper\App\Models\_IH_Purchase_C;
use Livewire\Component;

class ProductsSearch extends Component
{
    use WithNotifications;

    public $modal = false;

    public $searchQuery = '';

    public $selectedProducts = [];

    public $products = [];

    public function mount()
    {
        $this->purchaseId = request('id');
    }

    public function getPurchaseProperty(): Purchase|array|_IH_Purchase_C|null
    {
        return Purchase::where('purchases.id', $this->purchaseId)->first();
    }

    public function updatedSearchQuery()
    {
        $this->products = Product::query()
            ->when(
                $this->searchQuery,
                fn ($query) => $query->search($this->searchQuery)
            )
            ->get();
    }

    public function addProducts()
    {
        foreach ($this->selectedProducts as $product) {
            $this->purchase->items()->updateOrCreate(
                [
                    'product_id' => $product,
                ],
                [
                    'product_id' => $product,
                ]
            );
        }

        $this->modal = false;

        $this->reset(['searchQuery']);

        $this->selectedProducts = [];

        $this->notify('Products added');

        $this->emit('update_purchase');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.purchases.products-search');
    }
}
