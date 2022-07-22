<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCollection extends Model
{
    protected $guarded = [];

    //    events
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($collection) {
            $collection->name = Str::title($collection->name);
        });

        static::saving(function ($collection) {
            $collection->name = Str::title($collection->name);
        });

        static::updating(function ($collection) {
            $collection->name = Str::title($collection->name);
        });

        static::updated(function ($collection) {
            $collection->name = Str::title($collection->name);
        });
    }
}
