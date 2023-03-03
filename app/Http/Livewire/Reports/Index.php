<?php

namespace App\Http\Livewire\Reports;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Brand;
use App\Models\Expense;
use App\Models\Product;
use App\Models\SupplierTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
use DB;
use Http;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\_IH_Brand_C;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class Index extends Component
{
    use WithNotifications;

    public $showStockTakeModal = false;

    public $showStocksByDateRangeForm = false;

    public $brand;

    public $transactions;

    public $purchases;

    public $expenses;

    public $fromDate;

    public $toDate;

    public $suppliers = [];

    public $selectedBrands = [];

    public $selectedSalespersonId;

    public $stockValue;

    public $salesPerChannel;

    public function mount()
    {
        $this->transactions = Transaction::query()
            ->select(
                '*',
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
                '*',
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
                '*',
                DB::raw(
                    '(select SUM(amount) FROM expenses WHERE MONTH(created_at) = MONTH(NOW())) as total_expenses'
                )
            )
            ->first();
    }

    public function hydrate()
    {
        $this->salesPerChannel = Transaction::query()
            ->select(
                '*',
                DB::raw(
                    '(select SUM(amount) FROM transactions  where type = "invoice" AND  MONTH(created_at) = MONTH(NOW()) ) as total_sales'
                )
            )
            ->first();

        $this->transactions = Transaction::query()
            ->select(
                '*',
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
                '*',
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
                '*',
                DB::raw(
                    '(select SUM(amount) FROM expenses WHERE MONTH(created_at) = MONTH(NOW())) as total_expenses'
                )
            )
            ->first();
    }

    public function getStockValue()
    {
        $this->stockValue = Product::select(['id', 'cost'])
            ->withSum('stocks', 'qty')
            ->toBase()
            ->get()
            ->filter(function ($product) {
                return $product->stocks_sum_qty > 0;
            })
            ->sum(function ($product) {
                return $product->cost * $product->stocks_sum_qty;
            });
    }

    public function getBrandsProperty(): _IH_Brand_C|Collection|array
    {
        return Brand::all();
    }

    public function getCreditorsListDocument()
    {
        Http::get(config('app.app_url').'/webhook/documents/creditors-list');

        return redirect('reports');
    }

    public function getVariancesDocument()
    {
        Http::get(
            config('app.app_url').
                "/webhook/documents/variances?from=$this->fromDate&to=$this->toDate"
        );

        return redirect('reports');
    }

    public function getSalesByDateRangeDocument()
    {
        Http::get(
            config('app.app_url').
                "/webhook/documents/salesByDateRange?from=$this->fromDate&to=$this->toDate&salesperson_id=$this->selectedSalespersonId"
        );

        return redirect('reports');
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getStocksByDateRangeDocument()
    {
        $products = Product::whereHas('stocks', function ($query) {
            $query->whereDate('created_at', '<=', Carbon::parse($this->toDate));
        })
            ->select(['id', 'name', 'cost', 'sku', 'brand'])
            ->withSum(
                [
                    'stocks' => function ($query) {
                        $query->whereDate(
                            'created_at',
                            '<=',
                            Carbon::parse($this->toDate)
                        );
                    },
                ],
                'qty'
            )
            ->get();

        $url = storage_path(
            'app/public/'.
                config('app.storage_folder').
                '/documents/stockByDateRange.pdf'
        );

        if (file_exists($url)) {
            unlink($url);
        }

        $view = view('templates.pdf.stock-report', [
            'products' => $products->filter(function ($product) {
                return $product->stocks_sum_qty > 0;
            }),
        ])->render();

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 90)
            ->save($url);

        return redirect('reports');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.reports.index');
    }
}
