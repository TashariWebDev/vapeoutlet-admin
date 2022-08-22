<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "email",
        "phone",
        "company",
        "vat_number",
        "is_wholesale",
        "password",
        "salesperson_id",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "email_verified_at" => "datetime",
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->name = Str::title($user->name);
            $user->email = Str::lower($user->email);
        });

        static::saving(function ($user) {
            $user->name = Str::title($user->name);
            $user->email = Str::lower($user->email);
        });

        static::updating(function ($user) {
            $user->name = Str::title($user->name);
            $user->email = Str::lower($user->email);
        });
    }

    public function isWholesale(): string
    {
        return !$this->is_wholesale ? "" : "(wholesale)";
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function salesperson(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Transaction::class)->where(
            "type",
            "=",
            "invoice"
        );
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Transaction::class)->where(
            "type",
            "=",
            "payment"
        );
    }

    public function credits(): HasMany
    {
        return $this->hasMany(Transaction::class)->where("type", "=", "credit");
    }

    public function debits(): HasMany
    {
        return $this->hasMany(Transaction::class)->where("type", "=", "debit");
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Transaction::class)->where("type", "=", "refund");
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function latestTransaction(): HasOne
    {
        return $this->hasOne(Transaction::class)->latestOfMany();
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

    public function createDebit($reference, $amount, $createdBy): Transaction
    {
        return $this->transactions()->firstOrCreate([
            "uuid" => Str::uuid(),
            "reference" => $reference,
            "type" => "debit",
            "amount" => $amount,
            "created_by" => $createdBy,
        ]);
    }

    public function createCredit(Credit $credit, $reference): Model|Transaction
    {
        return $this->transactions()->firstOrCreate([
            "uuid" => Str::uuid(),
            "reference" => $reference,
            "type" => "credit",
            "amount" => 0 - $credit->getTotal(),
            "created_by" => auth()->user()->name,
        ]);
    }

    public function createInvoice(Order $order): Model|Transaction
    {
        return $this->transactions()->create([
            "uuid" => Str::uuid(),
            "reference" => $order->number,
            "type" => "invoice",
            "amount" => $order->getTotal(),
            "created_by" => auth()->user()->name,
        ]);
    }

    public function scopeDebtors($query)
    {
        return $query->withWhereHas("latestTransaction", function ($query) {
            $query->where("running_balance", "!=", 0);
        });
    }

    public function scopeSearch($query, $terms)
    {
        collect(explode(" ", $terms))
            ->filter()
            ->each(function ($term) use ($query) {
                $term = "%" . $term . "%";
                $query->where(function ($query) use ($term) {
                    $query
                        ->where("name", "like", $term)
                        ->orWhere("email", "like", $term)
                        ->orWhere("phone", "like", $term)
                        ->orWhere("company", "like", $term)
                        ->orWhereHas("addresses", function ($query) use (
                            $term
                        ) {
                            $query
                                ->where("suburb", "like", $term)
                                ->orWhere("city", "like", $term)
                                ->orWhere("province", "like", $term);
                        });
                });
            });
    }
}
