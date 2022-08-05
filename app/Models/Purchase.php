<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Purchase extends Model
{
    protected $guarded = [];

    protected $with = [
        'items:id,product_id,purchase_id,price,qty',
        'supplier:id,name',
    ];

    protected $dates = ['date'];

    protected $appends = ['total'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($purchase) {
            $purchase->invoice_no = Str::upper($purchase->invoice_no);
        });

        static::saving(function ($purchase) {
            $purchase->invoice_no = Str::upper($purchase->invoice_no);
        });

        static::updating(function ($purchase) {
            $purchase->invoice_no = Str::upper($purchase->invoice_no);
        });
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
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
            set: fn ($value) => to_cents($value),
        );
    }

    public function exchangeRate(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value),
        );
    }
}
