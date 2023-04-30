<?php

namespace App\Http\Livewire\Reports;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Brand;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Transaction;
use Carbon\Carbon;
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

    public $expenses;

    public $gross_profit;

    public $previous_month_gross_profit;

    public $fromDate;

    public $toDate;

    public $suppliers = [];

    public $selectedBrands = [];

    public $selectedSalespersonId;

    public $stockValue;

    public $purchases;

    public $previousMonthPurchases;

    public $total_credits;

    public $previous_month_total_credits;

    public $total_refunds;

    public $previous_month_total_refunds;

    public $gross_sales;

    public $previous_month_gross_sales;

    public $startOfMonth;

    public $startOfPreviousMonth;

    public $endOfMonth;

    public $endOfPreviousMonth;

    public $profit_margin;

    public function mount(): void
    {
    }

    public function getValues()
    {
        //        8 queries
        $this->getGrossProfit();
        $this->getPreviousMonthGrossProfit();

        //        1 query
        $this->getStockValue();

        //        3 queries each
        $this->getGrossSales();
        $this->getPreviousMonthGrossSales();

        $this->getExpenses();
        $this->getTransactions();
        //
        $this->getPurchases();
        $this->getPreviousMonthPurchases();

        $this->getProfitMargin();
    }

    public function getProfitMargin()
    {
        if ($this->gross_sales > 0) {
            $this->profit_margin = round(($this->gross_profit / $this->gross_sales) * 100);
        } else {
            $this->profit_margin = 0;
        }
    }

    public function getPurchases()
    {
        $total = [];

        $purchases = Purchase::currentMonth()
            ->with(['items'])
            ->whereNotNull('processed_date')
            ->get();

        foreach ($purchases as $purchase) {
            if ($purchase->exchange_rate > 0) {
                $amount = $purchase->amount * $purchase->exchange_rate;
            } else {
                $amount = $purchase->amount;
            }

            $total[] = $amount;
        }

        $this->purchases = array_sum($total);
    }

    public function getPreviousMonthPurchases(): void
    {
        $total = [];

        $previousMonthPurchases = Purchase::previousMonth()
            ->with(['items'])
            ->whereNotNull('processed_date')
            ->get();

        foreach ($previousMonthPurchases as $purchase) {
            if ($purchase->exchange_rate > 0) {
                $amount = $purchase->amount * $purchase->exchange_rate;
            } else {
                $amount = $purchase->amount;
            }

            $total[] = $amount;
        }

        $this->previousMonthPurchases = array_sum($total);
    }

    public function getTransactions(): void
    {
        $this->total_credits = Transaction::query()
            ->currentMonth()
            ->where('type', '=', 'credit')
            ->sum('amount');

        $this->total_refunds = Transaction::query()
            ->currentMonth()
            ->where('type', '=', 'refund')
            ->sum('amount');

        $this->previous_month_total_credits = Transaction::query()
            ->previousMonth()
            ->where('type', '=', 'credit')
            ->sum('amount');

        $this->previous_month_total_refunds = Transaction::query()
            ->previousMonth()
            ->where('type', '=', 'refund')
            ->sum('amount');
    }

    public function getExpenses(): void
    {
        $this->expenses = Expense::currentMonth()->sum('amount');
    }

    public function getGrossSales(): void
    {
        $total = [];

        $orders = Order::currentMonth()
            ->with('items')
            ->sales()
            ->get();

        foreach ($orders as $order) {
            $total[] = $order->getTotal();
        }

        $this->gross_sales = array_sum($total);
    }

    public function getPreviousMonthGrossSales(): void
    {
        $total = [];

        $orders = Order::previousMonth()
            ->with('items')
            ->sales()
            ->get();

        foreach ($orders as $order) {
            $total[] = $order->getTotal();
        }

        $this->previous_month_gross_sales = array_sum($total);
    }

    public function getGrossProfit(): void
    {
        $total = [];

        $orders = Order::currentMonth()->with('items')->sales()->get();

        foreach ($orders as $order) {
            $total[] = $order->getProfit();
        }

        $this->gross_profit = array_sum($total);
    }

    public function getPreviousMonthGrossProfit(): void
    {
        $total = [];

        $orders = Order::previousMonth()
            ->with('items')
            ->sales()
            ->get();

        foreach ($orders as $order) {
            $total[] = $order->getProfit();
        }

        $this->previous_month_gross_profit = array_sum($total);
    }

    public function getStockValue(): void
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
