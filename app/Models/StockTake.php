<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockTake extends Model
{
    protected $guarded = [];
    protected $dates = ["date"];

    public function items(): HasMany
    {
        return $this->hasMany(StockTakeItem::class);
    }

    public function getTotal(): float
    {
        return to_rands($this->items()->sum(DB::raw("variance * cost")));
    }
}
