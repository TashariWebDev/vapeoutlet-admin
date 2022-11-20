<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use JetBrains\PhpStorm\Pure;

/**
 * App\Models\PurchaseItem
 *
 * @property int $id
 * @property int $purchase_id
 * @property int $product_id
 * @property int $price
 * @property int $qty
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|float $line_total
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Purchase|null $purchase
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem wherePurchaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PurchaseItem extends Model
{
    protected $guarded = [];

    protected $appends = ['line_total'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
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
            get: fn ($value) => to_rands($value),
            set: fn ($value) => (float) to_cents($value)
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
            return $this->price * $this->purchase->exchange_rate;
        }

        return $this->price;
    }

    #[Pure]
    public function total_cost_in_zar(): float|int
    {
        return $this->amount_converted_to_zar() + $this->shipping_cost();
    }

    public function bringIntoStock()
    {
        $this->purchase->stocks()->firstOrCreate(
            [
                'product_id' => $this->product_id,
                'purchase_id' => $this->purchase->id,
            ],
            [
                'product_id' => $this->product_id,
                'type' => 'purchase',
                'reference' => $this->purchase->invoice_no,
                'qty' => $this->qty,
                'cost' => $this->total_cost_in_zar(),
            ]
        );
    }
}
