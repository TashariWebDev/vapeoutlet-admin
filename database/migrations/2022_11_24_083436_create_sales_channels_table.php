<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sales_channels', function (Blueprint $table) {
            $table->id();

            $table
                ->string('name')
                ->unique()
                ->index();
            $table->boolean('is_locked_for_deletion')->default(false); // Default warehouse
            $table->boolean('allows_shipping')->default(false); // counter sales updates status to shipped

            $table->timestamps();
        });
    }
};
