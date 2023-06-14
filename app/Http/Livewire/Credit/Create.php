<?php

namespace App\Http\Livewire\Credit;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Credit;
use App\Models\CreditItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;
    use WithNotifications;

    public $showConfirmModal = false;

    public Customer $customer;

    public $credit;

    public $sku;

    public $selectedProductsToDelete = [];

    protected $listeners = ['refreshData' => '$refresh'];

    public function mount(): void
    {
        $this->credit = Credit::firstOrCreate(
            [
                'customer_id' => $this->customer->id,
                'processed_at' => null,
            ],
            [
                'created_by' => auth()->user()->name,
                'sales_channel_id' => auth()
                    ->user()
                    ->defaultSalesChannel()->id,
            ]
        );
    }

    public function hydrate(): void
    {
        $this->emitSelf('refreshData');
    }

    public function removeProducts(): void
    {
        CreditItem::destroy($this->selectedProductsToDelete);

        $this->selectedProductsToDelete = [];
        $this->notify('Products removed');
    }

    public function updatedSku(): void
    {
        $this->validate(['sku' => 'required']);

        $product = Product::where('sku', '=', $this->sku)->first();

        if (! $product) {
            return;
        }

        $this->credit->addItem($product);
        $this->notify('Product added');

        $this->sku = '';
    }

    public function updatePrice(CreditItem $item, $value): void
    {
        if ($value == '' || $value <= 0) {
            $this->notify('Please enter a valid price');

            return;
        }

        $item->update(['price' => $value]);

        $this->notify('Price updated');
    }

    public function updateQty(CreditItem $item, $value): void
    {
        if ($value == '' || $value <= 0) {
            $this->notify('Please enter a valid qty');

            return;
        }

        $item->update(['qty' => $value]);

        $this->notify('Qty updated');
    }

    public function deleteItem(CreditItem $item): void
    {
        $item->delete();

        $this->notify('Item deleted');
    }

    public function process()
    {
        $this->showConfirmModal = false;

        $this->credit->update([
            'processed_at' => now(),
            'salesperson_id' => $this->credit->customer->salesperson_id,
        ]);

        $this->credit->increaseStock();

        $this->customer->createCredit($this->credit, $this->credit->number);

        return redirect("/customers/show/{$this->customer->id}");
    }

    public function cancel()
    {
        $this->credit->delete();

        return redirect("/customers/show/{$this->customer->id}");
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.credit.create');
    }
}
