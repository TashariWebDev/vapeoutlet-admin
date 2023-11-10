<?php

namespace App\Http\Livewire\Reports;

use App\Models\Brand;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class ProductSalesByVolumeReport extends Component
{
    public $showSalesByVolumeForm = false;

    public $fromDate;

    public $toDate;

    public $brand;

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print(): Redirector|Application|RedirectResponse
    {
        $this->validate([
            'fromDate' => ['required', 'before:toDate'],
            'toDate' => ['required', 'after:fromDate'],
            'brand' => ['sometimes'],
        ]);

        $products = Product::query()
            ->select([
                'id',
                'name',
                'brand',
                'category',
                'sku',
                'product_collection_id',
            ])
            ->when($this->brand, function ($query) {
                $query->where('brand', '=', $this->brand);
            })
            ->with(['features:id,product_id,name'])
            ->withSum(
                [
                    'stocks' => function ($query) {
                        $query
                            ->where('type', 'invoice')
                            ->whereDate(
                                'created_at',
                                '>=',
                                Carbon::parse($this->fromDate)
                            )
                            ->whereDate(
                                'created_at',
                                '<=',
                                Carbon::parse($this->toDate)
                            );
                    },
                ],
                'qty'
            )
            ->orderBy('stocks_sum_qty')
            ->get();

        $grouped = $products->groupBy('product_collection_id');

        $view = view('templates.pdf.sales-by-volume-report', [
            'grouped' => $grouped,
            'from' => $this->fromDate,
            'to' => $this->toDate,
            'brand' => $this->brand,
        ])->render();

        $url = storage_path(
            'app/public/'.
            config('app.storage_folder').
            '/documents/sales-by-volume-report.pdf'
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
            '/documents/sales-by-volume-report.pdf'
        );
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.reports.product-sales-by-volume-report', [
            'brands' => Brand::query()
                ->orderBy('name')
                ->get(),
        ]);
    }
}
