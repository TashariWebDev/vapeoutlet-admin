<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stock_take_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stock_take_id');
            $table->foreignId('product_id');
            $table->integer('count')->nullable();
            $table->integer('variance')->nullable(0);
            $table->integer('cost')->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_take_items');
    }
};
