<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->index();
            $table->string('type'); // simple/bundle,
            $table->integer('qty')->unsigned()->default(0)->index();
            $table->integer('price')->unsigned()->default(0)->index();
            $table->integer('cost')->unsigned()->default(0);
            $table
                ->integer('product_price')
                ->unsigned()
                ->default(0);
            $table
                ->integer('discount')
                ->unsigned()
                ->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
