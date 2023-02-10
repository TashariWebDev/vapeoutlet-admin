<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            if (! Schema::hasColumns('customers', ['registered_company_name', 'alt_phone', 'cipc_documents', 'id_document', 'requested_wholesale_account'])) {
                $table->string('registered_company_name')->nullable();
                $table->string('alt_phone');
                $table->string('cipc_documents')->nullable();
                $table->string('id_document')->nullable();
                $table->boolean('requested_wholesale_account')->default(false);
            }
        });
    }
};
