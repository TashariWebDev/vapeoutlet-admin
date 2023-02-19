<?php

namespace App\Http\Livewire\Reports;

use App\Models\Purchase;
use App\Models\Supplier;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;

class PurchaseReport extends Component
{
    public $showPurchasesForm = false;

    public $fromDate;

    public $toDate;

    public $supplier;

    public $suppliers;

    public function mount()
    {
        $this->suppliers = Supplier::all();
    }

    public function print()
    {
        $purchases = Purchase::whereBetween('date', [
            $this->fromDate,
            $this->toDate,
        ])
            ->when($this->supplier, function ($query) {
                $query->whereSupplierId($this->supplier);
            })
            ->get()
            ->groupBy('supplier_id');

        $view = view('templates.pdf.purchases-report', [
            'purchases' => $purchases,
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
        ])->render();

        $url = storage_path(
            'app/public/'.
                config('app.storage_folder').
                '/documents/purchases-report.pdf'
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
                '/documents/purchases-report.pdf'
        );
    }

    public function render()
    {
        return view('livewire.reports.purchase-report');
    }
}
