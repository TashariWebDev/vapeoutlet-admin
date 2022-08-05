<?php

namespace App\Http\Livewire\Products;

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
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public bool $activeFilter = true;
    public string $searchQuery = '';

    public bool $showProductCreateForm = false;
    public bool $showProductUpdateForm = false;
    public bool $showBrandsForm = false;
    public bool $showCategoriesForm = false;
    public bool $showFeaturesForm = false;
    public bool $showProductCollectionForm = false;
    public bool $showGalleryForm = false;

    public $product;
    public $productId;
    public $featureCategories = [];
    public $brands = [];
    public $categories = [];
    public $productCollections = [];
    public $image;
    public $images = [];

    public $collectionName = '';
    public $brandName = '';
    public $brandLogo = '';
    public $categoryName = '';
    public $featureCategoryName = '';
    public $featureName = '';

    public string $feature_id = '';
    public $iteration = 1;

    public function rules(): array
    {
        return [
            'feature_id' => ['required|int'],
            'product.name' => ['required'],
            'product.sku' => ['required'],
            'product.brand' => ['required'],
            'product.category' => ['required'],
            'product.description' => ['sometimes'],
            'product.retail_price' => ['sometimes'],
//            'product.old_retail_price' => ['sometimes'],
            'product.wholesale_price' => ['sometimes'],
//            'product.old_wholesale_price' => ['sometimes'],
            'product.product_collection_id' => ['sometimes'],
        ];
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->product = new Product();
        $this->brands = Brand::query()->orderBy('name')->get();
        $this->categories = Category::query()->orderBy('name')->get();
        $this->featureCategories = FeatureCategory::orderBy('name')->get();
        $this->productCollections = ProductCollection::orderBy('name')->get();
        $this->showProductCreateForm = true;
    }

    public function save()
    {
        $this->validate();
        $this->product->old_retail_price = $this->product->retail_price;
        $this->product->old_wholesale_price = $this->product->wholesale_price;
        $this->product->save();
        $this->reset(['product']);
        $this->create();
        $this->dispatchBrowserEvent('notification', ['body' => 'Product saved']);
    }

    public function saveAndEdit()
    {
        $this->validate();
        $this->product->old_retail_price = $this->product->retail_price;
        $this->product->old_wholesale_price = $this->product->wholesale_price;
        $this->product->save();
        $this->showProductCreateForm = false;
        $this->edit($this->product->id);
    }

    public function edit($productId)
    {
        $this->product = Product::find($productId);
        $this->retailPrice = $this->product->retail_price;
        $this->wholesalePrice = $this->product->wholesale_price;
        $this->brands = Brand::query()->orderBy('name')->get();
        $this->categories = Category::query()->orderBy('name')->get();
        $this->featureCategories = FeatureCategory::orderBy('name')->get();
        $this->productCollections = ProductCollection::orderBy('name')->get();
        $this->product->refresh();
        $this->showProductUpdateForm = true;
    }

    public function clearActiveProduct()
    {
        $this->reset(['product', 'brandName', 'categoryName', 'collectionName', 'product.name', 'product.sku']);
        $this->resetValidation();
        $this->product = new Product();
    }

    public function update()
    {
        $this->validate();
        $this->product->save();
        $this->dispatchBrowserEvent('notification', ['body' => 'Product saved']);
        $this->showProductUpdateForm = false;
    }


    public function toggleActive($productId)
    {
        $product = Product::find($productId);
        $product->is_active = !$product->is_active;
        $product->save();

        $this->dispatchBrowserEvent('notification', ['body' => 'Product active status updated']);
    }

    public function toggleFeatured($productId)
    {
        $product = Product::find($productId);
        $product->is_featured = !$product->is_featured;
        $product->save();

        $this->dispatchBrowserEvent('notification', ['body' => 'Product featured status updated']);
    }

    public function toggleSale($productId)
    {
        $product = Product::find($productId);
        $product->is_sale = !$product->is_sale;
        $product->save();

        $this->dispatchBrowserEvent('notification', ['body' => 'Product sale status updated']);
    }

    public function showGallery($productId)
    {
        $this->product = Product::find($productId);
        $this->product->unsetRelation('images');
        $this->product->load('images');
        $this->showGalleryForm = true;
    }

    public function saveGallery()
    {
        $this->validate([
            'images.*' => 'image|max:1024|sometimes',
        ]);

        foreach ($this->images as $image) {
            $this->product->images()->create([
                'url' => $image->store('uploads', 'public')
            ]);
        }

        $this->reset(['image', 'images']);
        $this->iteration++;
        $this->product->unsetRelation('images');
        $this->product->load('images');

        $this->dispatchBrowserEvent('notification', ['body' => 'Images uploaded']);
    }

    public function saveFeaturedImage()
    {
        $this->validate([
            'image' => 'image|max:1024|sometimes',
        ]);

        $this->product->update([
            'image' => $this->image->store('uploads', 'public')
        ]);

        $this->reset(['image', 'images']);
        $this->iteration++;
        $this->product->unsetRelation('images');
        $this->product->load('images');

        $this->dispatchBrowserEvent('notification', ['body' => 'Image saved']);
    }

    public function deleteFeaturedImage()
    {
        Storage::disk('public')->delete($this->product->image);
        $this->product->update(['image' => null]);
        $this->product->load('images');

        $this->dispatchBrowserEvent('notification', ['body' => 'Image deleted']);
    }

    public function deleteImage($imageId)
    {
        $image = Image::find($imageId);
        Storage::disk('public')->delete($image->url);
        $image->delete();
        $this->product->load('images');

        $this->dispatchBrowserEvent('notification', ['body' => 'Image deleted']);
    }

    public function addBrand()
    {
        $this->validate([
            'brandName' => ['unique:brands,name'],
            'brandLogo' => ['image', 'max:1024']
        ]);

        Brand::create([
            'name' => strtolower($this->brandName),
            'image' => $this->brandLogo->store('uploads', 'public')
        ]);

        $this->reset(['brandName', 'brandLogo', 'showBrandsForm']);
        $this->brands = Brand::orderBy('name')->get();

        $this->dispatchBrowserEvent('notification', ['body' => 'Brand created']);
    }

    public function addCategory()
    {
        Category::create([
            'name' => strtolower($this->categoryName),
        ]);

        $this->reset(['categoryName', 'showCategoriesForm']);
        $this->categories = Category::orderBy('name')->get();

        $this->dispatchBrowserEvent('notification', ['body' => 'Category created']);
    }

    public function addProductCollection()
    {
        ProductCollection::create([
            'name' => strtolower($this->collectionName),
        ]);

        $this->reset(['collectionName', 'showProductCollectionForm']);
        $this->productCollections = ProductCollection::query()->orderBy('name')->get();

        $this->dispatchBrowserEvent('notification', ['body' => 'Product collection created']);
    }

    public function addFeatureCategory()
    {
        $this->validate([
            'featureCategoryName' => ['required', 'unique:feature_categories,name']
        ]);

        FeatureCategory::create(['name' => $this->featureCategoryName]);

        $this->reset(['featureCategoryName']);

        $this->featureCategories = FeatureCategory::query()
            ->orderBy('name')->get();

        $this->dispatchBrowserEvent('notification', ['body' => 'Feature categorycreated']);
    }

    public function addFeature($categoryId)
    {
        $this->product->features()->create([
            'feature_category_id' => $categoryId
        ]);
        $this->product->unsetRelation('features');
        $this->product->load('features');

        $this->dispatchBrowserEvent('notification', ['body' => 'Feature created']);
    }

    public function updateFeature(Feature $feature, $name)
    {
        $feature->update(['name' => $name]);

        $this->dispatchBrowserEvent('notification', ['body' => 'Feature updated']);
    }

    public function deleteFeature(Feature $feature)
    {
        $feature->delete();
        $this->product->unsetRelation('features');
        $this->product->load('features');

        $this->dispatchBrowserEvent('notification', ['body' => 'Feature deleted']);
    }

    public function delete($productId)
    {
        Product::find($productId)->delete();

        $this->dispatchBrowserEvent('notification', ['body' => 'Product archived']);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.products.index', [
            'products' => Product::query()
                ->where('is_active', $this->activeFilter)
                ->with('features')
                ->when($this->searchQuery, fn($query) => $query->search($this->searchQuery))
                ->orderBy('brand')
                ->simplePaginate(5)
        ]);
    }
}
