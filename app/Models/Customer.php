<?php

namespace App\Models;

use App\Notifications\Api\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class Customer extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'alt_phone',
        'company',
        'registered_company_name',
        'vat_number',
        'is_wholesale',
        'password',
        'salesperson_id',
        'requested_wholesale_account',
        'id_document',
        'cipc_documents',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'id_document',
        'cipc_documents',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $url =
            config('app.frontend_url').
            "/reset-password/$token?email=".
            $this->email;

        $this->notify(new ResetPasswordNotification($url));
    }

    public function name(): Attribute
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

    public function isWholesale(): string
    {
        return ! $this->is_wholesale ? '' : '(wholesale)';
    }

    public function type(): string
    {
        return ! $this->is_wholesale ? 'retail' : 'wholesale';
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function businessImages(): HasMany
    {
        return $this->hasMany(CustomerBusinessImage::class);
    }

    public function salesperson(): BelongsTo
    {
        return $this->belongsTo(User::class)
            ->where('is_super_admin', false)
            ->withDefault([
                'name' => '',
            ]);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Transaction::class)->where(
            'type',
            '=',
            'invoice'
        );
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Transaction::class)->where(
            'type',
            '=',
            'payment'
        );
    }

    public function credits(): HasMany
    {
        return $this->hasMany(Transaction::class)->where('type', '=', 'credit');
    }

    public function debits(): HasMany
    {
        return $this->hasMany(Transaction::class)->where('type', '=', 'debit');
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Transaction::class)->where('type', '=', 'refund');
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

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class)->latest();
    }

    public function lastFiveTransactions(): hasMany
    {
        return $this->hasMany(Transaction::class)
            ->latest()
            ->take(5);
    }

    public function latestTransaction(): HasOne
    {
        return $this->hasOne(Transaction::class)->latestOfMany();
    }

    public function createDebit($reference, $amount, $createdBy): Transaction
    {
        return $this->transactions()->updateOrCreate(
            [
                'reference' => $reference,
                'type' => 'debit',
            ],
            [
                'reference' => $reference,
                'type' => 'debit',
                'amount' => $amount,
                'created_by' => $createdBy,
            ]
        );
    }

    public function createCredit(Credit $credit, $reference): Model|Transaction
    {
        return $this->transactions()->updateOrCreate(
            [
                'reference' => $reference,
                'type' => 'credit',
            ],
            [
                'reference' => $reference,
                'type' => 'credit',
                'amount' => 0 - $credit->getTotal(),
                'created_by' => auth()->user()->name,
            ]
        );
    }

    public function createInvoice(Order $order): Model|Transaction
    {
        return $this->transactions()->updateOrCreate(
            [
                'reference' => $order->number,
                'type' => 'invoice',
            ],
            [
                'reference' => $order->number,
                'type' => 'invoice',
                'amount' => $order->getTotal(),
                'created_by' => auth()->user()->name,
            ]
        );
    }

    public function statement(): Attribute
    {
        return new Attribute(get: fn () => 'STMT00'.$this->attributes['id']);
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getStatement($numberOfRecords)
    {
        $view = view('templates.pdf.statement', [
            'customer' => $this,
            'transactions' => $this->transactions()
                ->latest('id')
                ->take($numberOfRecords)
                ->get(),
        ])->render();

        $url = storage_path(
            'app/public/'.
                config('app.storage_folder').
                "/documents/$this->statement.pdf"
        );

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 60)
            ->save($url);
    }

    public function scopeDebtors($query)
    {
        return $query->withWhereHas('latestTransaction', function ($query) {
            $query->where('running_balance', '!=', 0);
        });
    }

    public function scopeSearch($query, $terms)
    {
        collect(explode(' ', $terms))
            ->filter()
            ->each(function ($term) use ($query) {
                $term = '%'.$term.'%';
                $query->where(function ($query) use ($term) {
                    $query
                        ->where('name', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('phone', 'like', $term)
                        ->orWhere('company', 'like', $term)
                        ->orWhereHas('addresses', function ($query) use (
                            $term
                        ) {
                            $query
                                ->where('city', 'like', $term)
                                ->orWhere('province', 'like', $term);
                        });
                });
            });
    }
}
