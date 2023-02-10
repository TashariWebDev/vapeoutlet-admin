<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('customer_business_images')) {
            Schema::create('customer_business_images', function (Blueprint $table) {
                $table->id();

                $table->foreignIdFor(Customer::class);
                $table->string('photo');

                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('customer_business_images');
    }
};
