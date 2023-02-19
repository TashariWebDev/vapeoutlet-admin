<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class StockTake extends Model
{
    protected $guarded = [];

    protected $casts = ['date' => 'datetime'];

    public function items(): HasMany
    {
        return $this->hasMany(StockTakeItem::class);
    }

    public function sales_channel(): BelongsTo
    {
        return $this->belongsTo(SalesChannel::class)->withTrashed();
    }

    public function getTotal(): float
    {
        return $this->items->sum(function ($item) {
            return $item->variance * $item->cost;
        });
    }

    public function getCount(): float
    {
        return $this->items()->sum('variance');
    }

    public function number(): Attribute
    {
        return new Attribute(get: fn () => 'ST00'.$this->attributes['id']);
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print()
    {
        $view = view('templates.pdf.stock-take', [
            'stockTake' => $this,
        ])->render();

        $name = 'STK-'.$this->number;

        $url = storage_path(
            'app/public/'.
                config('app.storage_folder').
                "/documents/$name.pdf"
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
            '/storage/'.config('app.storage_folder')."/documents/$name.pdf"
        );
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function printCountSheet()
    {
        $view = view('templates.pdf.stock-count', [
            'stockTake' => $this,
        ])->render();

        $name = 'CS-'.$this->number;
        $url = storage_path(
            'app/public/'.
                config('app.storage_folder').
                "/documents/$name.pdf"
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
            '/storage/'.config('app.storage_folder')."/documents/$name.pdf"
        );
    }
}
