<?php

namespace App\Http\Livewire\Reports;

use App\Models\Customer;
use App\Models\User;
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
        $this->salespeople = User::where('is_super_admin', false)->get();
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print()
    {
        $customers = Customer::withWhereHas('orders', function ($query) {
            $query
                ->whereBetween('created_at', [$this->fromDate, $this->toDate])
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

    public function render()
    {
        return view('livewire.reports.sales-report');
    }
}
