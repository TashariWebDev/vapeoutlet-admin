<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function url(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value
                ? config('app.app_url') . '/storage/' . $value
                : config('app.app_url') . '/storage/images/default-image.png'
        );
    }
}
