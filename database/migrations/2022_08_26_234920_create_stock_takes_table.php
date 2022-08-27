<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create("stock_takes", function (Blueprint $table) {
            $table->id();

            $table->date("date")->default(now());
            $table->date("processed_at")->nullable();
            $table->string("brand")->nullable();
            $table->string("created_by")->nullable();
            $table->string("processed_by")->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists("stock_takes");
    }
};
