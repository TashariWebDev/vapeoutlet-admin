<?php

namespace App\Http\Livewire\Orders;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Note;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LaravelIdea\Helper\App\Models\_IH_Order_QB;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class Show extends Component
{
    use WithNotifications;

    public $orderId;

    public $statusModal = false;

    public $selectedStatus = '';

    public $showEditModal = false;

    public $status;

    protected $listeners = ['update_order' => '$refresh'];

    public function mount()
    {
        $this->orderId = request('id');

        $this->status = $this->order->status;
    }

    public function getOrderProperty(): Model|Order|Builder|_IH_Order_QB|null
    {
        return Order::where('orders.id', '=', $this->orderId)
            ->with([
                'items:order_id,product_id,price,discount,qty',
                'notes',
                'items.product.features:id,name,product_id',
            ])
            ->withCount('stocks')
            ->first();
    }

    public function updatedStatusModal()
    {
        $this->status = $this->order->status;
    }

    public function updateOrderStatus()
    {
        $this->order->updateStatus($this->selectedStatus);
        $this->status = $this->order->status;
        $this->notify('Status updated');
    }

    public function pushToComplete()
    {
        $this->order->updateStatus('completed');
        $this->notify('order completed');

        return redirect('/orders');
    }

    public function edit()
    {
        if ($this->order->stocks_count > 0) {
            $this->order->stocks()->delete();
        }

        return redirect("/orders/create/{$this->order->id}");
    }

    public function removeNote(Note $note)
    {
        $note->delete();

        $this->notify('Note deleted');
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getPickingSlip()
    {
        $view = view('templates.pdf.pick-list', [
            'order' => $this->order,
        ])->render();

        $name = 'PS-'.$this->order->number;

        $url = storage_path(
            'app/public/'.
                config('app.storage_folder').
                "/documents/$name.pdf"
        );

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 50)
            ->save($url);

        return redirect(
            '/storage/'.config('app.storage_folder')."/documents/$name.pdf"
        );
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getDeliveryNote()
    {
        $view = view('templates.pdf.delivery-note', [
            'order' => $this->order,
        ])->render();

        $name = 'DN-'.$this->order->number;

        $url = storage_path(
            'app/public/'.
                config('app.storage_folder').
                "/documents/$name.pdf"
        );

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 100)
            ->save($url);

        return redirect(
            '/storage/'.config('app.storage_folder')."/documents/$name.pdf"
        );
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.orders.show');
    }
}
