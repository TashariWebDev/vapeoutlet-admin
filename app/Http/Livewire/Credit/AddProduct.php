<?php

namespace App\Http\Livewire\Credit;

use App\Exceptions\QtyNotAvailableException;
use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Credit;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class AddProduct extends Component
{
    use WithNotifications;
    use WithPagination;

    public $modal = false;

    public $searchQuery = '';

    public $selectedProducts = [];

    public Credit $credit;

    public function updatedSearchQuery()
    {
        $this->resetPage();
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
        return view('livewire.credit.add-product', [
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
