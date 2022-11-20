<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MarketingNotification
 *
 * @property int $id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MarketingNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketingNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketingNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketingNotification whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketingNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketingNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketingNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MarketingNotification extends Model
{
    protected $guarded = [];
}
