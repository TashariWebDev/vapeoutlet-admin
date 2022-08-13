<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            $brand->name = Str::title($brand->name);
        });

        static::saving(function ($brand) {
            $brand->name = Str::title($brand->name);
        });

        static::updating(function ($brand) {
            $brand->name = Str::title($brand->name);
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand', 'name');
    }
}
