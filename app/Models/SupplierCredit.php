<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\SupplierCredit
 *
 * @property int $id
 * @property int|null $supplier_id
 * @property string $created_by
 * @property int $is_editing
 * @property \Illuminate\Support\Carbon|null $processed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SupplierCreditItem[] $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stock[] $stocks
 * @property-read int|null $stocks_count
 * @property-read \App\Models\Supplier|null $supplier
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierCredit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierCredit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierCredit query()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierCredit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierCredit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierCredit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierCredit whereIsEditing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierCredit whereProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierCredit whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierCredit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SupplierCredit extends Model
{
    protected $guarded = [];

    protected $table = 'supplier_credits';

    protected $dates = [
        'processed_at', // order adjusted and sent to warehouse
    ];

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

    public function addItem(Product $product)
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
        $this->update(["$status" => now()]);
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
