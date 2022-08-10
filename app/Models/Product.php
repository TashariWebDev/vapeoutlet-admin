<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes, HasFactory;

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
            $product->slug = Str::slug($product->brand) . '-' . Str::slug($product->name) . '-' . $product->sku;
            $product->name = Str::title($product->name);
            $product->category = Str::title($product->category);
            $product->brand = Str::title($product->brand);
        });

        static::saving(function ($product) {
            $product->slug = Str::slug($product->brand) . '-' . Str::slug($product->name) . '-' . $product->sku;
            $product->name = Str::title($product->name);
            $product->category = Str::title($product->category);
            $product->brand = Str::title($product->brand);
        });

        static::updating(function ($product) {
            $product->slug = Str::slug($product->brand) . '-' . Str::slug($product->name) . '-' . $product->sku;
            $product->name = Str::title($product->name);
            $product->category = Str::title($product->category);
            $product->brand = Str::title($product->brand);
        });

        static::updated(function ($product) {
            $product->slug = Str::slug($product->brand) . '-' . Str::slug($product->name) . '-' . $product->sku;
            $product->name = Str::title($product->name);
            $product->category = Str::title($product->category);
            $product->brand = Str::title($product->brand);
        });
    }

//    scopes
    public function scopeSearch($query, $searchQuery)
    {
        return $query
            ->where('brand', 'like', $searchQuery . '%')
            ->orWhere('name', 'like', $searchQuery . '%')
            ->orWhere('sku', 'like', $searchQuery . '%')
            ->orWhere('id', 'like', $searchQuery . '%')
            ->orWhereHas('features', function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%');
            });
    }

//    setters

    public function qty()
    {
        return $this->stocks->sum('qty');
    }

    public function getPrice(Customer $customer)
    {
        if ($customer->is_wholesale) {
            return $this->wholesale_price;
        }

        return $this->retail_price;
    }

    public function getPriceByRole(Customer $customer)
    {
        if ($customer->is_wholesale) {
            return $this->wholesale_price;
        }

        return $this->retail_price;
    }

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

    public function oldRetailPrice(): Attribute
    {
        return new Attribute(
            get: fn($value) => (float)to_rands($value),
            set: fn($value) => to_cents($value),
        );
    }

    public function oldwholesalePrice(): Attribute
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

    public function hasPriceDrop(): bool
    {
        if (auth()->check()) {
            if (auth()->user()->is_wholesale) {
                if ($this->old_wholesale_price > 0 && $this->old_wholesale_price > $this->wholesale_price) {
                    return true;
                }
            }
        }

        if ($this->old_retail_price > 0 && $this->old_retail_price > $this->retail_price) {
            return true;
        }

        return false;
    }

//    relationships

//    public function last_purchase_price()
//    {
//        return $this->stocks->latest('created_at')->value('cost');
//    }

    public function last_purchase_price(): HasOne
    {
        return $this->hasOne(Stock::class)->latestOfMany();
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'name');
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
        return $this->hasMany(Feature::class)->orderBy('feature_category_id');
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

    public function stockAlerts(): HasMany
    {
        return $this->hasMany(StockAlert::class);
    }
}
