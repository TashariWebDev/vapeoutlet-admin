<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class SalesChannel extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function isLocked()
    {
        return $this->is_locked_for_deletion;
    }

    public function allowsShipping()
    {
        return $this->allows_shipping;
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeHasStock($query)
    {
        $query->whereHas('stocks', function ($query) {
            $query
                ->select(DB::raw('SUM(qty) AS available'))
                ->having('available', '>', 0);
        });

        return $query;
    }
}
