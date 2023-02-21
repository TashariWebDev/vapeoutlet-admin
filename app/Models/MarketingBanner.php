<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\MarketingBanner
 *
 * @property int $id
 * @property string $image
 * @property int|null $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|MarketingBanner newModelQuery()
 * @method static Builder|MarketingBanner newQuery()
 * @method static Builder|MarketingBanner query()
 * @method static Builder|MarketingBanner whereCreatedAt($value)
 * @method static Builder|MarketingBanner whereId($value)
 * @method static Builder|MarketingBanner whereImage($value)
 * @method static Builder|MarketingBanner whereOrder($value)
 * @method static Builder|MarketingBanner whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class MarketingBanner extends Model
{
    protected $guarded = [];

    public function image(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value ?: '/images/no_image.jpeg'
        );
    }
}
