<?php

namespace App\Http\Livewire\Orders;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Credit;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use Artisan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Show extends Component
{
    use WithNotifications;

    public $orderId;

    public $searchQuery = '';

    public $selectedProducts = [];

    public $selectedProductsToDelete = [];

    public $chooseAddressForm = false;

    public $chooseDeliveryForm = false;

    public $cancelConfirmation = false;

    public $showProductSelectorForm = false;

    public $showConfirmModal = false;

    public $showEditModal = false;

    public function mount()
    {
        $this->orderId = request('id');
    }

    public function getOrderProperty()
    {
        return Order::where('orders.id', '=', $this->orderId)
            ->with(['items.product.features', 'customer.addresses'])
            ->first();
    }

    public function pushToWarehouse()
    {
        $this->order->updateStatus('processed');
        $this->notify('pushed to warehouse for picking');
        $this->redirect('/orders');
    }

    public function edit()
    {
        DB::transaction(function () {
            $newOrder = $this->order->replicate()->fill([
                'status' => null,
            ]);
            $newOrder->save();

            foreach ($this->order->items as $item) {
                $newItem = $item->replicate()->fill([
                    'order_id' => $newOrder->id,
                ]);
                $newItem->save();
            }

            $this->cancel();
            $this->redirect("/orders/create/{$newOrder->id}");
        });
    }

    public function cancel()
    {
        DB::transaction(function () {
            $credit = Credit::create([
                'customer_id' => $this->order->customer->id,
                'created_by' => auth()->user()->name,
            ]);

            foreach ($this->order->items as $item) {
                $credit->items()->create([
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'cost' => $item->cost,
                ]);
            }

            $credit->increaseStock();

            $credit->updateStatus('processed_at');

            $this->order->customer->createCredit($credit, $credit->number);

            $this->order->updateStatus('cancelled');
        }, 3);

        Artisan::call('update:transactions', [
            'customer' => $this->order->customer->id,
        ]);

        $this->notify('order deleted');

        $this->redirect('/orders');
    }

    public function updateDelivery($deliveryId)
    {
        $delivery = Delivery::find($deliveryId);
        $this->order->update([
            'delivery_type_id' => $delivery->id,
            'delivery_charge' => $delivery->price,
        ]);

        $this->notify('delivery option updated');
        $this->chooseDeliveryForm = false;
    }

    public function updateAddress($addressId)
    {
        $this->order->update(['address_id' => $addressId]);
        $this->notify('address updated');
        $this->chooseAddressForm = false;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.orders.show', [
            'deliveryOptions' => Delivery::all(),
            'products' => Product::query()
                ->with('features')
                ->where('is_active', '=', true)
                ->when($this->searchQuery, function ($query) {
                    $query->search($this->searchQuery);
                })
                ->orderBy('brand')
                ->simplePaginate(6),
        ]);
    }
}
