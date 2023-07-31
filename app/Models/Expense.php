<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * App\Models\Expense
 *
 * @property int $id
 * @property ExpenseCategory|null $category
 * @property string $reference
 * @property string|null $vat_number
 * @property string $invoice_no
 * @property int $amount
 * @property Carbon $date
 * @property int $taxable
 * @property string $created_by
 * @property Carbon|null $processed_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Expense newModelQuery()
 * @method static Builder|Expense newQuery()
 * @method static Builder|Expense query()
 * @method static Builder|Expense whereAmount($value)
 * @method static Builder|Expense whereCategory($value)
 * @method static Builder|Expense whereCreatedAt($value)
 * @method static Builder|Expense whereCreatedBy($value)
 * @method static Builder|Expense whereDate($value)
 * @method static Builder|Expense whereId($value)
 * @method static Builder|Expense whereInvoiceNo($value)
 * @method static Builder|Expense whereProcessedDate($value)
 * @method static Builder|Expense whereReference($value)
 * @method static Builder|Expense whereTaxable($value)
 * @method static Builder|Expense whereUpdatedAt($value)
 * @method static Builder|Expense whereVatNumber($value)
 *
 * @mixin Eloquent
 */
class Expense extends Model
{
    protected $guarded = [];

    protected $casts = ['date' => 'datetime', 'processed_date' => 'datetime'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function scopeCurrentMonth($query)
    {
        return $query->whereDate('date', '>=', \Carbon\Carbon::now()->startOfMonth())
            ->whereDate('date', '<=', Carbon::now()->endOfMonth());
    }

    public function scopePreviousMonth($query)
    {
        return $query->whereDate('date', '>=', \Carbon\Carbon::now()->subMonthNoOverflow()->startOfMonth())
            ->whereDate('date', '<=', Carbon::now()->subMonthNoOverflow()->endOfMonth());
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
