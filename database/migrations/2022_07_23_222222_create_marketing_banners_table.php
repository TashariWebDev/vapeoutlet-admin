<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('marketing_banners', function (Blueprint $table) {
            $table->id();

            $table->string('image');
            $table->integer('order')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('marketing_banners');
    }
};
