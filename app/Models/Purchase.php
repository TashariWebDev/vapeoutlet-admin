<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Purchase extends Model
{
    protected $guarded = [];

    protected $casts = ['date' => 'datetime'];

    protected $appends = ['total'];

    public function invoiceNo(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Str::upper($value),
            set: fn ($value) => Str::upper($value)
        );
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function getProcessedAttribute(): float|int
    {
        return ! $this->processed_date == null;
    }

    public function getTotalAttribute(): float|int
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->qty;
        });
    }

    public function shipping_cost(): float|int
    {
        if ($this->shipping_rate) {
            return ($this->amount * $this->shipping_rate) / 100;
        }

        return 0;
    }

    public function amount_converted_to_zar(): float|int
    {
        if ($this->exchange_rate) {
            return $this->amount * $this->exchange_rate;
        }

        return $this->amount;
    }

    public function total_cost_in_zar(): float|int
    {
        return $this->amount_converted_to_zar() + $this->shipping_cost();
    }

    public function amount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function exchangeRate(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function addItem(Product $product)
    {
        $item = $this->items()->firstOrCreate(
            [
                'product_id' => $product->id,
            ],
            [
                'product_id' => $product->id,
            ]
        );

        $item->increment('qty');
    }

    public function scopeCurrentMonth($query)
    {
        return $query->whereDate('processed_date', '>=', Carbon::now()->startOfMonth())
            ->whereDate('processed_date', '<=', Carbon::now()->endOfMonth());
    }

    public function scopePreviousMonth($query)
    {
        return $query->whereDate('processed_date', '>=', Carbon::now()->subMonthNoOverflow()->startOfMonth())
            ->whereDate('processed_date', '<=', Carbon::now()->subMonthNoOverflow()->endOfMonth());
    }
}
