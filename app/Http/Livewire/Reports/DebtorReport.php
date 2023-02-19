<?php

namespace App\Http\Livewire\Reports;

use App\Models\Customer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class DebtorReport extends Component
{
    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print(): Redirector|Application|RedirectResponse
    {
        $customers = Customer::withWhereHas('latestTransaction', function (
            $query
        ) {
            $query->where('running_balance', '!=', 0);
        })
            ->withSum('latestTransaction', 'running_balance')
            ->orderBy('name')
            ->get();
        $view = view('templates.pdf.debtors-report', [
            'customers' => $customers,
        ])->render();

        $url = storage_path(
            'app/public/'.
                config('app.storage_folder').
                '/documents/debtors-report.pdf'
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
                '/documents/debtors-report.pdf'
        );
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.reports.debtor-report');
    }
}
