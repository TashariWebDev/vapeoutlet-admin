<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class FeatureCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->name = Str::lower($category->name);
        });

        static::saving(function ($category) {
            $category->name = Str::lower($category->name);
        });

        static::updating(function ($category) {
            $category->name = Str::lower($category->name);
        });
    }

    public function features(): hasMany
    {
        return $this->hasMany(Feature::class);
    }
}
