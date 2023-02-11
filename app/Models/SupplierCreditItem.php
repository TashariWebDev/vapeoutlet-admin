<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\SupplierCreditItem
 *
 * @property int $id
 * @property int $supplier_credit_id
 * @property int $product_id
 * @property int $qty
 * @property int $cost
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read int|float $line_total
 * @property-read Product|null $product
 * @property-read SupplierCredit $supplier_credit
 *
 * @method static Builder|SupplierCreditItem newModelQuery()
 * @method static Builder|SupplierCreditItem newQuery()
 * @method static Builder|SupplierCreditItem query()
 * @method static Builder|SupplierCreditItem whereCost($value)
 * @method static Builder|SupplierCreditItem whereCreatedAt($value)
 * @method static Builder|SupplierCreditItem whereId($value)
 * @method static Builder|SupplierCreditItem whereProductId($value)
 * @method static Builder|SupplierCreditItem whereQty($value)
 * @method static Builder|SupplierCreditItem whereSupplierCreditId($value)
 * @method static Builder|SupplierCreditItem whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class SupplierCreditItem extends Model
{
    protected $guarded = [];

    protected $table = 'supplier_credit_items';

    protected $with = ['product.features'];

    public function supplier_credit(): BelongsTo
    {
        return $this->belongsTo(SupplierCredit::class);
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

    public function decreaseStock(): static
    {
        foreach ($this->items as $item) {
            $item->product->stocks()->create([
                'type' => 'supplier credit',
                'reference' => $this->number,
                'qty' => 0 - $item->qty,
                'cost' => $item->product->cost,
            ]);
        }

        return $this;
    }

    public function getLineTotalAttribute(): float|int
    {
        return $this->qty * $this->cost;
    }
}
