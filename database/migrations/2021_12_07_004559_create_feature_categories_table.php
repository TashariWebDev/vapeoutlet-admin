<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeatureCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create("feature_categories", function (Blueprint $table) {
            $table->bigIncrements("id");

            $table->string("name")->unique();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists("feature_categories");
    }
}
