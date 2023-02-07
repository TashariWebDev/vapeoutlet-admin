<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('brand')->index();
            $table->string('category');
            $table->string('image')->nullable();
            $table
                ->string('sku')
                ->nullable()
                ->unique()
                ->index();
            $table->longText('description')->nullable();

            $table->integer('retail_price')->default(0);
            $table->integer('old_retail_price')->default(0);
            $table->integer('wholesale_price')->default(0);
            $table->integer('old_wholesale_price')->default(0);
            $table->integer('cost')->default(0);

            $table->boolean('is_active')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_sale')->default(false);

            $table->foreignId('product_collection_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
