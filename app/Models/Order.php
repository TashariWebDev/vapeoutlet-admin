<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function deliveryCharge(): Attribute
    {
        return new Attribute(
            get: fn($value) => (float)to_rands($value),
            set: fn($value) => to_cents($value)
        );
    }

    public function number(): Attribute
    {
        return new Attribute(
            get: fn() => 'INV00' . $this->attributes['id']
        );
    }
}
