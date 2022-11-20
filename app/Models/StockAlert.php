<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\StockAlert
 *
 * @property int $id
 * @property int $product_id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 *
 * @method static \Illuminate\Database\Eloquent\Builder|StockAlert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockAlert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockAlert query()
 * @method static \Illuminate\Database\Eloquent\Builder|StockAlert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockAlert whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockAlert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockAlert whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockAlert whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StockAlert extends Model
{
    protected $guarded = [];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
