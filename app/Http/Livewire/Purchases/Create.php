<?php

namespace App\Http\Livewire\Purchases;

use App\Http\Livewire\Traits\WithNotifications;
use App\Mail\StockAlertMail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Feature;
use App\Models\FeatureCategory;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Stock;
use App\Models\SupplierTransaction;
use Artisan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Str;

class Create extends Component
{
    use WithPagination;
    use WithNotifications;
    use WithFileUploads;

    public $searchQuery = '';
    public $selectedProducts = [];
    public $purchaseId;

    public bool $showProductCreateForm = false;
    public bool $showProductUpdateForm = false;
    public bool $showBrandsForm = false;
    public bool $showCategoriesForm = false;
    public bool $showFeaturesForm = false;
    public bool $showProductCollectionForm = false;

    public $product;
    public $productId;
    public $featureCategories = [];
    public $brands = [];
    public $categories = [];
    public $productCollections = [];
    public $collectionName = '';
    public $brandName = '';
    public $brandLogo = '';
    public $categoryName = '';
    public $featureCategoryName = '';
    public $featureName = '';
    public string $feature_id = '';

    public $showProductSelectorForm = false;
    public $showConfirmModal = false;

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
        $this->product->refresh();
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

    public function update()
    {
        $this->validate();
        $this->product->save();
        $this->notify('Product saved');
        $this->showProductUpdateForm = false;
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
        $this->notify('Brand created');
    }

    public function addCategory()
    {
        Category::create([
            'name' => strtolower($this->categoryName),
        ]);

        $this->reset(['categoryName', 'showCategoriesForm']);
        $this->categories = Category::orderBy('name')->get();

        $this->notify('Category created');
    }

    public function addProductCollection()
    {
        ProductCollection::create([
            'name' => strtolower($this->collectionName),
        ]);

        $this->reset(['collectionName', 'showProductCollectionForm']);
        $this->productCollections = ProductCollection::query()->orderBy('name')->get();

        $this->notify('Product collection created');
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

        $this->notify('Feature category created');
    }

    public function addFeature($categoryId)
    {
        $this->product->features()->create([
            'feature_category_id' => $categoryId
        ]);
        $this->product->unsetRelation('features');
        $this->product->load('features');

        $this->notify('Feature created');
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

    public function mount()
    {
        $this->purchaseId = request('id');
    }

    public function getPurchaseProperty()
    {
        return Purchase::find($this->purchaseId)->load('items', 'supplier');
    }

    public function updatingSearchQuery()
    {
        if (strlen($this->searchQuery) > -1) {
            $this->showProductSelectorForm = true;
            $this->resetPage();
        }
    }

    public function addProducts()
    {
        foreach ($this->selectedProducts as $product) {
            $this->purchase->items()->updateOrCreate([
                'product_id' => $product,
            ], [
                'product_id' => $product,
            ]);
        }

        $this->showProductSelectorForm = false;
        $this->reset(['searchQuery']);
        $this->selectedProducts = [];

        $this->notify('Products added');
        $this->purchase->refresh();
    }

    public function updatePrice(PurchaseItem $item, $value)
    {
        $item->update(['price' => $value]);
        $this->notify('Price updated');
    }

    public function updateQty(PurchaseItem $item, $value)
    {
        $item->update(['qty' => $value]);
        $this->notify('Qty updated');
    }

    public function deleteItem(PurchaseItem $item)
    {
        $item->delete();
        $this->notify('Item deleted');

    }

    public function process()
    {
        $this->showConfirmModal = false;
        $this->notify('Processing');


        foreach ($this->purchase->items as $item) {
            Stock::create([
                'product_id' => $item->product_id,
                'type' => 'purchase',
                'reference' => $this->purchase->invoice_no,
                'qty' => $item->qty,
                'cost' => $item->total_cost_in_zar(),
            ]);

            $productCost = $item->product->cost;

            if ($productCost > 0) {
                $cost = (($item->total_cost_in_zar() + $productCost) / 2);
            } else {
                $cost = $item->total_cost_in_zar();
            }

            $item->product()->update([
                'cost' => to_cents($cost)
            ]);

            $alerts = $item->product->stockAlerts()->get();

            foreach ($alerts as $alert) {
                Mail::to($alert->email)->later(
                    now()->addMinutes(1),
                    new StockAlertMail($item->product)
                );

                $alert->delete();
            }
        }

        $this->purchase->update(['processed_date' => today()]);

        SupplierTransaction::create([
            'uuid' => Str::uuid(),
            'reference' => $this->purchase->invoice_no,
            'supplier_id' => $this->purchase->supplier_id,
            'amount' => $this->purchase->amount_converted_to_zar(),
            'type' => 'purchase',
            'running_balance' => 0,
            'created_by' => auth()->user()->name
        ]);

        Artisan::call('update:supplier-transactions', [
            'supplier' => $this->purchase->supplier_id
        ]);


        $this->notify('processed');

    }

    public function cancel()
    {
        foreach ($this->purchase->items as $item) {
            $item->delete();
        }

        $this->purchase->delete();
        $this->notify('Purchase deleted');

        $this->redirectRoute('inventory');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.purchases.create', [
            'products' => Product::query()
                ->with('features')
                ->when($this->searchQuery, function ($query) {
                    $query->search($this->searchQuery);
                })
                ->orderBy('brand')
                ->simplePaginate(6),
        ]);
    }
}
