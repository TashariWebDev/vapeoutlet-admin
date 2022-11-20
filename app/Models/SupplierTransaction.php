<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $purchase_id
 * @property-read \App\Models\Purchase|null $purchase
 * @property-read \App\Models\Supplier|null $supplier
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierTransaction whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierTransaction wherePurchaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierTransaction whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierTransaction whereRunningBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierTransaction whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierTransaction whereUuid($value)
 * @mixin \Eloquent
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

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
