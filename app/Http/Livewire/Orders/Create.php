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
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use LaravelIdea\Helper\App\Models\_IH_Product_C;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;
    use WithNotifications;

    public $orderId;

    public $searchedProducts;

    public $searchQuery = "";

    public $searchProducts = "";

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

    public $provinces = [
        "gauteng",
        "kwazulu natal",
        "limpopo",
        "mpumalanga",
        "north west",
        "free state",
        "northern cape",
        "western cape",
        "eastern cape",
    ];

    public function mount()
    {
        $this->orderId = request("id");
    }

    public function updatingSearchQuery()
    {
        if (strlen($this->searchQuery) > -1) {
            $this->showProductSelectorForm = true;
            $this->resetPage();
        }
    }

    public function addProducts()
    {
        foreach ($this->selectedProducts as $product) {
            $this->order->addItem($product, $this->order->customer);
        }

        $this->showProductSelectorForm = false;
        $this->reset(["searchQuery"]);
        $this->selectedProducts = [];
        $this->notify("Products added");
        $this->order->refresh();
    }

    public function removeProducts()
    {
        foreach ($this->selectedProductsToDelete as $item) {
            $this->order->remove($item);
        }

        $this->reset(["searchQuery"]);
        $this->selectedProductsToDelete = [];
        $this->notify("Products removed");
        $this->order->refresh();
    }

    public function updatePrice(OrderItem $item, $value)
    {
        $item->update(["price" => $value]);
        $this->notify("Price updated");
    }

    public function updateQty(OrderItem $item, $qty)
    {
        $qtyInStock = $item->product->stocks()->sum("qty");

        if ($qty <= $qtyInStock) {
            $item->update(["qty" => $qty]);
            $this->notify("Qty updated");
        } else {
            $item->update(["qty" => $qtyInStock]);
            $this->notify("Max Qty of {$qtyInStock} added");
        }
    }

    public function removeItem(OrderItem $item)
    {
        $item->delete();
        $this->notify("Item deleted");
    }

    public function process()
    {
        $this->showConfirmModal = false;
        $this->notify("Processing");

        DB::transaction(function () {
            $this->order->update([
                "salesperson_id" => $this->order->customer->salesperson_id,
            ]);
            $this->order->verifyIfStockIsAvailable();
            $this->order->decreaseStock();
            $this->order->customer->createInvoice($this->order);

            $this->order->updateStatus("received");

            Mail::to($this->order->customer->email)->send(
                (new OrderConfirmed($this->order->customer))->afterCommit()
            );

            Mail::to(config("mail.from.address"))->send(
                (new OrderReceived($this->order->customer))->afterCommit()
            );
        }, 3);

        Artisan::call("update:transactions", [
            "customer" => $this->order->customer->id,
        ]);

        $this->notify("processed");

        $this->redirect("/orders");
    }

    public function cancel()
    {
        //        cancel an order that has not been processed
        foreach ($this->order->items as $item) {
            $item->delete();
        }

        $this->order->delete();
        $this->notify("Order deleted");

        $this->redirectRoute("orders");
    }

    public function getOrderProperty(): Order|array|_IH_Order_C|null
    {
        return Order::find($this->orderId)->load(
            "customer.addresses",
            "items.product.features",
            "items.product.stocks"
        );
    }

    public function updateDelivery($deliveryId)
    {
        $delivery = Delivery::find($deliveryId);
        $this->order->update([
            "delivery_type_id" => $delivery->id,
            "delivery_charge" => $delivery->price,
        ]);

        $this->notify("delivery option updated");
        $this->chooseDeliveryForm = false;
    }

    public function updateAddress($addressId)
    {
        $this->order->update(["address_id" => $addressId]);
        $this->notify("address updated");
        $this->chooseAddressForm = false;
    }

    public function addAddress()
    {
        $validatedData = $this->validate([
            "province" => ["required"],
            "line_one" => ["required"],
            "line_two" => ["nullable"],
            "suburb" => ["nullable"],
            "city" => ["required"],
            "postal_code" => ["required"],
        ]);

        $this->order->customer->addresses()->create($validatedData);

        $this->reset([
            "province",
            "line_one",
            "line_two",
            "suburb",
            "city",
            "postal_code",
        ]);

        $this->order->customer->load("addresses");
    }

    public function getProductsProperty(): _IH_Product_C|Paginator|array
    {
        return Product::query()
            ->with("features:product_id,name", "stocks")
            ->select([
                "id",
                "sku",
                "name",
                "brand",
                "category",
                "retail_price",
                "wholesale_price",
            ])
            ->inStock()
            ->where("is_active", "=", true)
            ->when($this->searchQuery, function ($query) {
                $query->search($this->searchQuery);
            })
            ->orderBy("brand")
            ->simplePaginate(6);
    }

    public function render(): Factory|View|Application
    {
        return view("livewire.orders.create", [
            "deliveryOptions" => Delivery::all(),
        ]);
    }
}
