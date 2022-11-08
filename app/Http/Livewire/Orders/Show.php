<?php

namespace App\Http\Livewire\Orders;

use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\UpdateCustomerRunningBalanceJob;
use App\Models\Credit;
use App\Models\Delivery;
use App\Models\Note;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Spatie\Browsershot\Browsershot;

class Show extends Component
{
    use WithNotifications;

    public $orderId;

    public $statusModal = false;

    public $selectedStatus = "";

    public $showWaybillModal = false;

    public $waybill;

    public $searchQuery = "";

    public $selectedProducts = [];

    public $selectedProductsToDelete = [];

    public $chooseAddressForm = false;

    public $chooseDeliveryForm = false;

    public $cancelConfirmation = false;

    public $showProductSelectorForm = false;

    public $showConfirmModal = false;

    public $showEditModal = false;

    public $addNoteForm = false;

    public $note = "";

    public $is_private = true;

    public $status;

    public function rules(): array
    {
        return [
            "note" => ["required"],
            "is_private" => ["required"],
        ];
    }

    public function mount()
    {
        $this->orderId = request("id");

        $this->status = $this->order->status;
        $this->waybill = $this->order->waybill;
    }

    public function getOrderProperty()
    {
        return Order::where("orders.id", "=", $this->orderId)
            ->with(["items.product.features", "customer.addresses", "notes"])
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
        $this->notify("Status updated");
    }

    public function pushToComplete()
    {
        $this->order->updateStatus("completed");
        $this->notify("order completed");
        $this->redirect("/orders");
    }

    public function edit()
    {
        $this->note = "Invoice edited";
        $this->body = "Invoice edited by " . auth()->user()->name;
        $this->is_private = true;
        $this->saveNote();

        $this->redirect("/orders/create/{$this->order->id}");
    }

    public function saveNote()
    {
        $this->validate();

        $this->order->notes()->create([
            "body" => $this->note,
            "is_private" => $this->is_private,
            "user_id" => auth()->id(),
        ]);

        $this->reset(["note"]);

        $this->addNoteForm = false;

        $this->notify("note added");
    }

    public function credit()
    {
        $this->order->updateStatus("cancelled");

        $this->note = "Invoice credited";
        $this->body = "Invoice credited by " . auth()->user()->name;
        $this->is_private = true;
        $this->saveNote();

        $credit = Credit::create([
            "customer_id" => $this->order->customer->id,
            "salesperson_id" => $this->order->salesperson_id,
            "created_by" => auth()->user()->name,
            "delivery_charge" => $this->order->delivery_charge,
            "processed_at" => now(),
        ]);

        foreach ($this->order->items as $item) {
            $credit->items()->create([
                "product_id" => $item->product_id,
                "qty" => $item->qty,
                "price" => $item->price,
                "cost" => $item->cost,
            ]);
        }

        $credit->increaseStock();

        $this->order->customer->createCredit($credit, $credit->number);

        UpdateCustomerRunningBalanceJob::dispatch(
            $this->order->customer_id
        )->delay(3);

        $this->notify("order deleted");
        return redirect()->route("orders");
    }

    public function updateDelivery($deliveryId)
    {
        $delivery = Delivery::find($deliveryId);
        $this->order->update([
            "delivery_type_id" => $delivery->id,
            "delivery_charge" => $delivery->price,
        ]);

        $this->order->customer->createInvoice($this->order);

        $this->notify("delivery option updated");
        $this->chooseDeliveryForm = false;
    }

    public function updateAddress($addressId)
    {
        $this->order->update(["address_id" => $addressId]);
        $this->notify("address updated");
        $this->chooseAddressForm = false;
    }

    public function removeNote(Note $note)
    {
        $note->delete();

        $this->notify("Note deleted");
    }

    public function getPickingSlip()
    {
        $this->order->load("items.product.features");

        $view = view("templates.pdf.pick-list", [
            "model" => $this->order,
        ])->render();

        $url = storage_path("app/public/pick-lists/{$this->order->number}.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia("print")
            ->format("a4")
            ->paperSize(297, 210)
            ->setScreenshotType("pdf", 100)
            ->save($url);

        $this->redirect("/storage/pick-lists/{$this->order->number}.pdf");
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.orders.show", [
            "deliveryOptions" => Delivery::all(),
            "products" => Product::query()
                ->with("features")
                ->where("is_active", "=", true)
                ->when($this->searchQuery, function ($query) {
                    $query->search($this->searchQuery);
                })
                ->orderBy("brand")
                ->simplePaginate(6),
        ]);
    }

    public function getDeliveryNote()
    {
        $this->order->load("items.product.features");

        $view = view("templates.pdf.delivery-note", [
            "model" => $this->order,
        ])->render();

        $url = storage_path(
            "app/public/delivery-note/{$this->order->number}.pdf"
        );

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia("print")
            ->format("a4")
            ->paperSize(297, 210)
            ->setScreenshotType("pdf", 100)
            ->save($url);

        $this->redirect("/storage/delivery-note/{$this->order->number}.pdf");
    }

    public function toggleNoteForm()
    {
        $this->addNoteForm = !$this->addNoteForm;
    }

    public function addWaybill()
    {
        if ($this->waybill) {
            $this->order->update(["waybill" => $this->waybill]);
            $this->notify("waybill added");
        }

        $this->toggleWaybillForm();
    }

    public function toggleWaybillForm()
    {
        $this->showWaybillModal = !$this->showWaybillModal;
    }
}
