<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\SupplierTransaction
 *
 * @property int $id
 * @property int $supplier_id
 * @property string $uuid
 * @property string $reference
 * @property string $type
 * @property int $amount
 * @property int $running_balance
 * @property string $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $purchase_id
 * @property-read Purchase|null $purchase
 * @property-read Supplier|null $supplier
 *
 * @method static Builder|SupplierTransaction newModelQuery()
 * @method static Builder|SupplierTransaction newQuery()
 * @method static Builder|SupplierTransaction query()
 * @method static Builder|SupplierTransaction whereAmount($value)
 * @method static Builder|SupplierTransaction whereCreatedAt($value)
 * @method static Builder|SupplierTransaction whereCreatedBy($value)
 * @method static Builder|SupplierTransaction whereId($value)
 * @method static Builder|SupplierTransaction wherePurchaseId($value)
 * @method static Builder|SupplierTransaction whereReference($value)
 * @method static Builder|SupplierTransaction whereRunningBalance($value)
 * @method static Builder|SupplierTransaction whereSupplierId($value)
 * @method static Builder|SupplierTransaction whereType($value)
 * @method static Builder|SupplierTransaction whereUpdatedAt($value)
 * @method static Builder|SupplierTransaction whereUuid($value)
 *
 * @mixin Eloquent
 */
class SupplierTransaction extends Model
{
    protected $guarded = [];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function amount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function runningBalance(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function scopeCurrentMonth($query)
    {
        return $query->whereDate('created_at', '>=', \Carbon\Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth());
    }

    public function scopePreviousMonth($query)
    {
        return $query->whereDate('created_at', '>=', \Carbon\Carbon::now()->subMonthNoOverflow()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->subMonthNoOverflow()->endOfMonth());
    }
}
