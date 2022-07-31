<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId("customer_id");
            $table->uuid("uuid");
            $table->string("reference");
            $table->string("type");
            $table->integer("amount");
            $table->integer("running_balance")
                ->nullable()
                ->default(0);
            $table->string("created_by");


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
