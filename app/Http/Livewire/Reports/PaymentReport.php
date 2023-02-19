<?php

namespace App\Http\Livewire\Reports;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
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
        $this->salespeople = User::query()
            ->where('is_super_admin', false)
            ->get();
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print(): Redirector|Application|RedirectResponse
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

        $url = storage_path(
            'app/public/'.
                config('app.storage_folder').
                '/documents/payment-report.pdf'
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
                '/documents/payment-report.pdf'
        );
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.reports.payment-report');
    }
}
