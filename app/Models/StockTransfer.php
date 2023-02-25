<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class StockTransfer extends Model
{
    protected $guarded = [];

    protected $casts = ['date' => 'datetime'];

    public function receiver()
    {
        return $this->belongsTo(SalesChannel::class)->withTrashed();
    }

    public function dispatcher()
    {
        return $this->belongsTo(SalesChannel::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function items()
    {
        return $this->hasMany(StockTransferItem::class);
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function getTotal()
    {
        return $this->items->reduce(function ($carry, $item) {
            return (float) $carry + $item->getLineTotal();
        }, 0);
    }

    public function markAsProcessed()
    {
        $this->is_processed = true;
        $this->save();
    }

    public function isProcessed()
    {
        return $this->is_processed;
    }

    public function cancel()
    {
        $this->delete();
    }

    public function addItem(Product $product)
    {
        $item = $this->items()->firstOrCreate(
            [
                'product_id' => $product->id,
            ],
            [
                'product_id' => $product->id,
            ]
        );

        $item->increment('qty');
    }

    public function transferStock()
    {
        foreach ($this->items as $item) {
            Stock::firstOrCreate(
                [
                    'product_id' => $item->product->id,
                    'reference' => $this->number(),
                    'sales_channel_id' => $this->receiver_id,
                    'stock_transfer_id' => $this->id,
                ],
                [
                    'type' => 'transfer',
                    'qty' => $item->qty,
                    'cost' => $item->product->cost,
                ]
            );

            Stock::firstOrCreate(
                [
                    'product_id' => $item->product->id,
                    'reference' => $this->number(),
                    'sales_channel_id' => $this->dispatcher_id,
                    'stock_transfer_id' => $this->id,
                ],
                [
                    'type' => 'transfer',
                    'qty' => 0 - $item->qty,
                    'cost' => $item->product->cost,
                ]
            );
        }
    }

    public function number()
    {
        return 'TRN00'.$this->id;
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print()
    {
        $document = $this->number();
        $view = view('templates.pdf.stock-transfer', [
            'transfer' => $this,
        ])->render();

        $url = storage_path(
            'app/public/'.
                config('app.storage_folder').
                "/documents/$document.pdf"
        );

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->showBrowserHeaderAndFooter()
            ->setScreenshotType('pdf', 60)
            ->save($url);

        return redirect(
            '/storage/'.
                config('app.storage_folder').
                "/documents/$document.pdf"
        );
    }
}
