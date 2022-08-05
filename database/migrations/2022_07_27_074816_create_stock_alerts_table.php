<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stock_alerts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id');
            $table->text('email');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_alerts');
    }
};
