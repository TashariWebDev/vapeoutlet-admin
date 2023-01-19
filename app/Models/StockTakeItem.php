<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\StockTakeItem
 *
 * @property int $id
 * @property int $stock_take_id
 * @property int $product_id
 * @property int|null $count
 * @property int $variance
 * @property int $cost
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Product|null $product
 * @property-read StockTake|null $stockTake
 *
 * @method static Builder|StockTakeItem newModelQuery()
 * @method static Builder|StockTakeItem newQuery()
 * @method static Builder|StockTakeItem query()
 * @method static Builder|StockTakeItem whereCost($value)
 * @method static Builder|StockTakeItem whereCount($value)
 * @method static Builder|StockTakeItem whereCreatedAt($value)
 * @method static Builder|StockTakeItem whereId($value)
 * @method static Builder|StockTakeItem whereProductId($value)
 * @method static Builder|StockTakeItem whereStockTakeId($value)
 * @method static Builder|StockTakeItem whereUpdatedAt($value)
 * @method static Builder|StockTakeItem whereVariance($value)
 * @mixin Eloquent
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
