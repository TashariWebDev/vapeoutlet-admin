<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stock_takes', function (Blueprint $table) {
            $table->unsignedBigInteger('sales_channel_id')->default(1);
        });
    }
};
