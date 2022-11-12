<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LaravelIdea\Helper\App\Models\_IH_Stock_QB;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function stock(): Stock|Builder|_IH_Stock_QB|null
    {
        return Stock::query()
            ->where('product_id', '=', $this->product_id)
            ->where('order_id', '=', $this->order_id);
    }

    public function cost(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function getDiscount()
    {
        return $this->product_price - $this->price;
    }

    public function price(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function productPrice(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function discount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function getPrice($customer = null)
    {
        $user = $customer ?? auth()->user();

        if (auth()->check() && $user->is_wholesale) {
            return $this->product->wholesale_price;
        }

        return $this->product->retail_price;
    }

    public function getLineTotalAttribute(): float|int
    {
        return $this->qty * $this->price;
    }
}
