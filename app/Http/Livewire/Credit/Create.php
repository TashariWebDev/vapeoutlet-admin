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
use Illuminate\Support\Facades\DB;
use LaravelIdea\Helper\App\Models\_IH_Customer_C;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;
    use WithNotifications;

    public $showProductSelectorForm = false;

    public $showConfirmModal = false;

    public $searchQuery;

    public $customerId;

    public $credit;

    public $selectedProducts = [];

    public $products = [];

    public function mount()
    {
        $this->customerId = request("id");
        $this->credit = Credit::firstOrCreate(
            [
                "customer_id" => $this->customer->id,
                "processed_at" => null,
            ],
            [
                "created_by" => auth()->user()->name,
            ]
        );
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

    public function addProducts()
    {
        foreach ($this->selectedProducts as $product) {
            $this->credit->addItem(
                Product::find($product),
                $this->credit->customer
            );
        }

        $this->showProductSelectorForm = false;
        $this->reset(["searchQuery"]);
        $this->selectedProducts = [];

        $this->notify("Products added");
        $this->redirect("/credits/{$this->customerId}");
    }

    public function updatePrice(CreditItem $item, $value)
    {
        $item->update(["price" => $value]);
        $this->notify("Price updated");
    }

    public function updateQty(CreditItem $item, $value)
    {
        $item->update(["qty" => $value]);
        $this->notify("Qty updated");
    }

    public function deleteItem(CreditItem $item)
    {
        $item->delete();
        $this->notify("Item deleted");

        $this->redirect("/credits/{$this->customerId}");
    }

    public function process()
    {
        sleep(1);
        $this->showConfirmModal = false;
        $this->notify("Processing");

        DB::transaction(function () {
            $this->credit->update([
                "salesperson_id" => $this->credit->customer->salesperson_id,
            ]);
            $this->credit->increaseStock();

            $this->credit->updateStatus("processed_at");

            $this->customer->createCredit($this->credit, $this->credit->number);
        }, 3);

        UpdateCustomerRunningBalanceJob::dispatch(
            $this->credit->customer_id
        )->delay(3);

        $this->notify("processed");

        $this->redirect("/customers/show/{$this->customerId}");
    }

    public function cancel()
    {
        foreach ($this->credit->items as $item) {
            $item->delete();
        }

        $this->credit->cancel();
        $this->notify("Purchase deleted");

        $this->redirect("/customers/show/{$this->customer->id}");
    }

    public function getCustomerProperty(): Customer|_IH_Customer_C|array|null
    {
        return Customer::find($this->customerId);
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.credit.create");
    }
}
