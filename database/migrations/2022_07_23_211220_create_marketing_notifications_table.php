<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('marketing_notifications', function (Blueprint $table) {
            $table->id();

            $table->longText('body');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('marketing_notifications');
    }
};
