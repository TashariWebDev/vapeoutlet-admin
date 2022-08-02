<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use JetBrains\PhpStorm\Pure;

class PurchaseItem extends Model
{
    protected $guarded = [];
    protected $with = ['product:id,name,brand,sku,cost', 'product.features'];
    protected $appends = ['line_total'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function getLineTotalAttribute(): float|int
    {
        return $this->qty * $this->price;
    }

    public function price(): Attribute
    {
        return new Attribute(
            get: fn($value) => (float)to_rands($value),
            set: fn($value) => (float)to_cents($value),
        );
    }

    public function shipping_cost(): float|int
    {
        if ($this->purchase->shipping_rate) {
            return ($this->price * $this->purchase->shipping_rate) / 100;
        }
        return 0;
    }

    public function amount_converted_to_zar(): float|int
    {
        if ($this->purchase->exchange_rate) {
            return ($this->price * $this->purchase->exchange_rate);
        }
        return $this->price;
    }

    #[Pure] public function total_cost_in_zar(): float|int
    {
        return $this->amount_converted_to_zar() + $this->shipping_cost();
    }
}
