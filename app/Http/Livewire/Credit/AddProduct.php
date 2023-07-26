<?php

namespace App\Http\Livewire\Credit;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Credit;
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

    public Credit $credit;

    public function updatedSearchQuery(): void
    {
        $this->resetPage();
    }

    public function updatedModal(): void
    {
        $this->searchQuery = '';
    }

    public function addProducts(): void
    {
        if (! count($this->selectedProducts)) {
            return;
        }

        Product::query()
            ->whereIn('id', $this->selectedProducts)
            ->chunkById(10, function ($products) {
                foreach ($products as $product) {
                    $this->credit->addItem($product);
                }
            });

        $this->reset(['searchQuery', 'selectedProducts', 'modal']);
        $this->emit('refreshData');
        $this->notify('Products added');
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
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
