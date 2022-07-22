<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            $table->foreignId('supplier_id');
            $table->string('invoice_no');
            $table->integer('amount');
            $table->date('date');
            $table->unsignedDecimal('shipping_rate')->nullable();
            $table->integer('exchange_rate')->nullable();
            $table->string('currency');
            $table->foreignId('creator_id');
            $table->timestamp('processed_date')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchases');
    }
};
