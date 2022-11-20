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

    public function render(): Factory|View|Application
    {
        return view('livewire.products.index', [
            'products' => Product::query()
                ->with([
                    'stocks:id,product_id,qty,type',
                    'features:id,product_id,name',
                ])
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
