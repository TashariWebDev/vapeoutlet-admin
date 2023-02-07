<?php

namespace App\Http\Livewire\Orders;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Note;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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

    public function getOrderProperty()
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
        $this->redirect('/orders');
    }

    public function edit()
    {
        if ($this->order->stocks_count > 0) {
            $this->order->stocks()->delete();
        }

        $this->redirect("/orders/create/{$this->order->id}");
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

        $url = storage_path("app/public/documents/PS-$this->order->number.pdf");

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

        $this->redirect("/storage/documents/PS-$this->order->number.pdf");
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getDeliveryNote()
    {
        $view = view('templates.pdf.delivery-note', [
            'order' => $this->order,
        ])->render();

        $url = storage_path(
            "app/public/documents/DN-$this->order->number.pdf"
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

        $this->redirect("/storage/documents/DN-$this->order->number.pdf");
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.orders.show');
    }
}
