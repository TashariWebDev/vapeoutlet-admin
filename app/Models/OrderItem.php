<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LaravelIdea\Helper\App\Models\_IH_Stock_QB;

/**
 * App\Models\OrderItem
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property string $type
 * @property int $qty
 * @property int $price
 * @property int $cost
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $product_price
 * @property int $discount
 * @property-read int|float $line_total
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Product|null $product
 *
 * @method static \Database\Factories\OrderItemFactory factory(...$parameters)
 * @method static Builder|OrderItem newModelQuery()
 * @method static Builder|OrderItem newQuery()
 * @method static Builder|OrderItem query()
 * @method static Builder|OrderItem whereCost($value)
 * @method static Builder|OrderItem whereCreatedAt($value)
 * @method static Builder|OrderItem whereDiscount($value)
 * @method static Builder|OrderItem whereId($value)
 * @method static Builder|OrderItem whereOrderId($value)
 * @method static Builder|OrderItem wherePrice($value)
 * @method static Builder|OrderItem whereProductId($value)
 * @method static Builder|OrderItem whereProductPrice($value)
 * @method static Builder|OrderItem whereQty($value)
 * @method static Builder|OrderItem whereType($value)
 * @method static Builder|OrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = [
        'product:id,name,brand,sku,retail_price,wholesale_price,cost',
    ];

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
