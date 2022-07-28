<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('delivery_type_id')->nullable();
            $table->foreignId('address_id')->nullable();
            $table->foreignId('admin_id')->nullable(); // check if created by admin
            $table->foreignId('salesperson_id')->nullable();

            $table->boolean('is_editing')->default(true);
            $table->integer('delivery_charge')->nullable();
            $table->string('waybill')->nullable();

            $table->timestamp('placed_at')->nullable(); // order created
            $table->timestamp('processed_at')->nullable(); // order adjusted and sent to warehouse
            $table->timestamp('picked_at')->nullable(); // warehouse pulls order and hands to dispatch (picklist)
            $table->timestamp('packed_at')->nullable(); // dispatch confirms order and packs order (delivery note)
            $table->timestamp('shipped_at')->nullable(); // dispatch hands over to courier
            $table->timestamp('completed_at')->nullable(); // order complete

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
