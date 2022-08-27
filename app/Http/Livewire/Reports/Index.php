<?php

namespace App\Http\Livewire\Reports;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Brand;
use App\Models\Product;
use App\Models\StockTake;
use DB;
use Http;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\_IH_Brand_C;
use Livewire\Component;

class Index extends Component
{
    use WithNotifications;

    public $showStockTakeModal = false;
    public $brand;

    public function createStockTake()
    {
        $this->validate([
            "brand" => "required",
        ]);

        $this->notify("Working on it!");

        DB::transaction(function () {
            $stockTake = StockTake::create([
                "brand" => $this->brand,
                "created_by" => auth()->user()->name,
                "date" => now(),
            ]);

            $selectedProducts = Product::query()
                ->select("products.id", "products.cost")
                ->where("brand", "=", $this->brand)
                ->get();

            foreach ($selectedProducts as $product) {
                $stockTake->items()->create([
                    "product_id" => $product->id,
                    "cost" => $product->cost,
                ]);
            }
        });

        $this->reset(["brand"]);
        $this->showStockTakeModal = false;

        $this->notify("Stock take created");
        $this->redirect("stock-takes");
    }

    public function getBrandsProperty(): _IH_Brand_C|Collection|array
    {
        return Brand::all();
    }

    public function getDebtorListDocument()
    {
        Http::get(config("app.admin_url") . "/webhook/documents/debtor-list");

        $this->redirect("reports");
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.reports.index");
    }
}
