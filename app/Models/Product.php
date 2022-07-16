<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'retail_price' => 'integer',
        'wholesale_price' => 'integer',
        'cost' => 'integer',
    ];
}
