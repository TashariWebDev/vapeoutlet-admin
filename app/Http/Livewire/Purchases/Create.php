<?php

namespace App\Http\Livewire\Purchases;

use App\Http\Livewire\Traits\WithNotifications;
use App\Mail\ContactFormMail;
use App\Mail\StockAlertMail;
use App\Models\Product;
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
use Livewire\WithPagination;
use Str;

class Create extends Component
{
    use WithPagination;
    use WithNotifications;

    public $searchQuery = '';
    public $selectedProducts = [];
    public $purchaseId;

    public $showProductSelectorForm = false;
    public $showConfirmModal = false;

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
        $this->redirect("/inventory/purchases/{$this->purchaseId}");
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
            'amount' => $this->purchase->total_cost_in_zar(),
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
                ->when($this->searchQuery, function ($query) {
                    $query->search($this->searchQuery);
                })
                ->orderBy('brand')
                ->simplePaginate(6),
        ]);
    }
}
