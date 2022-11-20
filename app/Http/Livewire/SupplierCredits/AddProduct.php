<?php

namespace App\Http\Livewire\SupplierCredits;

use App\Exceptions\QtyNotAvailableException;
use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Product;
use App\Models\SupplierCredit;
use Livewire\Component;

class AddProduct extends Component
{
    use WithNotifications;

    public $modal = false;

    public $searchQuery = '';

    public $selectedProducts = [];

    public $products = [];

    public $sku;

    public SupplierCredit $credit;

    public function updatedSearchQuery()
    {
        $this->products = Product::query()
            ->when(
                $this->searchQuery,
                fn ($query) => $query->search($this->searchQuery)
            )
            ->get();
    }

    /**
     * @throws QtyNotAvailableException
     */
    public function addProducts()
    {
        foreach ($this->selectedProducts as $productId) {
            $product = Product::findOrFail($productId);

            $this->credit->addItem($product);
        }

        $this->modal = false;

        $this->reset(['searchQuery']);

        $this->selectedProducts = [];

        $this->emit('refreshData');

        $this->notify('Products added');
    }

    public function render()
    {
        return view('livewire.supplier-credits.add-product');
    }
}
