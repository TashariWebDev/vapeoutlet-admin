<?php

namespace App\Http\Livewire\Warehouse;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class Index extends Component
{
    use WithPagination;
    use WithNotifications;

    public $searchQuery = '';

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getPickingSlip(Order $order)
    {
        $view = view('templates.pdf.pick-list', [
            'order' => $order,
        ])->render();

        $url = storage_path("app/public/documents/$order->number.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 60)
            ->save($url);

        $this->redirect("/storage/documents/$order->number.pdf");
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.warehouse.index', [
            'orders' => Order::query()
                ->select(['id', 'created_at', 'status', 'customer_id'])
                ->with([
                    'customer:id,name,company,salesperson_id,is_wholesale',
                    'customer.salesperson:id,name',
                ])
                ->without(['items'])
                ->whereStatus('processed')
                ->latest()
                ->paginate(5),
        ]);
    }
}
