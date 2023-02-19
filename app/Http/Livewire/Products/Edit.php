<?php

namespace App\Http\Livewire\Products;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Feature;
use App\Models\FeatureCategory;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    use WithNotifications;

    public $slide = false;

    public $brands;

    public $categories;

    public $featureCategories;

    public $productCollections;

    public $image;

    public $images = [];

    public $product;

    public $name;

    public $sku;

    public $brand;

    public $category;

    public $product_collection_id;

    public $description;

    public $retail_price;

    public $wholesale_price;

    protected $listeners = ['updateFormData'];

    public function rules()
    {
        return [
            'product.name' => ['required'],
            'product.sku' => ['required'],
            'product.brand' => ['required'],
            'product.category' => ['required'],
            'product.product_collection_id' => ['sometimes'],
            'product.description' => ['sometimes'],
            'product.retail_price' => ['sometimes'],
            'product.wholesale_price' => ['sometimes'],
        ];
    }

    public function mount()
    {
        $this->product = Product::with([
            'features.category',
            'images',
            'stocks',
        ])
            ->where('id', request('id'))
            ->firstOrFail();
        $this->updateFormData();
    }

    public function updateFormData()
    {
        $this->brands = Brand::query()
            ->orderBy('name')
            ->get();

        $this->categories = Category::query()
            ->orderBy('name')
            ->get();

        $this->featureCategories = FeatureCategory::orderBy('name')->get();

        $this->productCollections = ProductCollection::orderBy('name')->get();
    }

    public function update()
    {
        $this->product->save();

        $this->reset([
            'name',
            'sku',
            'brand',
            'category',
            'product_collection_id',
            'description',
            'retail_price',
            'wholesale_price',
            'slide',
        ]);

        $this->notify('Product update');
    }

    public function updatedRetailPrice()
    {
        $this->product->retail_price = $this->retail_price;
        $this->product->old_retail_price = $this->product->retail_price;
        $this->product->save();
        $this->product->old_wholesale_price = $this->product->wholesale_price;
    }

    public function updatedWholesalePrice()
    {
        $this->product->wholesale_price = $this->wholesale_price;
        $this->product->old_wholesale_price = $this->product->wholesale_price;
        $this->product->save();
    }

    public function updatedDescription()
    {
        $this->product->description = $this->description;
        $this->product->save();
    }

    public function addFeature($categoryId)
    {
        if ($categoryId != '') {
            $this->product->features()->create([
                'feature_category_id' => $categoryId,
            ]);
            $this->product->unsetRelation('features');
            $this->product->load('features');

            $this->notify('Feature created');
        }
    }

    public function updateFeature(Feature $feature, $name)
    {
        $feature->update(['name' => $name]);
        $this->notify('Feature updated');
    }

    public function deleteFeature(Feature $feature)
    {
        $feature->delete();
        $this->product->unsetRelation('features');
        $this->product->load('features');
        $this->notify('Feature deleted');
    }

    public function saveGallery()
    {
        $this->validate([
            'images.*' => 'image|max:1024|sometimes',
        ]);

        foreach ($this->images as $image) {
            $this->product->images()->create([
                'url' => $image->store(
                    config('app.storage_folder').'/uploads',
                    'public'
                ),
            ]);
        }

        $this->reset(['image', 'images']);

        $this->product->unsetRelation('images');

        $this->product->load('images');

        $this->notify('Images uploaded');
    }

    public function saveFeaturedImage()
    {
        $this->validate([
            'image' => 'image|max:1024|sometimes',
        ]);

        $this->product->update([
            'image' => $this->image->store(
                config('app.storage_folder').'/uploads',
                'public'
            ),
        ]);

        $this->reset(['image', 'images']);

        $this->product->unsetRelation('images');

        $this->product->load('images');

        $this->notify('Image saved');
    }

    public function deleteFeaturedImage()
    {
        Storage::disk('public')->delete($this->product->image);
        $this->product->update(['image' => null]);
        $this->product->load('images');
        $this->notify('Image deleted');
    }

    public function deleteImage($imageId)
    {
        $image = Image::find($imageId);
        Storage::disk('public')->delete($image->url);
        $image->delete();
        $this->product->load('images');
        $this->notify('Image deleted');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.products.edit');
    }
}
