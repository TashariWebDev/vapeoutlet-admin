<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Stock extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($stock) {
            $stock->reference = Str::upper($stock->reference);
            $stock->type = Str::lower($stock->type);
        });

        static::saving(function ($stock) {
            $stock->reference = Str::upper($stock->reference);
            $stock->type = Str::lower($stock->type);
        });

        static::updating(function ($stock) {
            $stock->reference = Str::upper($stock->reference);
            $stock->type = Str::lower($stock->type);
        });
    }

    public function cost(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function credit(): BelongsTo
    {
        return $this->belongsTo(Credit::class);
    }

    public function supplier_credit(): BelongsTo
    {
        return $this->belongsTo(SupplierCredit::class);
    }

    public function getTotal(): float|int
    {
        return $this->qty * $this->cost;
    }
}
