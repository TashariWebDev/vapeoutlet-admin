<?php

namespace App\Http\Livewire\Reports;

use App\Models\Stock;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class VariancesReport extends Component
{
    public $showVariancesForm = false;

    public $fromDate;

    public $toDate;

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print()
    {
        $stocks = Stock::whereBetween('created_at', [
            $this->fromDate,
            $this->toDate,
        ])
            ->where('type', '=', 'adjustment')
            ->where('qty', '!=', 0)
            ->get()
            ->sortBy('reference');

        $view = view('templates.pdf.variances-report', [
            'stocks' => $stocks,
            'from' => $this->fromDate,
            'to' => $this->toDate,
        ])->render();

        $url = storage_path('app/public/documents/variances-report.pdf');

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

        return redirect('/storage/documents/variances-report.pdf');
    }

    public function render()
    {
        return view('livewire.reports.variances-report');
    }
}
