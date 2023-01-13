<?php

namespace App\Http\Livewire\Credit;

use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\UpdateCustomerRunningBalanceJob;
use App\Models\Credit;
use App\Models\CreditItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use LaravelIdea\Helper\App\Models\_IH_Customer_C;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;
    use WithNotifications;

    public $showConfirmModal = false;

    public $searchQuery;

    public $customerId;

    public $credit;

    public $selectedProducts = [];

    public $selectedProductsToDelete = [];

    public $products = [];

    public $sku;

    public $defaultSalesChannel;

    protected $listeners = ['refreshData' => '$refresh'];

    public function mount()
    {
        $this->customerId = request('id');

        $this->defaultSalesChannel = auth()
            ->user()
            ->defaultSalesChannel()->id;

        $this->credit = Credit::firstOrCreate(
            [
                'customer_id' => $this->customer->id,
                'processed_at' => null,
            ],
            [
                'created_by' => auth()->user()->name,
                'sales_channel_id' => $this->defaultSalesChannel,
            ]
        );
    }

    public function removeProducts()
    {
        foreach ($this->selectedProductsToDelete as $selectedItem) {
            $item = CreditItem::findOrFail($selectedItem);
            $this->deleteItem($item);
        }

        $this->selectedProductsToDelete = [];
        $this->emitSelf('refreshData');
        $this->notify('Products removed');
    }

    public function updatedSku()
    {
        $this->validate(['sku' => 'required']);

        $product = Product::where('sku', '=', $this->sku)->first();

        if (! $product) {
            return;
        }

        $this->credit->addItem($product);
        $this->notify('Product added');

        $this->sku = '';
        $this->emit('refreshData');
    }

    public function updatedSearchQuery()
    {
        $this->showProductSelectorForm = true;
        if (strlen($this->searchQuery) > 0) {
            $this->products = Product::query()
                ->search($this->searchQuery)
                ->get();
        } else {
            $this->products = [];
        }
    }

    public function updatePrice(CreditItem $item, $value)
    {
        if ($value == '' || $value <= 0) {
            $this->notify('Please enter a valid price');

            return;
        }

        $item->update(['price' => $value]);

        $this->emitSelf('refreshData');

        $this->notify('Price updated');
    }

    public function updateQty(CreditItem $item, $value)
    {
        if ($value == '' || $value <= 0) {
            $this->notify('Please enter a valid qty');

            return;
        }

        $item->update(['qty' => $value]);

        $this->emitSelf('refreshData');

        $this->notify('Qty updated');
    }

    public function deleteItem(CreditItem $item)
    {
        $item->delete();

        $this->emitSelf('refreshData');
        $this->notify('Item deleted');
    }

    public function process()
    {
        $this->showConfirmModal = false;
        $this->notify('Processing');

        $this->credit->update([
            'salesperson_id' => $this->credit->customer->salesperson_id,
            'processed_at' => now(),
            'sales_channel_id' => $this->defaultSalesChannel,
        ]);

        $this->credit->increaseStock();

        $this->customer->createCredit($this->credit, $this->credit->number);

        UpdateCustomerRunningBalanceJob::dispatch(
            $this->credit->customer_id
        )->delay(3);

        $this->notify('processed');

        $this->redirect("/customers/show/$this->customerId");
    }

    public function cancel()
    {
        foreach ($this->credit->items as $item) {
            $item->delete();
        }

        $this->credit->cancel();
        $this->notify('Credit note deleted');

        $this->redirect("/customers/show/{$this->customer->id}");
    }

    public function getCustomerProperty(): Customer|_IH_Customer_C|array|null
    {
        return Customer::find($this->customerId);
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.credit.create');
    }
}
