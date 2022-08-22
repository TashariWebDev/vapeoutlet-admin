<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table("products", function (Blueprint $table) {
            $table->index("brand");
            $table->index("sku");
        });
    }

    public function down()
    {
        Schema::table("products", function (Blueprint $table) {
            $table->dropIndex(["brand"]);
            $table->dropIndex(["sku"]);
        });
    }
};