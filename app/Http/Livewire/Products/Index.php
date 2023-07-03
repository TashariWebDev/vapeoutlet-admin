<?php

namespace App\Http\Livewire\Products;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use LaravelIdea\Helper\App\Models\_IH_Product_QB;
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

    public string $brandQuery = '';

    protected $listeners = ['refresh' => '$refresh'];

    protected $queryString = ['recordCount', 'searchQuery' => ['except' => ''], 'brandQuery' => ['except' => '']];

    public function mount(): void
    {
        if (request()->has('searchQuery')) {
            $this->searchQuery = request('searchQuery');
        }

        if (request()->has('brandQuery')) {
            $this->brandQuery = request('brandQuery');
        }

        if (request()->has('recordCount')) {
            $this->recordCount = request('recordCount');
        }
    }

    public function updatedSearchQuery(): void
    {
        $this->resetPage();
    }

    public function updatedBrandQuery(): void
    {
        $this->resetPage();
    }

    public function toggleFilter(): void
    {
        $this->activeFilter = ! $this->activeFilter;
        $this->resetPage();
    }

    public function toggleActive(Product $product): void
    {
        $product->is_active = ! $product->is_active;
        $product->save();
        $this->notify('Product active status updated');
    }

    public function toggleFeatured(Product $product): void
    {
        $product->is_featured = ! $product->is_featured;
        $product->save();
        $this->notify('Product featured status updated');
    }

    public function toggleSale(Product $product): void
    {
        $product->is_sale = ! $product->is_sale;
        $product->save();
        $this->notify('Product sale status updated');
    }

    public function delete(Product $product): void
    {
        $product->update([
            'is_active' => false,
        ]);

        $product->delete();

        $this->notify('Product disabled & archived');
    }

    public function updateRetailPrice(Product $product, $value): void
    {
        $product->update(['retail_price' => $value]);
        $this->notify('price updated');
    }

    public function updateWholesalePrice(Product $product, $value): void
    {
        $product->update(['wholesale_price' => $value]);
        $this->notify('price updated');
    }

    public function recover($productId): void
    {
        Product::withTrashed()
            ->find($productId)
            ->restore();

        $this->notify('product restored');
    }

    public function getProducts(): _IH_Product_QB|Builder
    {
        $products = Product::select([
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
            'products.image',
        ])
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
                        $query->where('type', 'supplier credit');
                    },
                    'stocks as total_adjustments' => function ($query) {
                        $query->where('type', 'adjustment');
                    },
                ],
                'qty'
            );

        $products->when(
            $this->brandQuery,
            fn ($query) => $query->where('brand', '=', $this->brandQuery)
        );

        $products->when(
            $this->searchQuery,
            fn ($query) => $query->search($this->searchQuery)
        );

        return $products;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.products.index', [
            'products' => $this->getProducts()
                ->where('is_active', $this->activeFilter)
                ->when(! $this->activeFilter, function ($query) {
                    $query->withTrashed();
                })
                ->orderByRaw('brand')
                ->paginate($this->recordCount),
            'brands' => Brand::orderBy('name')
                ->get()
                ->unique('name')
                ->pluck('name'),
        ]);
    }
}
