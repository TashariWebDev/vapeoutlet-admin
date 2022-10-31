<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table("credits", function (Blueprint $table) {
            $table->integer("delivery_charge")->nullable();
        });
    }
};
