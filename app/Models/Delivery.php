<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\Delivery
 *
 * @property int $id
 * @property string $type
 * @property string $description
 * @property int $price
 * @property int|null $waiver_value
 * @property int $selectable
 * @property string|null $customer_type
 * @property string|null $province
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery newQuery()
 * @method static Builder|Delivery onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery query()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereCustomerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereSelectable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereWaiverValue($value)
 * @method static Builder|Delivery withTrashed()
 * @method static Builder|Delivery withoutTrashed()
 *
 * @mixin Eloquent
 */
class Delivery extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'delivery_type_id');
    }

    public function price(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function getPrice($total): int
    {
        if ($this->waiver_value > 0 && $total > $this->waiver_value) {
            return 0;
        }

        return $this->price;
    }

    public function waiverValue(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }
}
