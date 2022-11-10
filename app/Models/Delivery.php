<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
            get: fn ($value) => (float) to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function getPrice($total)
    {
        if ($this->waiver_value > 0 && $total > $this->waiver_value) {
            return 0;
        }

        return $this->price;
    }

    public function waiverValue(): Attribute
    {
        return new Attribute(
            get: fn ($value) => (float) to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }
}
