<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * App\Models\Expense
 *
 * @property int $id
 * @property \App\Models\ExpenseCategory|null $category
 * @property string $reference
 * @property string|null $vat_number
 * @property string $invoice_no
 * @property int $amount
 * @property \Illuminate\Support\Carbon $date
 * @property int $taxable
 * @property string $created_by
 * @property \Illuminate\Support\Carbon|null $processed_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense query()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereInvoiceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereProcessedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereTaxable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereVatNumber($value)
 * @mixin \Eloquent
 */
class Expense extends Model
{
    protected $guarded = [];

    protected $dates = ['date', 'processed_date'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function amount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function description(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Str::title($value),
            set: fn ($value) => Str::title($value)
        );
    }
}
