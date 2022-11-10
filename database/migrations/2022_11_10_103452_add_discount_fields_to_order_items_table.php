<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table
                ->integer('product_price')
                ->unsigned()
                ->default(0);
            $table
                ->integer('discount')
                ->unsigned()
                ->default(0);
        });
    }
};
