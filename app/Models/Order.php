<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;

class Order extends Model
{

    protected $guarded = [];

    protected $dates = [
        'placed_at',// order created
        'processes_at',// order adjusted and sent to warehouse
        'picked_at',// warehouse pulls order and hands to dispatch (picklist)
        'packed_at',// dispatch confirms order and packs order (delivery note)
        'shipped_at',// dispatch hands over to courier
        'completed_at',// order complete
    ];


    public function getStatus()
    {
        return match ($this->status) {
            "received" => "RECEIVED",
            "processed" => "PROCESSED",
            "packed" => "PACKED",
            "shipped" => "SHIPPED",
            "completed" => "COMPLETED",
        };
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(CustomerAddress::class, "address_id");
    }

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class, "delivery_type_id");
    }

    public function salesperson(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotal()
    {
        return $this->getSubTotal() + $this->delivery_charge;
    }

    public function getSubTotal()
    {
        return to_rands($this->items()->sum(DB::raw("price * qty")));
    }

    public function getCost()
    {
        return $this->items()->sum(DB::raw("cost * qty"));
    }

    public function updateStatus($status): static
    {
        $this->update(["status" => $status]);
        $this->update(["is_editing" => false]);

        return $this;
    }

    public function deliveryCharge(): Attribute
    {
        return new Attribute(
            get: fn($value) => to_rands($value),
            set: fn($value) => to_cents($value)
        );
    }

    public function number(): Attribute
    {
        return new Attribute(
            get: fn() => 'INV00' . $this->attributes['id']
        );
    }

    public function addItem($productId, $customer)
    {
        $product = Product::find($productId);

        $item = $this->items()->firstOrCreate(
            [
                "product_id" => $product->id,
            ],
            [
                "product_id" => $product->id,
                "type" => "product",
                "price" => $product->getPrice($customer),
                "cost" => $product->cost,
            ]
        );

        if ($item->qty < $item->product->qty()) {
            $item->increment("qty");
        }
    }

    public function verifyIfStockIsAvailable(): RedirectResponse|static
    {
        foreach ($this->items as $item) {
            if ($item->qty > $item->product->qty()) {
                $item->qty = $item->product->qty();
                $item->save();
                if ($item->qty == 0) {
                    $this->remove($item);
                }
            }
        }

        return $this;
    }

    public function updateDeliveryCharge(): static
    {
        $delivery = Delivery::find($this->delivery_type_id);

        $this->update([
            "delivery_charge" => $delivery->getPrice($this->getSubTotal()),
        ]);

        return $this;
    }

    public function decreaseStock(): static
    {
        foreach ($this->items as $item) {
            $item->product->stocks()->create([
                "type" => "invoice",
                "reference" => $this->number,
                "qty" => 0 - $item->qty,
                "cost" => $item->product->cost,
            ]);
        }

        return $this;
    }

    public function remove(OrderItem $item): static
    {
        $item->delete();

        return $this;
    }

    public function increase(OrderItem $item): static
    {
        if ($item->qty < $item->product->qty()) {
            $item->increment("qty");
        }

        return $this;
    }

    public function updateQty(OrderItem $item, $qty): static
    {
        if ($qty >= $item->product->qty()) {
            $qty = $item->product->qty();
        }

        $item->update(["qty" => $qty]);

        return $this;
    }

    public function decrease(OrderItem $item): static
    {
        $item->decrement("qty");

        if ($item->qty == 0) {
            $this->remove($item);
        }

        return $this;
    }

    public function cancel()
    {
        $this->delete();
    }

}
