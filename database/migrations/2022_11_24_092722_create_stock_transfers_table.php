<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('dispatcher_id');
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('date');
            $table->boolean('is_processed')->default(false);

            $table->timestamps();
        });
    }
};
