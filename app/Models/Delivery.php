<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function price(): Attribute
    {
        return new Attribute(
            get: fn($value) => (float)to_rands($value),
            set: fn($value) => to_cents($value),
        );
    }

    public function waiverValue(): Attribute
    {
        return new Attribute(
            get: fn($value) => (float)to_rands($value),
            set: fn($value) => to_cents($value)
        );
    }
}
