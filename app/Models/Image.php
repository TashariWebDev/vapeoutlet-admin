<?php

namespace App\Models;

use Database\Factories\ImageFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Image
 *
 * @property int $id
 * @property int $product_id
 * @property string $url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Product|null $product
 *
 * @method static ImageFactory factory(...$parameters)
 * @method static Builder|Image newModelQuery()
 * @method static Builder|Image newQuery()
 * @method static Builder|Image query()
 * @method static Builder|Image whereCreatedAt($value)
 * @method static Builder|Image whereId($value)
 * @method static Builder|Image whereProductId($value)
 * @method static Builder|Image whereUpdatedAt($value)
 * @method static Builder|Image whereUrl($value)
 *
 * @mixin Eloquent
 */
class Image extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function url(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value ?: '/images/no_image.jpeg'
        );
    }
}
