<?php

namespace App\Http\Livewire\Reports;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Brand;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Product;
use App\Models\StockTake;
use App\Models\Supplier;
use App\Models\SupplierTransaction;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Http;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use LaravelIdea\Helper\App\Models\_IH_Brand_C;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;

class Index extends Component
{
    use WithNotifications;

    public $showStockTakeModal = false;
    public $showPurchasesForm = false;
    public $showCreditsForm = false;
    public $showVariancesForm = false;
    public $showSalesByDateRangeForm = false;
    public $showStocksByDateRangeForm = false;
    public $brand;
    public $transactions;
    public $purchases;
    public $expenses;
    public $fromDate;
    public $toDate;
    public $showExpenseForm = false;
    public $expenseCategories = [];
    public $selectedExpenseCategory = "";
    public $suppliers = [];
    public $selectedSupplierId = "";
    public $admins = [];
    public $selectedAdmin = "";
    public $selectedBrands = [];
    public $salespeople = [];
    public $selectedSalespersonId;
    public $stockValue;

    public function mount()
    {
        $this->expenseCategories = ExpenseCategory::all();
        $this->suppliers = Supplier::all();
        $this->admins = User::all();

        $this->salespeople = User::where(
            "email",
            "!=",
            "ridwan@tashari.co.za"
        )->get();

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
    }

    public function hydrate()
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
    }

    public function getStockValue()
    {
        $this->stockValue = Product::select(["id", "cost"])
            ->withSum("stocks", "qty")
            ->toBase()
            ->get()
            ->filter(function ($product) {
                return $product->stocks_sum_qty > 0;
            })
            ->sum(function ($product) {
                return $product->cost * $product->stocks_sum_qty;
            });
    }

    public function createStockTake()
    {
        $this->validate([
            "selectedBrands" => "required|array",
        ]);

        $this->notify("Working on it!");

        foreach ($this->selectedBrands as $brand) {
            $stockTake = StockTake::create([
                "brand" => $brand,
                "created_by" => auth()->user()->name,
                "date" => now(),
            ]);

            $selectedProducts = Product::query()
                ->select("products.id", "products.cost")
                ->where("brand", "=", $brand)
                ->get();

            foreach ($selectedProducts as $product) {
                $stockTake->items()->create([
                    "product_id" => $product->id,
                    "cost" => $product->cost,
                ]);
            }
        }

        $this->selectedBrands = [];
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
                "/webhook/documents/expenses?from={$this->fromDate}&to={$this->toDate}&category={$this->selectedExpenseCategory}"
        );
        $this->redirect("reports");
    }

    public function getPurchaseListDocument()
    {
        Http::get(
            config("app.admin_url") .
                "/webhook/documents/purchases?from={$this->fromDate}&to={$this->toDate}&supplier={$this->selectedSupplierId}"
        );
        $this->redirect("reports");
    }

    public function getCreditsListDocument()
    {
        Http::get(
            config("app.admin_url") .
                "/webhook/documents/credits?from={$this->fromDate}&to={$this->toDate}&admin={$this->selectedAdmin}"
        );
        $this->redirect("reports");
    }

    public function getVariancesDocument()
    {
        Http::get(
            config("app.admin_url") .
                "/webhook/documents/variances?from={$this->fromDate}&to={$this->toDate}"
        );
        $this->redirect("reports");
    }

    public function getSalesByDateRangeDocument()
    {
        Http::get(
            config("app.admin_url") .
                "/webhook/documents/salesByDateRange?from=$this->fromDate&to=$this->toDate&salesperson_id=$this->selectedSalespersonId"
        );
        $this->redirect("reports");
    }

    public function getStocksByDateRangeDocument()
    {
        $toDate = $this->toDate;

        $products = Product::whereHas("stocks", function ($query) use (
            $toDate
        ) {
            $query->whereDate("created_at", "<=", Carbon::parse($toDate));
        })
            ->select(["id", "name", "cost", "sku", "brand"])
            ->withSum(
                [
                    "stocks" => function ($query) use ($toDate) {
                        $query->whereDate(
                            "created_at",
                            "<=",
                            Carbon::parse($toDate)
                        );
                    },
                ],
                "qty"
            )
            ->get();

        Log::info($products);

        $url = storage_path("app/public/documents/stockByDateRange.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        $view = view("templates.pdf.stockByDateRange", [
            "products" => $products->filter(function ($product) {
                return $product->stocks_sum_qty > 0;
            }),
        ])->render();

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia("print")
            ->format("a4")
            ->paperSize(297, 210)
            ->setScreenshotType("pdf", 90)
            ->save($url);

        $this->redirect("reports");
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.reports.index");
    }
}
