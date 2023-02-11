<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Stock extends Model
{
    protected $guarded = [];

    public function reference(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Str::upper($value),
            set: fn ($value) => Str::upper($value)
        );
    }

    public function type(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Str::lower($value),
            set: fn ($value) => Str::lower($value)
        );
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

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function transfer(): BelongsTo
    {
        return $this->belongsTo(StockTransfer::class);
    }

    public function sales_channel(): BelongsTo
    {
        return $this->belongsTo(SalesChannel::class)->withTrashed();
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
