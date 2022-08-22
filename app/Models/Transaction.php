<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Artisan;

class Transaction extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($transaction) {
            Artisan::call('update:transactions', [
                'customer' => $transaction->customer_id,
            ]);
        });

//            static::updated(function ($transaction) {
//                Artisan::call('update:transactions', [
//                    'customer' => $transaction->customer_id,
//                ]);
//            });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
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
