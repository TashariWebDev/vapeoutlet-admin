<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')->nullable();
            $table->foreignId('delivery_type_id')->nullable();
            $table->foreignId('address_id')->nullable();
            $table->string('processed_by')->nullable();
            $table->foreignId('salesperson_id')->nullable();

            $table->boolean('is_editing')->default(true);

            $table->integer('delivery_charge')->nullable();
            $table->string('waybill')->nullable();

            $table->string('status')->nullable(); // order created

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
