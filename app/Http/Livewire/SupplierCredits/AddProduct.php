<?php

namespace App\Http\Livewire\SupplierCredits;

use App\Exceptions\QtyNotAvailableException;
use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Product;
use App\Models\SupplierCredit;
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

    public SupplierCredit $credit;

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function updatedModal(): void
    {
        $this->searchQuery = '';
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
                    $this->credit->addItem($product);
                    $this->notify($product->fullName().' added to credit.');
                } else {
                    $this->notify(
                        $product->fullName().' currently out of stock'
                    );
                }
            }
        });

        $this->reset(['searchQuery', 'selectedProducts', 'modal']);
        $this->emit('refreshData');
        $this->emit('refresh_products');
    }

    public function render(): Factory|View|Application
    {
        $existingOrderItems = $this->credit->items()->pluck('product_id');

        return view('livewire.supplier-credits.add-product', [
            'products' => Product::query()
                ->select('id', 'name', 'sku', 'brand', 'image')
                ->with('features:id,product_id,name')
                ->whereHas(
                    'stocks',
                    fn ($query) => $query->where(
                        'sales_channel_id',
                        auth()
                            ->user()
                            ->defaultSalesChannel()->id
                    )
                )
                ->withSum(
                    [
                        'stocks as total_available' => function ($query) {
                            $query->where(
                                'sales_channel_id',
                                auth()
                                    ->user()
                                    ->defaultSalesChannel()->id
                            );
                        },
                    ],
                    'qty'
                )
                ->having('total_available', '>', 0)
                ->when(
                    $this->searchQuery,
                    fn ($query) => $query->search($this->searchQuery)
                )
                ->where('is_active', true)
                ->whereNotIn('id', $existingOrderItems)
                ->orderBy('brand')
                ->simplePaginate(10),
        ]);
    }
}
