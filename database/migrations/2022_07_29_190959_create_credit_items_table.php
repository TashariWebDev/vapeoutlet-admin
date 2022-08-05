<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('credit_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('credit_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id');
            $table->integer('qty')->unsigned()->default(0);
            $table->integer('price')->unsigned()->default(0);
            $table->integer('cost')->unsigned()->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('credit_items');
    }
};
