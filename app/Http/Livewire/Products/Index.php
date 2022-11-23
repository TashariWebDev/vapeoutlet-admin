<?php

namespace App\Http\Livewire\Products;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;
    use WithNotifications;

    public $activeFilter = true;

    public $recordCount = 10;

    public string $searchQuery = '';

    protected $listeners = ['refresh' => '$refresh'];

    protected $queryString = ['recordCount', 'searchQuery' => ['except' => '']];

    public function mount()
    {
        if (request()->has('searchQuery')) {
            $this->searchQuery = request('searchQuery');
        }

        if (request()->has('recordCount')) {
            $this->recordCount = request('recordCount');
        }
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function toggleFilter()
    {
        $this->activeFilter = ! $this->activeFilter;
        $this->resetPage();
    }

    public function toggleActive(Product $product)
    {
        $product->is_active = ! $product->is_active;
        $product->save();
        $this->notify('Product active status updated');
    }

    public function toggleFeatured(Product $product)
    {
        $product->is_featured = ! $product->is_featured;
        $product->save();
        $this->notify('Product featured status updated');
    }

    public function toggleSale(Product $product)
    {
        $product->is_sale = ! $product->is_sale;
        $product->save();
        $this->notify('Product sale status updated');
    }

    public function delete(Product $product)
    {
        $product->delete();
        $this->notify('Product archived');
    }

    public function updateRetailPrice(Product $product, $value)
    {
        $product->update(['retail_price' => $value]);
        $this->notify('price updated');
    }

    public function updateWholesalePrice(Product $product, $value)
    {
        $product->update(['wholesale_price' => $value]);
        $this->notify('price updated');
    }

    public function getProductsProperty()
    {
        return Product::select(
            'products.id',
            'products.name',
            'products.brand',
            'products.category',
            'products.sku',
            'products.retail_price',
            'products.wholesale_price',
            'products.cost',
            'products.is_active',
            'products.is_featured',
            'products.is_sale',
            'products.deleted_at',
            'products.image'
        )
            ->with(['features:id,product_id,name', 'lastPurchasePrice'])
            ->withSum(
                [
                    'stocks as total_available',
                    'stocks as total_sold' => function ($query) {
                        $query->where('type', 'invoice');
                    },
                    'stocks as total_purchases' => function ($query) {
                        $query->where('type', 'purchase');
                    },
                    'stocks as total_credits' => function ($query) {
                        $query->where('type', 'credit');
                    },
                    'stocks as total_supplier_credits' => function ($query) {
                        $query->where('type', 'supplier_credit');
                    },
                    'stocks as total_adjustments' => function ($query) {
                        $query->where('type', 'adjustment');
                    },
                ],
                'qty'
            );
        //
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.products.index', [
            'products' => $this->products
                ->when(
                    $this->searchQuery,
                    fn ($query) => $query->search($this->searchQuery)
                )
                ->where('is_active', $this->activeFilter)
                ->orderByRaw('brand')
                ->paginate($this->recordCount),
        ]);
    }
}
