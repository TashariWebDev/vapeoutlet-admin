<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditItem extends Model
{
    protected $guarded = [];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function cost(): Attribute
    {
        return new Attribute(
            get: fn($value) => (float)to_rands($value),
            set: fn($value) => to_cents($value)
        );
    }

    public function price(): Attribute
    {
        return new Attribute(
            get: fn($value) => (float)to_rands($value),
            set: fn($value) => to_cents($value)
        );
    }

    public function getLineTotalAttribute(): float|int
    {
        return $this->qty * $this->price;
    }
}
