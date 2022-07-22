<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $guarded = [];

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class)->orderBy('created_at', 'desc');
    }

    //    scopes
    public function scopeSearch($query, $searchQuery)
    {
        return $query->where('name', 'like', $searchQuery . '%')
            ->orWhere('email', 'like', $searchQuery . '%')
            ->orWhere('phone', 'like', $searchQuery . '%')
            ->orWhere('person', 'like', $searchQuery . '%')
            ->orWhere('city', 'like', $searchQuery . '%');
    }
}
