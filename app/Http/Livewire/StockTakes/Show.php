<?php

namespace App\Http\Livewire\StockTakes;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Stock;
use App\Models\StockTake;
use App\Models\StockTakeItem;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    use WithNotifications;

    public $showConfirmModal;
    public $stockTakeId;
    public $count;

    public function mount()
    {
        $this->stockTakeId = request("id");
    }

    public function updateItem(StockTakeItem $item, $count)
    {
        if ($count != "" && $count < 0) {
            $item->update([
                "count" => null,
                "variance" => 0,
            ]);
            $this->notify("qty cannot be negative");
            return;
        }

        if ($count == "") {
            $item->update([
                "count" => null,
                "variance" => 0,
            ]);
            $this->notify("item will be excluded from stock count");
            return;
        } else {
            $item->update([
                "count" => $count,
                "variance" => $count - $item->product->qty(),
            ]);
        }

        $this->notify("updated");
    }

    public function process()
    {
        $this->notify("processing");

        DB::transaction(function () {
            $stockTake = StockTake::with("items.product.features")
                ->where("id", "=", $this->stockTakeId)
                ->first();

            foreach ($stockTake->items as $item) {
                if ($item->count < 0) {
                    $this->showConfirmModal = false;
                    $this->notify("qty cannot be negative");
                    return;
                }

                if ($item->variance != 0) {
                    Stock::create([
                        "product_id" => $item->product->id,
                        "type" => "adjustment",
                        "reference" => "ST00" . $stockTake->id,
                        "qty" => $item->variance,
                        "cost" => $item->product->cost,
                    ]);
                }
            }

            $stockTake->update([
                "processed_at" => now(),
                "processed_by" => auth()->user()->name,
            ]);
        });
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.stock-takes.show", [
            "stockTake" => StockTake::with("items.product.features")
                ->where("id", "=", $this->stockTakeId)
                ->first(),
        ]);
    }
}
