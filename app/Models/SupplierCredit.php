<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplierCredit extends Model
{
    protected $guarded = [];

    protected $table = 'supplier_credits';

    protected $dates = [
        'processed_at', // order adjusted and sent to warehouse
    ];

    //    Relationships

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SupplierCreditItem::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    //    getters and setters

    public function getTotal(): float
    {
        return $this->getSubTotal();
    }

    public function getSubTotal(): float
    {
        return to_rands($this->items()->sum(DB::raw('cost * qty')));
    }

    public function number(): Attribute
    {
        return new Attribute(get: fn () => 'SC00'.$this->attributes['id']);
    }

    public function addItem(Product $product, $supplier)
    {
        $item = $this->items()->firstOrCreate(
            [
                'product_id' => $product->id,
            ],
            [
                'product_id' => $product->id,
                'cost' => $product->cost,
            ]
        );

        $item->increment('qty');
    }

    public function decreaseStock(): static
    {
        foreach ($this->items as $item) {
            $item->product->stocks()->firstOrCreate(
                [
                    'product_id' => $item->product_id,
                    'reference' => $this->number,
                ],
                [
                    'credit_id' => $this->id,
                    'type' => 'supplier credit',
                    'reference' => $this->number,
                    'qty' => 0 - $item->qty,
                    'cost' => $item->product->cost,
                ]
            );
        }

        return $this;
    }

    public function updateStatus($status)
    {
        $this->update(["{$status}" => now()]);
    }

    public function remove(SupplierCreditItem $item): static
    {
        $item->delete();

        return $this;
    }

    public function increase(SupplierCreditItem $item): static
    {
        $item->increment('qty');

        return $this;
    }

    public function updateQty(SupplierCreditItem $item, $qty): static
    {
        $item->update(['qty' => $qty]);

        return $this;
    }

    public function decrease(SupplierCreditItem $item): static
    {
        $item->decrement('qty');

        if ($item->qty == 0) {
            $this->remove($item);
        }

        return $this;
    }

    public function cancel()
    {
        $this->delete();
    }
}
