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
        $query = Product::query()->whereIn('id', $this->selectedProducts);

        $query->chunkById(10, function ($products) {
            foreach ($products as $product) {
                $this->credit->addItem($product);
            }
        });

        $this->reset(['searchQuery']);
        $this->selectedProducts = [];
        $this->emit('refreshData');
        $this->notify('Products added');
        $this->modal = false;
    }

    public function render()
    {
        $existingCreditItems = $this->credit->items()->pluck('product_id');

        return view('livewire.credit.add-product', [
            'products' => Product::query()
                ->with('features')
                ->whereNotIn('id', $existingCreditItems)
                ->whereHas(
                    'stocks',
                    fn ($query) => $query->where(
                        'sales_channel_id',
                        auth()
                            ->user()
                            ->defaultSalesChannel()->id
                    )
                )
                ->when(
                    $this->searchQuery,
                    fn ($query) => $query->search($this->searchQuery)
                )
                ->simplePaginate(10),
        ]);
    }
}
