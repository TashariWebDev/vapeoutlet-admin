<?php

namespace App\Http\Livewire\Reports;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class SalesReport extends Component
{
    public $showSalesReportForm = false;

    public $fromDate;

    public $toDate;

    public $salesperson_id;

    public $salespeople = [];

    public function mount()
    {
        $this->salespeople = User::where('is_super_admin', false)->withTrashed()->get();
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print(): Redirector|Application|RedirectResponse
    {
        $customers = Customer::withWhereHas('orders', function ($query) {
            $query
                ->with('items')
                ->whereDate('created_at', '>=', $this->fromDate)
                ->whereDate('created_at', '<=', $this->toDate)
                ->where('status', '!=', 'cancelled')
                ->whereNotNull('status');
        })
            ->select([
                'customers.id',
                'customers.name',
                'customers.salesperson_id',
            ])
            ->with('salesperson:id,name')
            ->when($this->salesperson_id, function ($query) {
                $query->where(
                    'salesperson_id',
                    '=',
                    (int) $this->salesperson_id
                );
            })
            ->get()
            ->groupBy('salesperson.name');

        $url = storage_path(
            'app/public/'.
            config('app.storage_folder').
            '/documents/sales-report.pdf'
        );

        if (file_exists($url)) {
            unlink($url);
        }

        $view = view('templates.pdf.sales-report', [
            'customers' => $customers,
            'from' => $this->fromDate,
            'to' => $this->toDate,
        ])->render();

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
            '/documents/sales-report.pdf'
        );
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.reports.sales-report');
    }
}
