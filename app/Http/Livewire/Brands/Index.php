<?php

namespace App\Http\Livewire\Brands;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Brand;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithNotifications;
    use WithPagination;
    use WithFileUploads;

    public $image;

    public $searchQuery;

    public function updateImage($brandId)
    {
        $brand = Brand::find($brandId);

        Storage::disk('public')->delete($brand->image);

        $brand->update(['image' => $this->image->store('uploads', 'public')]);

        $this->notify('brand name updated');
    }

    public function updateBrand($brandId, $name)
    {
        $brand = Brand::find($brandId);

        foreach ($brand->products as $product) {
            $product->update([
                'brand' => $name,
            ]);
        }

        $brand->update(['name' => $name]);

        $this->notify('brand name updated');
    }

    public function delete(Brand $brand)
    {
        $brand->delete();

        $this->notify('Brand deleted');
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.brands.index', [
            'brands' => Brand::query()
                ->withCount('products')
                ->orderBy('name')
                ->when($this->searchQuery, function ($query) {
                    $query->where(
                        'name',
                        'like',
                        '%'.$this->searchQuery.'%'
                    );
                })
                ->paginate(6),
        ]);
    }
}
