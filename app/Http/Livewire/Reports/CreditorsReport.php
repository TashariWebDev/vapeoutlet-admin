<?php

namespace App\Http\Livewire\Reports;

use App\Models\Supplier;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class CreditorsReport extends Component
{
    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print()
    {
        $suppliers = Supplier::withWhereHas('latestTransaction', function (
            $query
        ) {
            $query->where('running_balance', '!=', 0);
        })
            ->withSum('latestTransaction', 'running_balance')
            ->orderBy('name')
            ->get();

        $view = view('templates.pdf.creditors-report', [
            'suppliers' => $suppliers,
        ])->render();

        $url = storage_path(
            'app/public/'.
                config('app.storage_folder').
                '/documents/creditors-report.pdf'
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
                '/documents/creditors-report.pdf'
        );
    }

    public function render()
    {
        return view('livewire.reports.creditors-report');
    }
}
