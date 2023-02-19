<?php

namespace App\Http\Livewire\Reports;

use App\Models\Stock;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
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
    public function print(): Redirector|Application|RedirectResponse
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

        $url = storage_path(
            'app/public/'.
                config('app.storage_folder').
                '/documents/variances-report.pdf'
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
                '/documents/variances-report.pdf'
        );
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.reports.variances-report');
    }
}
