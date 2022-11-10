<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierCreditItem extends Model
{
    protected $guarded = [];

    protected $table = 'supplier_credit_items';

    protected $with = ['product.features'];

    public function supplier_credit(): BelongsTo
    {
        return $this->belongsTo(SupplierCredit::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function cost(): Attribute
    {
        return new Attribute(
            get: fn ($value) => (float) to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function decreaseStock(): static
    {
        foreach ($this->items as $item) {
            $item->product->stocks()->create([
                'type' => 'supplier credit',
                'reference' => $this->number,
                'qty' => 0 - $item->qty,
                'cost' => $item->product->cost,
            ]);
        }

        return $this;
    }

    public function getLineTotalAttribute(): float|int
    {
        return $this->qty * $this->cost;
    }
}
