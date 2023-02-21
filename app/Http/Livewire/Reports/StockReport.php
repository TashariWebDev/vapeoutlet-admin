<?php

namespace App\Http\Livewire\Reports;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class StockReport extends Component
{
    public $showStocksReportForm;

    public $toDate;

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print(): Redirector|Application|RedirectResponse
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
                '/documents/stock-report.pdf'
        );

        if (file_exists($url)) {
            unlink($url);
        }

        $view = view('templates.pdf.stock-report', [
            'products' => $products->filter(function ($product) {
                return $product->stocks_sum_qty > 0;
            }),
            'to' => $this->toDate,
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

    public function render()
    {
        return view('livewire.reports.stock-report');
    }
}
