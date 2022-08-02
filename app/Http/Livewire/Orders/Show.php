<?php

namespace App\Http\Livewire\Orders;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Credit;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
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

    public $cancelConfirmation = false;

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

    public function updatePrice(OrderItem $item, $price)
    {
        $item->update(['price' => $price]);
        $this->notify('price updated');
    }

    public function cancel()
    {

        DB::transaction(function () {
            $credit = Credit::create([
                'customer_id' => $this->order->customer->id,
                'created_by' => auth()->user()->name
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

            $credit->updateStatus("processed_at");

            $this->order->customer->createCredit($credit, $credit->number);

            $this->order->updateStatus('cancelled');

        }, 3);

        Artisan::call('update:transactions', [
            'customer' => $this->order->customer->id
        ]);

        $this->notify('order deleted');

        $this->redirect('/orders');

    }

    public function updateQty(OrderItem $item, $qty)
    {
        $availableQty = $item->product->qty() + $item->qty;

        if ($item->qty > $availableQty) {
            $item->qty = $availableQty;
            $item->save();
            if ($item->qty == 0) {
                $this->remove($item);
            }
        } else {
            $item->qty = $qty;
            $item->save();
        }

        $stockRecord = Stock::query()
            ->where('product_id', '=', $item->product_id)
            ->where('reference', '=', $this->order->number)
            ->where('type', '=', 'invoice')
            ->first();

        $stockRecord->update(['qty' => 0 - $item->qty]);

        $this->notify('qty updated');
    }

    public function removeItem(OrderItem $item)
    {
        $stockRecord = Stock::query()
            ->where('product_id', '=', $item->product_id)
            ->where('reference', '=', $this->order->number)
            ->where('type', '=', 'invoice')
            ->delete();

        $item->delete();

        $this->notify('item put back in stock');

    }

    public function render(): Factory|View|Application
    {
        return view('livewire.orders.show');
    }
}
