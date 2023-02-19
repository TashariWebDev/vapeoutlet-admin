<?php

namespace App\Models;

use App\Notifications\StockAlertNotification;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
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

    public function qty()
    {
        return $this->stocks
            ->where(
                'sales_channel_id',
                '=',
                auth()
                    ->user()
                    ->defaultSalesChannel()->id
            )
            ->sum('qty');
    }

    public function qtyAvailableInWarehouse()
    {
        return $this->stocks->where('sales_channel_id', '=', 1)->sum('qty');
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

    public function oldWholesalePrice(): Attribute
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
            get: fn ($value) => 'storage/'.$value ?: '/images/no_image.jpeg'
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

    public function scopeWithStockCount($query)
    {
        return $query->withSum(
            [
                'stocks as total_available' => function ($query) {
                    $query->where(
                        'sales_channel_id',
                        auth()
                            ->user()
                            ->defaultSalesChannel()->id
                    );
                },
            ],
            'qty'
        );
    }

    public function scopeInStock($query)
    {
        $query->withWhereHas('stocks', function ($query) {
            $query
                ->where(
                    'sales_channel_id',
                    '=',
                    auth()
                        ->user()
                        ->defaultSalesChannel()->id
                )
                ->select(DB::raw('SUM(qty) AS available'))
                ->having('available', '>', 0);
        });

        return $query;
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

    public function lastPurchasePrice(): HasOne
    {
        return $this->hasOne(PurchaseItem::class)->latestOfMany();
    }

    public function getLastCost()
    {
        return $this->lastPurchasePrice?->total_cost_in_zar();
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

    public function stockTransferItems(): HasMany
    {
        return $this->hasMany(StockTransferItem::class);
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

    //  Checks to see if we have purchased this product previously and what is the cost of the product
    //  It averages the current cost of the product and new purchase cost
    //  If it is the first time purchasing , it returns the new purchase cost
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
            Notification::route('mail', $alert->email)->notify(
                new StockAlertNotification($this)
            );
        });
    }
}
