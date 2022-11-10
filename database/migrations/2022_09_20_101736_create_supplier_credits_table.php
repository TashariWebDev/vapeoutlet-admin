<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('supplier_credits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('supplier_id')->nullable();
            $table->string('created_by');
            $table->boolean('is_editing')->default(true);
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();
        });
    }
};
