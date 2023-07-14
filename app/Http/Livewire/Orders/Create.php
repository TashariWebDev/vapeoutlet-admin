<?php

namespace App\Http\Livewire\Orders;

use App\Exceptions\QtyNotAvailableException;
use App\Http\Livewire\Traits\WithNotifications;
use App\Jobs\SendOrderEmailsJob;
use App\Jobs\UpdateCustomerRunningBalanceJob;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use LaravelIdea\Helper\App\Models\_IH_Order_C;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;
    use WithNotifications;

    public $orderId;

    public $selectedProductsToDelete = [];

    public $chooseAddressForm = false;

    public $chooseDeliveryForm = false;

    public $cancelConfirmation = false;

    public $showConfirmModal = false;

    public $addressId;

    public $deliveryId;

    public $sku;

    protected $listeners = ['refresh_data' => '$refresh'];

    public function mount()
    {
        $this->orderId = request('id');

        if ($this->order->customer->addresses()->count() == 1) {
            $this->addressId = $this->order->customer->addresses->take(1)->value('id');
            $this->updateAddress();
        }
    }

    public function getOrderProperty(): Order|array|_IH_Order_C
    {
        return Order::with(['items.product.features:id,product_id,name'])
            ->withCount('items')
            ->with('items', function ($query) {
                $query->withWhereHas('product', function ($query) {
                    $query
                        ->whereHas(
                            'stocks',
                            fn ($query) => $query->where(
                                'sales_channel_id',
                                auth()
                                    ->user()
                                    ->defaultSalesChannel()->id
                            )
                        )
                        ->withSum(
                            [
                                'stocks as total_available' => function (
                                    $query
                                ) {
                                    $query->where(
                                        'sales_channel_id',
                                        auth()
                                            ->user()
                                            ->defaultSalesChannel()->id
                                    );
                                },
                            ],
                            'qty'
                        );
                });
            })
            ->where('id', $this->orderId)
            ->first();
    }

    public function removeProducts()
    {
        foreach ($this->selectedProductsToDelete as $selectedItem) {
            $item = OrderItem::findOrFail($selectedItem);
            $this->removeItem($item);
        }

        $this->selectedProductsToDelete = [];
        $this->emitSelf('refresh_data');
        $this->notify('Products removed');
    }

    public function updatedSku()
    {
        $this->validate(['sku' => 'required']);

        $product = Product::whereHas(
            'stocks',
            fn ($query) => $query->where(
                'sales_channel_id',
                auth()
                    ->user()
                    ->defaultSalesChannel()->id
            )
        )
            ->withSum(
                [
                    'stocks as total_available' => function ($query) {
                        $query->where(
                            'sales_channel_id',
                            auth()
                                ->user()
                                ->defaultSalesChannel()->id
                        );
                    },
                ],
                'qty'
            )
            ->where('sku', '=', $this->sku)
            ->first();

        if (! $product) {
            return;
        }

        if ($product->total_available <= 0) {
            $this->notify($product->fullName().' currently out of stock');
        }

        if ($product->total_available > 0) {
            $this->order->addItem($product);
            $this->notify('Product added');
        }

        $this->sku = '';
        $this->emitSelf('refresh_data');
        $this->emit('refresh_products');
    }

    public function updatePrice(OrderItem $item, $value)
    {
        if ($value == '' || $value <= 0) {
            $this->notify('Please enter a valid price');

            return;
        }

        if ($value < $item->product->cost) {
            $this->notify('Price below cost');
        }

        if ($item->product_price == 0) {
            $productPrice = $item->product->getPrice($this->order->customer);
        } else {
            $productPrice = $item->product_price;
        }

        $item->update([
            'price' => $value,
            'product_price' => $productPrice,
            'discount' => $productPrice - $value,
        ]);

        $this->emitSelf('refresh_data');
        $this->notify('Price updated');
    }

    public function updateQty(OrderItem $item, $qty)
    {
        if ($qty == '' || $qty == 0) {
            $this->notify('Please enter a valid qty');

            return;
        }
        $qtyInStock =
            $item->product->stocks
                ->where(
                    'sales_channel_id',
                    auth()
                        ->user()
                        ->defaultSalesChannel()->id
                )
                ->sum('qty') +
            (0 - $item->stock()->first()?->qty);

        if ($qty <= $qtyInStock) {
            $item->update(['qty' => $qty]);
            $this->notify('Qty updated');
        } else {
            $item->update(['qty' => $qtyInStock]);
            $this->notify("Max Qty of $qtyInStock added");
        }

        $this->emitSelf('refresh_data');
        $this->emit('refresh_products');
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

        $this->notify('Item deleted');
        $this->emitSelf('refresh_data');
        $this->emit('refresh_products');
    }

    public function process()
    {
        if (! $this->order->items->count()) {
            $this->notify('Nothing in order');
            $this->showConfirmModal = false;

            return back();
        }

        foreach ($this->order->items as $item) {
            if ($item->qty == 0) {
                $this->notify(
                    'There are items with 0 Qty. Please update or remove'
                );
                $this->showConfirmModal = false;

                return back();
            }
        }

        try {
            $this->order->verifyIfStockIsAvailable();
        } catch (QtyNotAvailableException) {
            foreach ($this->order->items as $item) {
                if ($item->qty > $item->product->qty()) {
                    $item->update([
                        'qty' => $item->product->qty(),
                    ]);

                    if ($item->qty <= 0) {
                        $this->order->remove($item);
                    }
                }
            }

            $this->emitSelf('refresh_data');

            $this->notify(
                'Some of the items in your cart have been adjusted due to stock availability'
            );

            $this->showConfirmModal = false;

            return redirect()->back();
        }

        $delivery = Delivery::find($this->order->delivery_type_id);

        $this->order->decreaseStock();

        $this->order->is_editing = true
            ? ($createdAt = $this->order->created_at)
            : ($createdAt = now());

        $this->order->update([
            'delivery_charge' => $delivery->getPrice(
                $this->order->getSubTotal()
            ),
            'status' => 'received',
            'created_at' => $createdAt,
            'is_editing' => false,
        ]);

        $this->order->customer->createInvoice($this->order);

        try {
            $this->sendOrderEmails();
        } catch (Exception $ignored) {
            //Continue processing if emails fail
        }

        UpdateCustomerRunningBalanceJob::dispatch(
            $this->order->customer_id
        )->delay(3);

        $this->showConfirmModal = false;
        $this->notify('processed');

        return redirect()->route('orders');
    }

    public function sendOrderEmails(): void
    {
        SendOrderEmailsJob::dispatch($this->order)->delay(3);
    }

    public function updateDelivery(): void
    {
        $delivery = Delivery::find($this->deliveryId);

        $this->order->update([
            'delivery_type_id' => $delivery->id,
            'delivery_charge' => $delivery->price,
        ]);

        $this->notify('delivery option updated');
        $this->emitSelf('refresh_data');
        $this->chooseDeliveryForm = false;
    }

    public function updateAddress()
    {
        $this->order->update(['address_id' => $this->addressId]);
        $this->notify('address updated');
        $this->emitSelf('refresh_data');
        $this->chooseAddressForm = false;
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
