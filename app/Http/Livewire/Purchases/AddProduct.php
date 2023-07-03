<?php

namespace App\Http\Livewire\Purchases;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Product;
use App\Models\Purchase;
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

    public Purchase $purchase;

    public function updatedSearchQuery(): void
    {
        $this->resetPage();
    }

    public function addProducts(): void
    {
        foreach ($this->selectedProducts as $productId) {
            $product = Product::findOrFail($productId);

            $this->purchase->addItem($product);
        }

        $this->modal = false;

        $this->reset(['searchQuery']);

        $this->selectedProducts = [];

        $this->emit('refreshData');

        $this->notify('Products added');
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.purchases.add-product', [
            'products' => Product::query()
                ->with('features')
                ->when(
                    $this->searchQuery,
                    fn ($query) => $query->search($this->searchQuery)
                )
                ->simplePaginate(10),
        ]);
    }
}
