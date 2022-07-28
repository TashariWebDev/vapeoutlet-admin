<?php

namespace App\Models;

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

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function salesperson(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function total()
    {
//        sum of price * qty items
    }

    public function cost()
    {
//        sum of cost * qty items
    }

    public function number(): Attribute
    {
        return new Attribute(
            get: fn() => 'INV00' . $this->attributes['id']
        );
    }
}
