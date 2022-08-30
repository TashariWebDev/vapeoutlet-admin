<?php

namespace App\Models;

use App\Jobs\UpdateSupplierRunningBalanceJob;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierTransaction extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($transaction) {
            UpdateSupplierRunningBalanceJob::dispatch(
                $transaction->customer_id
            );
        });

        static::updated(function ($transaction) {
            UpdateSupplierRunningBalanceJob::dispatch(
                $transaction->customer_id
            );
        });
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function amount(): Attribute
    {
        return new Attribute(
            get: fn($value) => to_rands($value),
            set: fn($value) => to_cents($value)
        );
    }

    public function runningBalance(): Attribute
    {
        return new Attribute(
            get: fn($value) => to_rands($value),
            set: fn($value) => to_cents($value)
        );
    }
}
