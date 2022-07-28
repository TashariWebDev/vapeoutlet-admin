<?php

namespace App\Http\Livewire\Purchases;

use App\Mail\ContactFormMail;
use App\Mail\StockAlertMail;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Stock;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;

    public $searchQuery = '';
    public $selectedProducts = [];
    public $purchaseId;

    public $showProductSelectorForm = false;
    public $showConfirmModal = false;

    public function mount()
    {
        $this->purchaseId = request('id');
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
        $purchase = Purchase::find($this->purchaseId);

        foreach ($this->selectedProducts as $product) {
            $purchase->items()->updateOrCreate([
                'product_id' => $product,
            ], [
                'product_id' => $product,
            ]);
        }

        $this->showProductSelectorForm = false;
        $this->reset(['searchQuery']);
        $this->selectedProducts = [];

        $this->dispatchBrowserEvent('notification', ['body' => 'Products added']);
    }

    public function updatePrice(PurchaseItem $item, $value)
    {
        $item->update(['price' => $value]);

        $this->dispatchBrowserEvent('notification', ['body' => 'Price updated']);
    }

    public function updateQty(PurchaseItem $item, $value)
    {
        $item->update(['qty' => $value]);

        $this->dispatchBrowserEvent('notification', ['body' => 'Qty updated']);
    }

    public function deleteItem(PurchaseItem $item)
    {
        $item->delete();

        $this->dispatchBrowserEvent('notification', ['body' => 'Item deleted']);
    }

    public function process()
    {
        $this->showConfirmModal = false;
        $purchase = Purchase::find($this->purchaseId);

        $this->dispatchBrowserEvent('notification', ['body' => 'Processing']);

        foreach ($purchase->items as $item) {
            Stock::create([
                'product_id' => $item->product_id,
                'type' => 'purchase',
                'reference' => $purchase->invoice_no,
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

        $purchase->update(['processed_date' => today()]);


        $this->dispatchBrowserEvent('notification', ['body' => 'Processed']);

        $this->redirectRoute('inventory');
    }

    public function cancel()
    {
        $purchase = Purchase::find($this->purchaseId);

        foreach ($purchase->items as $item) {
            $item->delete();
        }

        $purchase->delete();

        $this->dispatchBrowserEvent('notification', ['body' => 'Purchase deleted']);

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

            'purchase' => Purchase::where('id', $this->purchaseId)
                ->first(),
        ]);
    }
}
