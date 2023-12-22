<?php

namespace App\Http\Livewire\Reports;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Brand;
use App\Models\Credit;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Stock;
use App\Models\Transaction;
use Carbon\Carbon;
use Http;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
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

    public $previousMonthExpenses;

    public $gross_profit;

    public $previous_month_gross_profit;

    public $credit_profit;

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

    public $total_warranties;

    public $previous_month_total_warranties;

    public $gross_sales;

    public $previous_month_gross_sales;

    public $startOfMonth;

    public $startOfPreviousMonth;

    public $endOfMonth;

    public $endOfPreviousMonth;

    public $profit_margin;

    public $productVolumes;

    public function getValues()
    {
        $this->getTransactions();
        //        8 queries
        $this->getGrossSales();
        $this->getPreviousMonthGrossSales();
        $this->getGrossProfit();
        $this->getPreviousMonthGrossProfit();
        $this->getCreditProfit();
        $this->getPreviousMonthCreditProfit();

        $this->getStockValue();

        $this->getExpenses();
        $this->getPreviousMonthExpenses();

        $this->getPurchases();
        $this->getPreviousMonthPurchases();

        $this->getProfitMargin();

        $this->getProductVolumes();
    }

    public function getProductVolumes(): void
    {
        $this->productVolumes = Stock::query()
            ->with('product')
            ->where('type', '=', 'invoice')
            ->whereMonth('created_at', '=', today()->month)
            ->whereYear('created_at', '=', today()->year)
            ->get()
            ->groupBy('product_id')
            ->map(function ($item) {
                return [
                    'brand' => $item->first()->product->brand,
                    'name' => $item->first()->product->name.' '.$item->first()->product->category,
                    'volume' => 0 - $item->sum('qty'),
                ];
            })
            ->sortByDesc('volume')->groupBy('brand');
    }

    public function getProfitMargin(): void
    {
        if ($this->gross_sales > 0) {
            $this->profit_margin = round(($this->gross_profit / $this->gross_sales) * 100);
        } else {
            $this->profit_margin = 0;
        }
    }

    public function getPurchases(): void
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

        $this->previous_month_total_credits = Transaction::query()
            ->previousMonth()
            ->where('type', '=', 'credit')
            ->sum('amount');

        $this->total_refunds = Transaction::query()
            ->currentMonth()
            ->where('type', '=', 'refund')
            ->sum('amount');

        $this->previous_month_total_refunds = Transaction::query()
            ->previousMonth()
            ->where('type', '=', 'refund')
            ->sum('amount');

        $this->total_warranties = Transaction::query()
            ->currentMonth()
            ->where('type', '=', 'warranty')
            ->sum('amount');

        $this->previous_month_total_warranties = Transaction::query()
            ->previousMonth()
            ->where('type', '=', 'warranty')
            ->sum('amount');
    }

    public function getExpenses(): void
    {
        $this->expenses = Expense::currentMonth()->sum('amount');
    }

    public function getPreviousMonthExpenses(): void
    {
        $this->previousMonthExpenses = Expense::previousMonth()->sum('amount');
    }

    public function getGrossSales(): void
    {
        $profit = Order::currentMonth()
            ->with('items')
            ->sales()
            ->get()->sum(function ($order) {
                return $order->getTotal();
            });

        $creditsNotes = to_rands(0 - $this->total_credits);
        $refunds = to_rands(0 - $this->total_refunds);

        $this->gross_sales = $profit - ($creditsNotes + $refunds);
    }

    public function getPreviousMonthGrossSales(): void
    {
        $profit = Order::previousMonth()
            ->with('items')
            ->sales()
            ->get()->sum(function ($order) {
                return $order->getTotal();
            });

        $creditsNotes = to_rands(0 - $this->previous_month_total_credits);
        $refunds = to_rands(0 - $this->previous_month_total_refunds);

        $this->previous_month_gross_sales = $profit - ($creditsNotes + $refunds);
    }

    public function getGrossProfit(): void
    {

        $profit = Order::currentMonth()->with('items')->sales()->get()->sum(function ($order) {
            return $order->getProfit();
        });

        $refunds = to_rands(0 - $this->total_refunds);
        $creditNoteProfit = to_rands(0 - $this->credit_profit);
        $warranties = to_rands(0 - $this->total_warranties);

        $this->gross_profit = $profit - ($refunds + $creditNoteProfit + $warranties);
    }

    public function getPreviousMonthGrossProfit(): void
    {
        $profit = Order::previousMonth()
            ->with('items')
            ->sales()
            ->get()->sum(function ($order) {
                return $order->getProfit();
            });

        $refunds = to_rands(0 - $this->previous_month_total_refunds);
        $creditNoteProfit = to_rands(0 - $this->getPreviousMonthCreditProfit());
        $warranties = to_rands(0 - $this->previous_month_total_warranties);

        $this->previous_month_gross_profit = $profit - ($refunds + $creditNoteProfit + $warranties);
    }

    // Get total cost of credits
    public function getCreditProfit()
    {
        return Credit::currentMonth()->with('items')->get()->sum(function ($credit) {
            return $credit->getCost();
        });
    }

    // Get total cost of credits from precious month
    public function getPreviousMonthCreditProfit(): float|int
    {
        return Credit::previousMonth()->with('items')->get()->sum(function ($credit) {
            return $credit->getCost();
        });
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

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print($type)
    {
        $transactions = Transaction::query()
            ->currentMonth()
            ->where('type', '=', $type)
            ->get()
            ->groupBy('created_by');

        $view = view('templates.pdf.transaction-report', [
            'transactions' => $transactions,
            'from' => now()->firstOfMonth(),
            'to' => today(),
            'type' => $type,
        ])->render();

        $url = storage_path(
            'app/public/'.
            config('app.storage_folder').
            '/documents/transaction-report.pdf'
        );

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->addChromiumArguments([
                'headless' => 'old',
            ])
            ->showBackground()
            ->showBrowserHeaderAndFooter()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 60)
            ->save($url);

        return redirect(
            '/storage/'.
            config('app.storage_folder').
            '/documents/transaction-report.pdf'
        );
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function printCurrentCreditReport()
    {
        $credits = Credit::query()
            ->currentMonth()
            ->get()
            ->groupBy('created_by');

        $view = view('templates.pdf.credits-report', [
            'credits' => $credits,
            'from' => now()->firstOfMonth(),
            'to' => today(),
        ])->render();

        $url = storage_path(
            'app/public/'.
            config('app.storage_folder').
            '/documents/credits-report.pdf'
        );

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->showBrowserHeaderAndFooter()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 60)
            ->save($url);

        return redirect(
            '/storage/'.
            config('app.storage_folder').
            '/documents/credits-report.pdf'
        );
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function printStockReport(): Redirector|Application|RedirectResponse
    {
        $products = Product::whereHas('stocks', function ($query) {
            $query->whereDate('created_at', '<=', today());
        })
            ->select(['id', 'name', 'cost', 'sku', 'brand', 'product_collection_id'])
            ->withSum(
                [
                    'stocks' => function ($query) {
                        $query->whereDate(
                            'created_at',
                            '<=',
                            today()
                        );
                    },
                ],
                'qty'
            )
            ->orderBy('brand')
            ->orderBy('name')
            ->orderBy('product_collection_id')
            ->get();

        $url = storage_path(
            'app/public/'.
            config('app.storage_folder').
            '/documents/stock-report.pdf'
        );

        if (file_exists($url)) {
            unlink($url);
        }

        $view = view('templates.pdf.stock-report', [
            'products' => $products->filter(function ($product) {
                return $product->stocks_sum_qty > 0;
            }),
            'to' => today(),
        ])->render();

        Browsershot::html($view)
            ->showBackground()
            ->showBrowserHeaderAndFooter()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 60)
            ->save($url);

        return redirect(
            '/storage/'.
            config('app.storage_folder').
            '/documents/stock-report.pdf'
        );
    }

    public function printExpenseReport(): Redirector|Application|RedirectResponse
    {
        $expenses = Expense::query()
            ->currentMonth()
            ->get()
            ->groupBy('category');

        $view = view('templates.pdf.expenses', [
            'expenses' => $expenses,
            'from' => now()->firstOfMonth(),
            'to' => today(),
        ])->render();

        $url = storage_path(
            'app/public/'.
            config('app.storage_folder').
            '/documents/expenses.pdf'
        );

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->showBrowserHeaderAndFooter()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 60)
            ->save($url);

        return redirect(
            '/storage/'.
            config('app.storage_folder').
            '/documents/expenses.pdf'
        );
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.reports.index');
    }
}
