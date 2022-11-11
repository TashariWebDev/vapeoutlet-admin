<?php

namespace App\Http\Livewire\Orders;

use App\Exceptions\QtyNotAvailableException;
use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\UpdateCustomerRunningBalanceJob;
use App\Mail\OrderConfirmed;
use App\Mail\OrderReceived;
use App\Models\Credit;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;
    use WithNotifications;

    public $orderId;

    public $searchedProducts;

    public $searchQuery = '';

    public $searchProducts = '';

    public $selectedProducts = [];

    public $selectedProductsToDelete = [];

    public $chooseAddressForm = false;

    public $chooseDeliveryForm = false;

    public $cancelConfirmation = false;

    public $showProductSelectorForm = false;

    public $showConfirmModal = false;

    public $province;

    public $line_one;

    public $line_two;

    public $suburb;

    public $city;

    public $postal_code;

    public $products = [];

    public $provinces = [
        'gauteng',
        'kwazulu natal',
        'limpopo',
        'mpumalanga',
        'north west',
        'free state',
        'northern cape',
        'western cape',
        'eastern cape',
    ];

    public function mount()
    {
        $this->orderId = request('id');
    }

    public function updatedSearchQuery()
    {
        $this->showProductSelectorForm = true;
        if (strlen($this->searchQuery) > 0) {
            $this->products = Product::query()
                ->search($this->searchQuery)
                ->inStock()
                ->get();
        } else {
            $this->products = [];
        }
    }

    public function addProducts()
    {
        foreach ($this->selectedProducts as $product) {
            $this->order->addItem($product, $this->order->customer);
        }

        $this->showProductSelectorForm = false;
        $this->reset(['searchQuery']);
        $this->selectedProducts = [];
        $this->products = [];
        $this->notify('Products added');
        $this->order->refresh();
    }

    public function removeProducts()
    {
        foreach ($this->selectedProductsToDelete as $item) {
            $this->order->remove($item);
        }

        $this->reset(['searchQuery']);
        $this->selectedProductsToDelete = [];
        $this->notify('Products removed');
        $this->order->refresh();
    }

    public function updatePrice(OrderItem $item, $value)
    {
        if ($value < $item->product->cost) {
            $this->notify('Price below cost');
        }

        $productPrice =
            $item->product_price === 0
                ? $item->product->getPrice($this->order->customer)
                : $item->product_price;

        $item->update([
            'price' => $value,
            'discount' => $productPrice - $value,
        ]);

        $this->notify('Price updated');
    }

    public function updateQty(OrderItem $item, $qty)
    {
        $qtyInStock =
            $item->product->stocks->sum('qty') +
            (0 - $item->stock()->first()?->qty);

        if ($qty <= $qtyInStock) {
            $item->update(['qty' => $qty]);
            $this->notify('Qty updated');
        } else {
            $item->update(['qty' => $qtyInStock]);
            $this->notify("Max Qty of $qtyInStock added");
        }
    }

    public function removeItem(OrderItem $item)
    {
        $stock = $this->order
            ->stocks()
            ->where('product_id', '=', $item->product_id)
            ->first();

        if ($stock) {
            $stock->delete();
        }

        $item->delete();

        $this->order->refresh();

        $this->notify('Item deleted');
    }

    public function process()
    {
        if (! $this->order->items->count()) {
            $this->notify('Nothing in order');
            $this->showConfirmModal = false;

            return redirect()->back();
        }

        if ($this->order->stocks()->count() > 0) {
            $this->order->stocks()->delete();
        }

        $this->order->refresh();

        try {
            $this->order->verifyIfStockIsAvailable();
        } catch (QtyNotAvailableException) {
            foreach ($this->order->items as $item) {
                if ($item->qty > $item->product->qtyInStock) {
                    $item->update([
                        'qty' => $item->product->qtyInStock,
                    ]);

                    if ($item->qty <= 0) {
                        $this->order->remove($item);
                    }
                }
            }

            $this->order->refresh();

            $this->notify(
                'Some of the items in your cart have been adjusted due to stock availability'
            );

            $this->showConfirmModal = false;

            return redirect()->back();
        }

        $delivery = Delivery::find($this->order->delivery_type_id);

        $this->order->update([
            'delivery_charge' => $delivery->getPrice(
                $this->order->getSubTotal()
            ),
        ]);

        $this->showConfirmModal = false;
        $this->order->decreaseStock();
        $this->order->customer->createInvoice($this->order);
        $this->order->updateStatus('received');

        $this->sendOrderEmails();

        UpdateCustomerRunningBalanceJob::dispatch(
            $this->order->customer_id
        )->delay(3);

        $this->notify('processed');

        return redirect()->route('orders');
    }

    public function sendOrderEmails()
    {
        Mail::to($this->order->customer->email)->later(
            60,
            new OrderConfirmed($this->order->customer)
        );

        Mail::to(config('mail.from.address'))->later(
            60,
            new OrderReceived($this->order->customer)
        );
    }

    public function credit()
    {
        //cancel an order that has not been processed
        if ($this->order->status === null) {
            foreach ($this->order->items as $item) {
                $item->delete();
            }

            $this->order->delete();

            $this->redirectRoute('orders');
        }

        $this->order->updateStatus('cancelled');

        if ($this->order->getTotal() > 0) {
            $credit = Credit::create([
                'customer_id' => $this->order->customer->id,
                'salesperson_id' => $this->order->salesperson_id,
                'created_by' => auth()->user()->name,
                'delivery_charge' => $this->order->delivery_charge,
                'processed_at' => now(),
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

        $this->notify('order deleted');

        return redirect()->route('orders');
    }

    public function getOrderProperty()
    {
        return Order::findOrFail($this->orderId)->load(
            'customer.addresses',
            'items.product.features',
            'items.product.stocks'
        );
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

    public function addAddress()
    {
        $validatedData = $this->validate([
            'province' => ['required'],
            'line_one' => ['required'],
            'line_two' => ['nullable'],
            'suburb' => ['nullable'],
            'city' => ['required'],
            'postal_code' => ['required'],
        ]);

        $this->order->customer->addresses()->create($validatedData);

        $this->reset([
            'province',
            'line_one',
            'line_two',
            'suburb',
            'city',
            'postal_code',
        ]);

        $this->order->customer->load('addresses');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.orders.create', [
            'deliveryOptions' => Delivery::query()
                ->when($this->order->address, function ($query) {
                    $query->where(
                        'province',
                        '=',
                        $this->order->address->province
                    );
                })
                ->where('customer_type', '=', $this->order->customer->type())
                ->orWhere('customer_type', '=', null)
                ->where('selectable', true)
                ->orderBy('price')
                ->get(),
        ]);
    }
}
