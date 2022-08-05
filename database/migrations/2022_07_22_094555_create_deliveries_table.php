<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();

            $table->string('type');
            $table->longText('description');
            $table->integer('price')->unsigned();
            $table->integer('waiver_value')->nullable();
            $table->boolean('selectable')->default(false);
            $table->string('customer_type')->nullable();
            $table->string('province')->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
};
