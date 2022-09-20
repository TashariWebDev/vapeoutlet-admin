<?php

namespace App\Http\Livewire\Returns;

use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\UpdateSupplierRunningBalanceJob;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierCredit;
use App\Models\SupplierCreditItem;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use LaravelIdea\Helper\App\Models\_IH_Supplier_C;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;
    use WithNotifications;

    public $showProductSelectorForm = false;

    public $showConfirmModal = false;

    public $searchQuery;

    public $supplierId;

    public $credit;

    public $selectedProducts = [];

    public function mount()
    {
        $this->supplierId = request("id");
        $this->credit = SupplierCredit::firstOrCreate(
            [
                "supplier_id" => $this->supplier->id,
                "processed_at" => null,
            ],
            [
                "created_by" => auth()->user()->name,
            ]
        );
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
            $this->credit->addItem(
                Product::find($product),
                $this->credit->supplier
            );
        }

        $this->showProductSelectorForm = false;
        $this->reset(["searchQuery"]);
        $this->selectedProducts = [];

        $this->notify("Products added");
        $this->redirect("/supplier-credits/{$this->supplierId}");
    }

    public function updatePrice(SupplierCreditItem $item, $value)
    {
        $item->update(["cost" => $value]);
        $this->notify("Price updated");
        $this->redirect("/supplier-credits/{$this->supplierId}");
    }

    public function updateQty(SupplierCreditItem $item, $value)
    {
        if ($value > $item->product->qty()) {
            $this->notify("We only have {$item->product->qty()} in stock");
            return back();
        }

        $item->update(["qty" => $value]);
        $this->notify("Qty updated");
        $this->redirect("/supplier-credits/{$this->supplierId}");
    }

    public function deleteItem(SupplierCreditItem $item)
    {
        $item->delete();
        $this->notify("Item deleted");

        $this->redirect("/supplier-credits/{$this->supplierId}");
    }

    public function process()
    {
        $this->showConfirmModal = false;
        $this->notify("Processing");

        DB::transaction(function () {
            $this->credit->decreaseStock();

            $this->credit->updateStatus("processed_at");

            $this->supplier->createCredit($this->credit, $this->credit->number);
        }, 3);

        UpdateSupplierRunningBalanceJob::dispatch(
            $this->credit->supplier_id
        )->delay(3);

        $this->notify("processed");

        $this->redirect("/inventory/suppliers/{$this->supplierId}");
    }

    public function cancel()
    {
        foreach ($this->credit->items as $item) {
            $item->delete();
        }

        $this->credit->cancel();
        $this->notify("Purchase deleted");

        $this->redirect("/suppliers/show/{$this->supplier->id}");
    }

    public function getSupplierProperty(): _IH_Supplier_C|array|Supplier|null
    {
        return Supplier::find($this->supplierId);
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.returns.create", [
            "products" => Product::query()
                ->inStock()
                ->with("features")
                ->when($this->searchQuery, function ($query) {
                    $query->search($this->searchQuery);
                })
                ->simplePaginate(6),
        ]);
    }
}
