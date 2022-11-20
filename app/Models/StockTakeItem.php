<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\StockTakeItem
 *
 * @property int $id
 * @property int $stock_take_id
 * @property int $product_id
 * @property int|null $count
 * @property int $variance
 * @property int $cost
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\StockTake|null $stockTake
 *
 * @method static \Illuminate\Database\Eloquent\Builder|StockTakeItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockTakeItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockTakeItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|StockTakeItem whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTakeItem whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTakeItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTakeItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTakeItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTakeItem whereStockTakeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTakeItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockTakeItem whereVariance($value)
 * @mixin \Eloquent
 */
class StockTakeItem extends Model
{
    protected $guarded = [];

    public function cost(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function stockTake(): BelongsTo
    {
        return $this->belongsTo(StockTake::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
