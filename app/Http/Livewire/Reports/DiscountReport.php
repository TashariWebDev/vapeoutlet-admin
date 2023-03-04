<?php

namespace App\Http\Livewire\Reports;

use App\Models\OrderItem;
use App\Models\SalesChannel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class DiscountReport extends Component
{
    public $showDiscountForm = false;

    public $fromDate;

    public $toDate;

    public $salesChannelId;

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print(): Redirector|Application|RedirectResponse
    {
        $salesChannel = SalesChannel::find($this->salesChannelId);

        $discounts = OrderItem::whereBetween('created_at', [
            $this->fromDate,
            $this->toDate,
        ])
            ->where('discount', '>', 0)
            ->withWhereHas('order', function ($query) {
                $query->where('sales_channel_id', '=', $this->salesChannelId);
            })
            ->get()
            ->groupBy('product_id');

        $view = view('templates.pdf.discount-report', [
            'discounts' => $discounts,
            'from' => $this->fromDate,
            'to' => $this->toDate,
            'salesChannel' => $salesChannel,
        ])->render();

        $url = storage_path(
            'app/public/'.
            config('app.storage_folder').
            '/documents/discount-report.pdf'
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
            '/documents/discount-report.pdf'
        );
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.reports.discount-report', [
            'salesChannels' => SalesChannel::query()
                ->withoutTrashed()
                ->get(),
        ]);
    }
}
