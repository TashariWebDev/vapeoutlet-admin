<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('system_settings')) {
            Schema::create('system_settings', function (Blueprint $table) {
                $table->id();

                $table->string('company_name')->nullable();
                $table->longText('address_line_one')->nullable();
                $table->longText('address_line_two')->nullable();
                $table->longText('suburb')->nullable();
                $table->longText('city')->nullable();
                $table->longText('province')->nullable();
                $table->longText('postal_code')->nullable();
                $table->longText('country')->nullable();
                $table->longText('email_address')->nullable();
                $table->longText('phone')->nullable();

                $table->longText('bank_name')->nullable();
                $table->longText('bank_account_name')->nullable();
                $table->longText('bank_branch')->nullable();
                $table->longText('bank_branch_no')->nullable();
                $table->longText('bank_account_no')->nullable();

                $table->longText('vat_registration_number')->nullable();
                $table->longText('company_registration_number')->nullable();

                $table->longText('logo')->nullable();

                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('system_settings');
    }
};
