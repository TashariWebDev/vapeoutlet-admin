<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Str;

class Transaction extends Model
{
    protected $guarded = [];

    protected $casts = ['date' => 'datetime'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderTotal()
    {
        $orderId = Str::after($this->reference, 'INV00');

        return Order::where('id', $orderId)->first()?->getTotal();
    }

    public function amount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function runningBalance(): Attribute
    {
        return new Attribute(
            get: fn ($value) => to_rands($value),
            set: fn ($value) => to_cents($value)
        );
    }

    public function number(): Attribute
    {
        return new Attribute(get: fn () => 'TR00'.$this->attributes['id']);
    }

    public function scopeCurrentMonth($query)
    {
        return $query->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth());
    }

    public function scopePreviousMonth($query)
    {
        return $query->whereDate('created_at', '>=', Carbon::now()->subMonth()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->subMonth()->endOfMonth());
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function print()
    {
        $view = view('templates.pdf.transaction', [
            'transaction' => $this,
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
}
