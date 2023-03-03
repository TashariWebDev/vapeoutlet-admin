<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')->nullable();
            $table->string('created_by');
            $table->boolean('is_editing')->default(false);
            $table->timestamp('processed_at')->nullable();
            $table->foreignId('salesperson_id')->nullable();
            $table->integer('delivery_charge')->nullable();
            $table->unsignedBigInteger('sales_channel_id')->default(1);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('credits');
    }
};
