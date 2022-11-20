<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class Credit extends Model
{
    protected $guarded = [];

    protected $dates = [
        'processed_at', // order adjusted and sent to warehouse
    ];

    protected $with = ['items:id,product_id,credit_id,price,qty'];

    //    Relationships

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CreditItem::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    //    getters and setters

    public function getTotal()
    {
        return $this->getSubTotal() + $this->delivery_charge;
    }

    public function getSubTotal(): float
    {
        return to_rands($this->items()->sum(DB::raw('price * qty')));
    }

    public function getCost()
    {
        return to_rands($this->items()->sum(DB::raw('cost * qty')));
    }

    public function number(): Attribute
    {
        return new Attribute(get: fn () => 'CR00'.$this->attributes['id']);
    }

    public function addItem(Product $product)
    {
        $item = $this->items()->firstOrCreate(
            [
                'product_id' => $product->id,
            ],
            [
                'product_id' => $product->id,
                'price' => $product->getPrice($this->customer),
                'cost' => $product->cost,
            ]
        );

        $item->increment('qty');
    }

    public function increaseStock(): static
    {
        foreach ($this->items as $item) {
            $item->product->stocks()->updateOrCreate(
                [
                    'product_id' => $item->product_id,
                    'reference' => $this->number,
                ],
                [
                    'credit_id' => $this->id,
                    'type' => 'credit',
                    'reference' => $this->number,
                    'qty' => $item->qty,
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

    public function remove(CreditItem $item): static
    {
        $item->delete();

        return $this;
    }

    public function increase(CreditItem $item): static
    {
        $item->increment('qty');

        return $this;
    }

    public function updateQty(CreditItem $item, $qty): static
    {
        $item->update(['qty' => $qty]);

        return $this;
    }

    public function decrease(CreditItem $item): static
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

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print()
    {
        $view = view('templates.pdf.credit', [
            'credit' => $this,
        ])->render();

        $url = storage_path("app/public/documents/$this->number.pdf");

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

        return redirect("/storage/documents/$this->number.pdf");
    }
}
