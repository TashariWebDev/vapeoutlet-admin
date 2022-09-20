<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create("supplier_credit_items", function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId("supplier_credit_id")
                ->constrained()
                ->onDelete("cascade");
            $table->foreignId("product_id");
            $table
                ->integer("qty")
                ->unsigned()
                ->default(0);
            $table
                ->integer("cost")
                ->unsigned()
                ->default(0);

            $table->timestamps();
        });
    }
};
