<?php

namespace App\Http\Livewire\Orders;

use App\Http\Livewire\Traits\WithNotifications;
use App\Mail\OrderConfirmed;
use App\Mail\OrderReceived;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Artisan;
use Illuminate\Support\Facades\DB;
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

//    public $singleProductId;
//    public $qty;

    public function mount()
    {
        $this->orderId = request('id');
    }

    public function updatingSearchQuery()
    {
        if (strlen($this->searchQuery) > -1) {
            $this->showProductSelectorForm = true;
            $this->resetPage();
        }
    }

//    public function updatingSearchProducts()
//    {
//        if (strlen($this->searchProducts) > 3) {
//            $this->searchedProducts = Product::query()
//                ->with('features')
//                ->where('is_active', '=', true)
//                ->when($this->searchQuery, function ($query) {
//                    $query->search($this->searchProducts);
//                })
//                ->orderBy('brand')
//                ->get();
//        }
//    }

//    public function addSingleProduct($productId,$qty)
//    {
//        $product = Product::find($productId);
//
//        $item = $this->items()->firstOrCreate(
//            [
//                "product_id" => $product->id,
//            ],
//            [
//                "product_id" => $product->id,
//                "type" => "product",
//                "price" => $product->getPrice($this->order->customer),
//                "cost" => $product->cost,
//            ]
//        );
//
//        if ($qty < $item->product->qty()) {
//            $item->increment("qty");
//        }
//
//    }

    public function addProducts()
    {
        foreach ($this->selectedProducts as $product) {
            $this->order->addItem($product, $this->order->customer);
        }

        $this->showProductSelectorForm = false;
        $this->reset(['searchQuery']);
        $this->selectedProducts = [];

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
        $item->update(['price' => $value]);
        $this->notify('Price updated');
    }

    public function updateQty(OrderItem $item, $value)
    {
        $item->update(['qty' => $value]);
        $this->notify('Qty updated');
    }

    public function removeItem(OrderItem $item)
    {
        $item->delete();
        $this->notify('Item deleted');
    }

    public function process()
    {
        $this->showConfirmModal = false;
        $this->notify('Processing');

        DB::transaction(function () {
            $this->order->decreaseStock();
            $this->order->customer->createInvoice($this->order);

            $this->order->updateStatus('received');

            Mail::to($this->order->customer->email)->send(
                (new OrderConfirmed($this->order->customer))->afterCommit()
            );

            Mail::to(config('mail.from.address'))->send(
                (new OrderReceived($this->order->customer))->afterCommit()
            );
        }, 3);

        Artisan::call('update:transactions', [
            'customer' => $this->order->customer->id,
        ]);

        $this->notify('processed');

        $this->redirect('/orders');
    }

    public function cancel()
    {
        foreach ($this->order->items as $item) {
            $item->delete();
        }

        $this->order->delete();
        $this->notify('Order deleted');

        $this->redirectRoute('orders');
    }

    public function getOrderProperty()
    {
        return Order::find($this->orderId)->load('customer.addresses', 'items.product.features');
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

    public function render()
    {
        return view('livewire.orders.create', [
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
