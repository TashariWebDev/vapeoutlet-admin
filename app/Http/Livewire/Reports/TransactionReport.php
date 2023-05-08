<?php

namespace App\Http\Livewire\Reports;

use App\Models\Transaction;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class TransactionReport extends Component
{
    public $showTransactionForm = false;

    public $type;

    public $fromDate;

    public $toDate;

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print()
    {
        $transactions = Transaction::whereDate('date', '>=', $this->fromDate)
            ->whereDate('date', '<=', $this->toDate)
            ->when($this->type, function ($query) {
                $query->where('type', '=', $this->type);
            })
            ->get()
            ->groupBy('created_by');

        $view = view('templates.pdf.transaction-report', [
            'transactions' => $transactions,
            'from' => $this->fromDate,
            'to' => $this->toDate,
            'type' => $this->type,
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

    public function render()
    {
        return view('livewire.reports.transaction-report');
    }
}
