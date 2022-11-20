<?php

namespace App\Models;

use App\Mail\StockAlertMail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Str;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function scopeSearch($query, $terms)
    {
        collect(explode(' ', $terms))
            ->filter()
            ->each(function ($term) use ($query) {
                $term = '%'.$term.'%';
                $query->where(function ($query) use ($term) {
                    $query
                        ->where('brand', 'like', $term)
                        ->orWhere('name', 'like', $term)
                        ->orWhere('category', 'like', $term)
                        ->orWhere('sku', 'like', $term)
                        ->orWhereIn('id', function ($query) use ($term) {
                            $query
                                ->select('product_id')
                                ->from('features')
                                ->where('name', 'like', $term);
                        });
                });
            });
    }

    //    setters
    public function qty()
    {
        return $this->stocks->sum('qty');
    }

    public function outOfStock()
    {
        return $this->qty() <= 0;
    }

    public function inStock()
    {
        return $this->qty() > 0;
    }

    public function fullName()
    {
        $features = $this->features()
            ->pluck('name')
            ->toArray();

        return $this->brand.' '.$this->name.' '.implode(' ', $features);
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

    public function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Str::title($value),
            set: fn ($value) => Str::title($value)
        );
    }

    public function retailPrice(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function wholesalePrice(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function oldRetailPrice(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function oldwholesalePrice(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function cost(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function image(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value
                ? config('app.app_url').'/storage/'.$value
                : config('app.app_url').'/storage/images/default-image.png'
        );
    }

    public function hasPriceDrop(): bool
    {
        if (auth()->check()) {
            if (auth()->user()->is_wholesale) {
                if (
                    $this->old_wholesale_price > 0 &&
                    $this->old_wholesale_price > $this->wholesale_price
                ) {
                    return true;
                }
            }
        }

        if (
            $this->old_retail_price > 0 &&
            $this->old_retail_price > $this->retail_price
        ) {
            return true;
        }

        return false;
    }

    public function scopeInStock($query)
    {
        $query->whereHas('stocks', function ($query) {
            $query
                ->select(DB::raw('SUM(qty) AS available'))
                ->having('available', '>', 0);
        });

        return $query;
    }

    public function last_purchase_price(): HasOne
    {
        return $this->hasOne(Stock::class)->latestOfMany();
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'name', 'brand');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'name', 'category');
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
        return $this->hasMany(Stock::class)->where('type', '=', 'invoice');
    }

    public function purchased(): HasMany
    {
        return $this->hasMany(Stock::class)->where('type', '=', 'purchase');
    }

    public function credits(): HasMany
    {
        return $this->hasMany(Stock::class)->where('type', '=', 'credit');
    }

    public function supplier_credit(): HasMany
    {
        return $this->hasMany(Stock::class)->where(
            'type',
            '=',
            'supplier credit'
        );
    }

    public function stockAlerts(): HasMany
    {
        return $this->hasMany(StockAlert::class);
    }

    public function averageCost(PurchaseItem $item)
    {
        $this->update([
            'cost' => $this->cost > 0
                    ? ($item->total_cost_in_zar() + $this->cost) / 2
                    : $item->total_cost_in_zar(),
        ]);
    }

    public function sendStockAlerts()
    {
        $this->stockAlerts->each(function ($alert) {
            Mail::to($alert->email)->later(
                now()->addMinutes(2),
                new StockAlertMail($this)
            );
        });
    }
}
