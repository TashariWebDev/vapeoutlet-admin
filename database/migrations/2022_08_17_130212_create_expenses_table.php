<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->string('category')->index();
            $table->string('reference')->index();
            $table->string('vat_number')->nullable();
            $table->string('invoice_no');
            $table->integer('amount')->index();
            $table->date('date');
            $table->boolean('taxable')->default(true);
            $table->string('created_by');
            $table->timestamp('processed_date')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
