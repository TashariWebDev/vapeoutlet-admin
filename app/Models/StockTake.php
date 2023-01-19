<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class StockTake extends Model
{
    protected $guarded = [];

    protected $dates = ['date'];

    public function items(): HasMany
    {
        return $this->hasMany(StockTakeItem::class);
    }

    public function sales_channel(): BelongsTo
    {
        return $this->belongsTo(SalesChannel::class);
    }

    public function getTotal(): float
    {
        return to_rands($this->items()->sum(DB::raw('variance * cost')));
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

        $url = storage_path("app/public/stock-takes/$this->number.pdf");

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
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function printCountSheet()
    {
        $view = view('templates.pdf.stock-count', [
            'stockTake' => $this,
        ])->render();

        $url = storage_path("app/public/stock-counts/$this->number.pdf");

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
    }
}
