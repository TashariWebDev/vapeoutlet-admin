<?php

namespace App\Http\Livewire\Reports;

use App\Models\Customer;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class DebtorReport extends Component
{
    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print()
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

        $url = storage_path('app/public/documents/debtors-report.pdf');

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

        return redirect('/storage/documents/debtors-report.pdf');
    }

    public function render()
    {
        return view('livewire.reports.debtor-report');
    }
}
