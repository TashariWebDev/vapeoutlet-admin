<?php

namespace App\Http\Livewire\Reports;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Brand;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockTake;
use App\Models\SupplierTransaction;
use App\Models\Transaction;
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
    public $transactions;
    public $purchases;
    public $expenses;
    public $stock;
    public $fromDate;
    public $toDate;
    public $showExpenseForm = false;

    public function mount()
    {
        $this->transactions = Transaction::query()
            ->select(
                "*",
                DB::raw(
                    '(select SUM(amount) FROM transactions where type = "invoice" AND  MONTH(created_at) = MONTH(NOW())) as total_sales'
                ),
                DB::raw(
                    '(select SUM(amount) FROM transactions WHERE type = "credit" AND  MONTH(created_at) = MONTH(NOW())) as total_credits'
                ),
                DB::raw(
                    '(select SUM(amount) FROM transactions WHERE type = "refund" AND  MONTH(created_at) = MONTH(NOW())) as total_refunds'
                )
            )
            ->first();

        $this->purchases = SupplierTransaction::query()
            ->whereMonth("created_at", now()->month)
            ->select(
                "*",
                DB::raw(
                    '(select SUM(amount) FROM supplier_transactions where type = "purchase" AND  MONTH(created_at) = MONTH(NOW())) as total_purchases'
                ),
                DB::raw(
                    '(select SUM(amount) FROM supplier_transactions WHERE type = "payment" AND  MONTH(created_at) = MONTH(NOW())) as total_payments'
                )
            )
            ->first();

        $this->expenses = Expense::query()
            ->select(
                "*",
                DB::raw(
                    "(select SUM(amount) FROM expenses WHERE MONTH(created_at) = MONTH(NOW())) as total_expenses"
                )
            )
            ->first();

        $this->stock = Stock::query()
            ->select(
                "*",
                DB::raw("(select SUM(qty*cost) FROM stocks) as total_value")
            )
            ->first();
    }

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

    public function getCreditorsListDocument()
    {
        Http::get(
            config("app.admin_url") . "/webhook/documents/creditors-list"
        );

        $this->redirect("reports");
    }

    public function getExpenseListDocument()
    {
        Http::get(
            config("app.admin_url") .
                "/webhook/documents/expenses?from={$this->fromDate}&to={$this->toDate}"
        );
        $this->redirect("reports");
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.reports.index");
    }
}
