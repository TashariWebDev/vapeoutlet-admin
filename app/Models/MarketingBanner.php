<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MarketingBanner
 *
 * @property int $id
 * @property string $image
 * @property int|null $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MarketingBanner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketingBanner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketingBanner query()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketingBanner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketingBanner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketingBanner whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketingBanner whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketingBanner whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MarketingBanner extends Model
{
    protected $guarded = [];
}
