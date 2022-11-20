<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CustomerAddress
 *
 * @property int $id
 * @property int $customer_id
 * @property string $line_one
 * @property string|null $line_two
 * @property string|null $suburb
 * @property string $city
 * @property string $province
 * @property string $postal_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddress newQuery()
 * @method static \Illuminate\Database\Query\Builder|CustomerAddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddress whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddress whereLineOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddress whereLineTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddress wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddress whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddress whereSuburb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CustomerAddress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CustomerAddress withoutTrashed()
 * @mixin \Eloquent
 */
class CustomerAddress extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
