<?php

namespace App\Http\Livewire\Inventory;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithNotifications;

    public $searchQuery;

    public $suppliers = [];

    public $selectedSupplier;

    public $invoice_no;

    public $amount;

    public $date;

    public $exchange_rate;

    public $shipping_rate;

    public $currency = 'ZAR';

    public $name = '';

    public $email = '';

    public $phone = '';

    public $person = '';

    public $address_line_one = '';

    public $address_line_two = '';

    public $suburb = '';

    public $city = '';

    public $country = '';

    public $postal_code = '';

    public $showPurchaseCreateForm = false;

    public $showSuppliersCreateForm = false;

    public function rules(): array
    {
        return [
            'selectedSupplier' => ['required', 'integer'],
            'invoice_no' => ['required', 'unique:purchases,invoice_no'],
            'amount' => ['required'],
            'date' => ['required', 'date'],
            'shipping_rate' => ['nullable'],
            'exchange_rate' => ['nullable'],
            'currency' => ['required'],
        ];
    }

    public function mount()
    {
        if (request()->has('showPurchaseCreateForm')) {
            $this->showPurchaseCreateForm = true;
            $this->suppliers = Supplier::query()
                ->orderBy('name')
                ->get();
        }
    }

    public function updatedSearchQuery()
    {
        $this->resetPage();
    }

    public function addSupplier()
    {
        $validatedData = $this->validate([
            'name' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'person' => ['required'],
            'address_line_one' => ['required'],
            'address_line_two' => ['sometimes'],
            'suburb' => ['sometimes'],
            'city' => ['sometimes'],
            'country' => ['sometimes'],
            'postal_code' => ['sometimes'],
        ]);

        Supplier::create($validatedData);

        $this->reset([
            'name',
            'email',
            'phone',
            'person',
            'address_line_one',
            'address_line_two',
            'suburb',
            'city',
            'country',
            'postal_code',
        ]);

        $this->dispatchBrowserEvent('notification', ['body' => 'Supplier created']);
    }

    public function save()
    {
        $this->validate();

        $purchase = Purchase::create([
            'supplier_id' => $this->selectedSupplier,
            'amount' => $this->amount,
            'invoice_no' => $this->invoice_no,
            'date' => $this->date,
            'exchange_rate' => $this->exchange_rate,
            'shipping_rate' => $this->shipping_rate,
            'currency' => $this->currency,
            'creator_id' => auth()->id(),
        ]);

        $this->redirectRoute('purchases/create', [
            'id' => $purchase->id,
        ]);
    }

    public function updatedShowPurchaseCreateForm()
    {
        if ($this->showPurchaseCreateForm) {
            $this->suppliers = Supplier::query()
                ->orderBy('name')
                ->get();
        }
    }

    public function updateRetailPrice($productId, $value)
    {
        $product = Product::find($productId);
        $product->update(['retail_price' => $value]);
        $this->notify('price updated');
    }

    public function updateWholesalePrice($productId, $value)
    {
        $product = Product::find($productId);
        $product->update(['wholesale_price' => $value]);
        $this->notify('price updated');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.inventory.index', [
            'products' => Product::query()
                ->select('*',
                    DB::raw('(select SUM(qty) FROM stocks WHERE products.id = stocks.product_id) as total_available'),
                    DB::raw('(select SUM(qty) FROM stocks WHERE products.id = stocks.product_id && type = "purchase") as total_bought'),
                    DB::raw('(select SUM(qty) FROM stocks WHERE products.id = stocks.product_id && type = "invoice") as total_sold'),
                    DB::raw('(select SUM(qty) FROM stocks WHERE products.id = stocks.product_id && type = "credit") as total_returned'),
                    DB::raw('(select cost FROM stocks WHERE products.id = stocks.product_id && type = "purchase"
                    ORDER BY id DESC LIMIT 1) as last_cost')
                )
                ->with(['features'])
                ->when($this->searchQuery, fn($query) => $query->search($this->searchQuery))
                ->orderBy('brand')
                ->simplePaginate(5),
        ]);
    }
}
