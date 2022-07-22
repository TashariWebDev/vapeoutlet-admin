<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $with = ['features:id,name'];
    protected $casts = [
        'retail_price' => 'integer',
        'wholesale_price' => 'integer',
        'cost' => 'integer',
    ];

//    events
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name) . '-' . $product->sku;
            $product->name = Str::title($product->name);
            $product->category = Str::title($product->category);
            $product->brand = Str::title($product->brand);
        });

        static::saving(function ($product) {
            $product->slug = Str::slug($product->name) . '-' . $product->sku;
            $product->name = Str::title($product->name);
            $product->category = Str::title($product->category);
            $product->brand = Str::title($product->brand);
        });

        static::updating(function ($product) {
            $product->slug = Str::slug($product->name) . '-' . $product->sku;
            $product->name = Str::title($product->name);
            $product->category = Str::title($product->category);
            $product->brand = Str::title($product->brand);
        });

        static::updated(function ($product) {
            $product->slug = Str::slug($product->name) . '-' . $product->sku;
            $product->name = Str::title($product->name);
            $product->category = Str::title($product->category);
            $product->brand = Str::title($product->brand);
        });
    }

//    scopes
    public function scopeSearch($query, $searchQuery)
    {
        return $query->where('brand', 'like', $searchQuery . '%')
            ->orWhere('name', 'like', $searchQuery . '%')
            ->orWhere('sku', 'like', $searchQuery . '%')
            ->orWhere('id', 'like', $searchQuery . '%');
    }

//    setters
    public function retailPrice(): Attribute
    {
        return new Attribute(
            get: fn($value) => (float)to_rands($value),
            set: fn($value) => to_cents($value),
        );
    }

    public function wholesalePrice(): Attribute
    {
        return new Attribute(
            get: fn($value) => (float)to_rands($value),
            set: fn($value) => to_cents($value),
        );
    }

    public function cost(): Attribute
    {
        return new Attribute(
            get: fn($value) => (float)to_rands($value),
            set: fn($value) => to_cents($value),
        );
    }

    public function image(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value
                ? config('app.app_url') . '/storage/' . $value
                : config('app.app_url') . '/storage/images/default-image.png'
        );
    }

//    relationships

    public function last_purchase_price()
    {
        return $this->stocks()->latest('created_at')->value('cost');
    }

    public function product_collection(): BelongsTo
    {
        return $this->belongsTo(ProductCollection::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function features(): hasMany
    {
        return $this->hasMany(Feature::class);
    }

    public function purchases(): hasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function sold(): HasMany
    {
        return $this->hasMany(Stock::class)
            ->where('type', '=', 'invoice');
    }

    public function purchased(): HasMany
    {
        return $this->hasMany(Stock::class)
            ->where('type', '=', 'purchase');
    }

    public function returns(): HasMany
    {
        return $this->hasMany(Stock::class)
            ->where('type', '=', 'return');
    }

}
