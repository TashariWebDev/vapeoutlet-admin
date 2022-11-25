<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\Pure;

/**
 * App\Models\PurchaseItem
 *
 * @property int $id
 * @property int $purchase_id
 * @property int $product_id
 * @property int $price
 * @property int $qty
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read int|float $line_total
 * @property-read Product|null $product
 * @property-read Purchase|null $purchase
 *
 * @method static Builder|PurchaseItem newModelQuery()
 * @method static Builder|PurchaseItem newQuery()
 * @method static Builder|PurchaseItem query()
 * @method static Builder|PurchaseItem whereCreatedAt($value)
 * @method static Builder|PurchaseItem whereId($value)
 * @method static Builder|PurchaseItem wherePrice($value)
 * @method static Builder|PurchaseItem whereProductId($value)
 * @method static Builder|PurchaseItem wherePurchaseId($value)
 * @method static Builder|PurchaseItem whereQty($value)
 * @method static Builder|PurchaseItem whereUpdatedAt($value)
 * @mixin Eloquent
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
                'outlet_id' => 1,
            ]
        );
    }
}
