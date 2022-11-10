<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id');
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->longText('body')->nullable();
            $table->boolean('is_private')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notes');
    }
};
