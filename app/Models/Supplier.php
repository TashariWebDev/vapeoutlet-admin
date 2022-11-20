<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Supplier extends Model
{
    protected $guarded = [];

    public function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Str::title($value),
            set: fn ($value) => Str::title($value)
        );
    }

    public function person(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Str::title($value),
            set: fn ($value) => Str::title($value)
        );
    }

    public function email(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Str::lower($value),
            set: fn ($value) => Str::lower($value)
        );
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class)->orderBy('created_at', 'desc');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class)->orderBy('created_at', 'desc');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(SupplierTransaction::class);
    }

    public function latestTransaction(): HasOne
    {
        return $this->hasOne(SupplierTransaction::class)->latestOfMany();
    }

    public function getRunningBalance()
    {
        if ($this->transactions()->count() == 1) {
            $transaction = $this->transactions()->first();
            if ($transaction->running_balance == 0) {
                return $transaction->amount;
            }
        }

        return $this->latestTransaction()->value('running_balance') ?? 0;
    }

    public function createCredit(
        SupplierCredit $credit,
        $reference
    ): SupplierTransaction|Model {
        return $this->transactions()->firstOrCreate(
            [
                'reference' => $reference,
                'type' => 'supplier credit',
                'amount' => 0 - $credit->getTotal(),
                'created_by' => auth()->user()->name,
            ],
            [
                'reference' => $reference,
                'type' => 'supplier credit',
                'amount' => 0 - $credit->getTotal(),
                'created_by' => auth()->user()->name,
            ]
        );
    }

    public function createTransactionFrom(Purchase $purchase)
    {
        return $this->transactions()->firstOrCreate(
            [
                'purchase_id' => $purchase->id,
                'supplier_id' => $this->id,
            ],
            [
                'reference' => $purchase->invoice_no,
                'supplier_id' => $purchase->supplier_id,
                'amount' => $purchase->amount_converted_to_zar(),
                'type' => 'purchase',
                'running_balance' => 0,
                'created_by' => auth()->user()->name,
            ]
        );
    }

    //    scopes
    public function scopeSearch($query, $terms)
    {
        collect(explode(' ', $terms))
            ->filter()
            ->each(function ($term) use ($query) {
                $term = '%'.$term.'%';
                $query
                    ->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('phone', 'like', $term)
                    ->orWhere('person', 'like', $term)
                    ->orWhere('city', 'like', $term);
            });
    }

    public function scopeCreditors($query)
    {
        return $query->withWhereHas('latestTransaction', function ($query) {
            $query->where('running_balance', '!=', 0);
        });
    }
}
