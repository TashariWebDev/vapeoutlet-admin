<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->index();
            $table->string('type');
            $table->string('reference')->nullable();
            $table->integer('qty')->index();
            $table->integer('cost');
            $table->foreignId('order_id')->nullable();
            $table->foreignId('credit_id')->nullable();
            $table->foreignId('purchase_id')->nullable();
            $table->foreignId('supplier_credit_id')->nullable();

            $table
                ->foreignId('sales_channel_id')
                ->default(1)
                ->index();

            $table->unsignedBigInteger('stock_transfer_id')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stocks');
    }
};
