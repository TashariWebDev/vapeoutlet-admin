<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Supplier extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->name = Str::title($user->name);
            $user->person = Str::title($user->person);
            $user->email = Str::lower($user->email);
        });

        static::saving(function ($user) {
            $user->name = Str::title($user->name);
            $user->person = Str::title($user->person);
            $user->email = Str::lower($user->email);
        });

        static::updating(function ($user) {
            $user->name = Str::title($user->name);
            $user->person = Str::title($user->person);
            $user->email = Str::lower($user->email);
        });
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class)->orderBy("created_at", "desc");
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class)->orderBy("created_at", "desc");
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(SupplierTransaction::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(SupplierTransaction::class)->where(
            "type",
            "=",
            "purchase"
        );
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SupplierTransaction::class)->where(
            "type",
            "=",
            "payment"
        );
    }

    public function credits(): HasMany
    {
        return $this->hasMany(SupplierTransaction::class)->where(
            "type",
            "=",
            "supplier credit"
        );
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

        return $this->latestTransaction()->value("running_balance") ?? 0;
    }

    public function createCredit(
        SupplierCredit $credit,
        $reference
    ): SupplierTransaction|Model {
        return $this->transactions()->firstOrCreate(
            [
                "uuid" => Str::uuid(),
                "reference" => $reference,
                "type" => "supplier credit",
                "amount" => 0 - $credit->getTotal(),
                "created_by" => auth()->user()->name,
            ],
            [
                "uuid" => Str::uuid(),
                "reference" => $reference,
                "type" => "supplier credit",
                "amount" => 0 - $credit->getTotal(),
                "created_by" => auth()->user()->name,
            ]
        );
    }

    //    scopes
    public function scopeSearch($query, $terms)
    {
        collect(explode(" ", $terms))
            ->filter()
            ->each(function ($term) use ($query) {
                $term = "%" . $term . "%";
                $query
                    ->where("name", "like", $term)
                    ->orWhere("email", "like", $term)
                    ->orWhere("phone", "like", $term)
                    ->orWhere("person", "like", $term)
                    ->orWhere("city", "like", $term);
            });
    }

    public function scopeCreditors($query)
    {
        return $query->withWhereHas("latestTransaction", function ($query) {
            $query->where("running_balance", "!=", 0);
        });
    }
}
