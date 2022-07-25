<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->name = Str::title($category->name);
        });

        static::saving(function ($category) {
            $category->name = Str::title($category->name);
        });

        static::updating(function ($category) {
            $category->name = Str::title($category->name);
        });
    }
}
