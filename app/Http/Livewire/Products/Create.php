<?php

namespace App\Http\Livewire\Products;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Feature;
use App\Models\FeatureCategory;
use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    use WithNotifications;

    public $slide = false;

    public $brands = [];

    public $categories = [];

    public $featureCategories = [];

    public $productCollections = [];

    public $product;

    public $name;

    public $sku;

    public $brand;

    public $category;

    public $product_collection_id;

    public $description;

    public $retail_price;

    public $wholesale_price;

    protected $listeners = ['updateFormData', 'refreshData' => '$refresh'];

    public function updatedSlide()
    {
        if ($this->slide = true) {
            $this->updateFormData();
        } else {
            $this->emitSelf('refreshData');

            $this->reset([
                'brands',
                'categories',
                'featureCategories',
                'productCollections',
            ]);
        }
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

    public function save()
    {
        $validatedData = $this->validate([
            'name' => ['required'],
            'sku' => ['required'],
            'brand' => ['required'],
            'category' => ['required'],
            'product_collection_id' => ['sometimes'],
            'description' => ['sometimes'],
            'retail_price' => ['sometimes'],
            'wholesale_price' => ['sometimes'],
        ]);
        $product = Product::create($validatedData);
        $this->product = $product;

        $this->notify('Product created');
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
            'product',
        ]);

        $this->notify('Product saved');
    }

    public function updatedRetailPrice()
    {
        $this->product->old_retail_price = $this->product->retail_price;
        $this->product->retail_price = $this->retail_price;
        $this->product->save();
    }

    public function updatedWholesalePrice()
    {
        $this->product->old_wholesale_price = $this->product->wholesale_price;
        $this->product->wholesale_price = $this->wholesale_price;
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
            $this->product->load('features');
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
        $this->product->load('features');
        $this->notify('Feature deleted');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.products.create');
    }
}
