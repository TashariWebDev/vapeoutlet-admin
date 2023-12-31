<?php

namespace App\Models;

use App\Exceptions\QtyNotAvailableException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = [
        'items:id,product_id,order_id,price,qty,discount,product_price',
    ];

    protected $casts = ['created_at', 'updated_at'];

    public function getStatus(): string
    {
        return match ($this->status) {
            'received' => 'RECEIVED',
            'processed' => 'PROCESSED',
            'packed' => 'PACKED',
            'shipped' => 'SHIPPED',
            'completed' => 'COMPLETED',
        };
    }

    public function isProcessed(): bool
    {
        if ($this->status === 'received') {
            return true;
        }

        return false;
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(
            CustomerAddress::class,
            'address_id'
        )->withTrashed();
    }

    public function scopeCurrentMonth($query)
    {
        return $query->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth());
    }

    public function scopePreviousMonth($query)
    {
        return $query->whereDate('created_at', '>=',
            Carbon::now()->subMonthNoOverflow()->startOfMonth())
            ->whereDate('created_at', '<=',
                Carbon::now()->subMonthNoOverflow()->endOfMonth());
    }

    public function scopeSales($query)
    {
        return $query->where('status', '!=', 'cancelled')
            ->whereNotNull('status');
    }

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class, 'delivery_type_id')->withTrashed();
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function salesperson(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sales_channel(): BelongsTo
    {
        return $this->belongsTo(SalesChannel::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function updateStatus($status): static
    {
        $this->update([
            'status' => $status,
        ]);

        return $this;
    }

    public function deliveryCharge(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function number(): Attribute
    {
        return new Attribute(get: fn () => 'INV00'.$this->attributes['id']);
    }

    public function addItem(Product $product): void
    {
        $item = $this->items()->firstOrCreate(
            [
                'product_id' => $product->id,
            ],
            [
                'product_id' => $product->id,
                'type' => 'product',
                'price' => $product->getPrice($this->customer),
                'product_price' => $product->getPrice($this->customer),
                'cost' => $product->cost,
            ]
        );

        if ($item->qty < $item->product->qty()) {
            $item->increment('qty');
            $item->save();
        }
    }

    /**
     * @throws QtyNotAvailableException
     */
    public function verifyIfStockIsAvailable(): void
    {
        foreach ($this->items as $item) {
            $availableStock = $item->product->stocks()
                ->where(
                    'sales_channel_id',
                    '=',
                    $this->sales_channel_id
                )
                ->sum('qty');

            if ($item->qty > $availableStock) {
                throw new QtyNotAvailableException(
                    'Products no longer available'
                );
            }
        }
    }

    public function updateDeliveryCharge(): static
    {
        $delivery = Delivery::find($this->delivery_type_id);

        $this->update([
            'delivery_charge' => $delivery->getPrice($this->getSubTotal()),
        ]);

        return $this;
    }

    public function decreaseStock(): static
    {
        foreach ($this->items as $item) {
            $item->product->stocks()->updateOrCreate(
                [
                    'order_id' => $this->id,
                    'type' => 'invoice',
                    'reference' => $this->number,
                ],
                [
                    'order_id' => $this->id,
                    'type' => 'invoice',
                    'reference' => $this->number,
                    'qty' => 0 - $item->qty,
                    'cost' => $item->product->cost,
                    'sales_channel_id' => $this->sales_channel_id,
                ]
            );
        }

        return $this;
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function increase(OrderItem $item): static
    {
        if ($item->qty < $item->product->qty()) {
            $item->increment('qty');
        }

        return $this;
    }

    public function updateQty(OrderItem $item, $qty): static
    {
        if ($qty >= $item->product->qty()) {
            $qty = $item->product->qty();
        }

        $item->update(['qty' => $qty]);

        return $this;
    }

    public function decrease(OrderItem $item): static
    {
        $item->decrement('qty');

        if ($item->qty == 0) {
            $this->remove($item);
        }

        return $this;
    }

    public function remove(OrderItem $item): static
    {
        $item->delete();

        return $this;
    }

    public function cancel(): void
    {
        $this->delete();
    }

    public function scopeSearch($query, $terms): void
    {
        collect(explode(' ', $terms))
            ->filter()
            ->each(function ($term) use ($query) {
                $term = '%'.$term.'%';
                $query->where(function ($query) use ($term) {
                    $query
                        ->where('id', 'like', $term)
                        ->orWhereHas('customer', function ($query) use ($term) {
                            $query
                                ->where('name', 'like', $term)
                                ->orWhere('company', 'like', $term);
                        });
                });
            });
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print()
    {
        $view = view('templates.pdf.invoice', [
            'order' => $this,
        ])->render();

        $url = storage_path(
            'app/public/'.
            config('app.storage_folder').
            "/documents/$this->number.pdf"
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

        return redirect(
            '/storage/'.
            config('app.storage_folder').
            "/documents/$this->number.pdf"
        );
    }

    public function getTotal()
    {
        return $this->getSubTotal() + $this->delivery_charge;
    }

    public function getSubTotal(): float
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->qty;
        });
    }

    public function getCost(): float
    {
        return $this->items->sum(function ($item) {
            return $item->cost * $item->qty;
        });
    }

    public function getProfit(): float
    {
        return $this->getTotal() - $this->getCost();
    }

    public function getProfitLessShipping(): float
    {
        return $this->getSubTotal() - $this->getCost();
    }
}
