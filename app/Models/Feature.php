<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Feature extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($feature) {
            $feature->name = Str::title($feature->name);
        });

        static::saving(function ($feature) {
            $feature->name = Str::title($feature->name);
        });

        static::updating(function ($feature) {
            $feature->name = Str::title($feature->name);
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(FeatureCategory::class, 'feature_category_id');
    }

    public function product(): belongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
