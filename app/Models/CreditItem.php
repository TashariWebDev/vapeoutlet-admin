<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CreditItem
 *
 * @property int $id
 * @property int $credit_id
 * @property int $product_id
 * @property int $qty
 * @property int $price
 * @property int $cost
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|float $line_total
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\Product|null $product
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CreditItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditItem whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditItem whereCreditId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditItem whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CreditItem extends Model
{
    protected $guarded = [];

    protected $with = ['product.features'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function cost(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function price(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function increaseStock(): static
    {
        foreach ($this->items as $item) {
            $item->product->stocks()->create([
                'type' => 'credit',
                'reference' => $this->number,
                'qty' => $item->qty,
                'cost' => $item->product->cost,
            ]);
        }

        return $this;
    }

    public function getLineTotalAttribute(): float|int
    {
        return $this->qty * $this->price;
    }
}
