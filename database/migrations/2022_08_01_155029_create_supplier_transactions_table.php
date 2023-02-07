<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('supplier_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('supplier_id');
            $table->string('reference');
            $table->string('type');
            $table->integer('amount');
            $table->integer('running_balance')->default(0);
            $table->string('created_by');
            $table->foreignId('purchase_id')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supplier_transactions');
    }
};
