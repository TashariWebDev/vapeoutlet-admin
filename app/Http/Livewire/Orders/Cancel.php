<?php

namespace App\Http\Livewire\Orders;

use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\UpdateCustomerRunningBalanceJob;
use App\Models\Credit;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Cancel extends Component
{
    use WithNotifications;

    public $modal = false;

    public Order $order;

    public function credit()
    {
        //cancel an order that has not been processed
        if ($this->order->status === null) {
            foreach ($this->order->items as $item) {
                $item->delete();
            }

            $this->order->delete();

            $this->notify('order cancelled');

            return redirect()->route('orders');
        }

        $this->order->updateStatus('cancelled');

        if ($this->order->getTotal() > 0) {
            $credit = Credit::create([
                'customer_id' => $this->order->customer->id,
                'salesperson_id' => $this->order->salesperson_id,
                'created_by' => auth()->user()->name,
                'delivery_charge' => $this->order->delivery_charge,
                'processed_at' => now(),
                'sales_channel_id' => auth()
                    ->user()
                    ->defaultSalesChannel()->id,
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

            $this->order->customer->createCredit($credit, $credit->number);
        }

        $invoice = Transaction::where('type', '=', 'invoice')
            ->where('reference', '=', $this->order->number)
            ->first();

        $invoice?->update(['amount' => $this->order->getTotal()]);

        UpdateCustomerRunningBalanceJob::dispatch(
            $this->order->customer_id
        )->delay(3);

        $this->notify('order cancelled');

        return redirect()->route('orders');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.orders.cancel');
    }
}
