<?php

namespace App\Http\Livewire\Reports;

use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class PaymentReport extends Component
{
    public $showPaymentReportForm = false;

    public $fromDate;

    public $toDate;

    public $salesperson_id;

    public $salespeople = [];

    public function mount()
    {
        $this->salespeople = User::where(
            'email',
            '!=',
            'ridwan@tashari.co.za'
        )->get();
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print()
    {
        $transactions = Transaction::whereBetween('created_at', [
            $this->fromDate,
            $this->toDate,
        ])
            ->withWhereHas('customer', function ($query) {
                $query->where('salesperson_id', '=', $this->salesperson_id);
            })
            ->where('type', '=', 'payment')
            ->get()
            ->groupBy('customer_id');

        $view = view('templates.pdf.payment-report', [
            'transactions' => $transactions,
            'from' => $this->fromDate,
            'to' => $this->toDate,
        ])->render();

        $url = storage_path('app/public/documents/payment-report.pdf');

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

        return redirect('/storage/documents/payment-report.pdf');
    }

    public function render()
    {
        return view('livewire.reports.payment-report');
    }
}
