<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supplier_transactions', function (Blueprint $table) {
            $table->date('date')->nullable();
            $table->longText('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('supplier_transactions', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('description');
        });
    }
};
