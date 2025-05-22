<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name_ar');
            $table->string('company_name_en');
            $table->string('country')->nullable();
            $table->string('currency_name')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('smtp_username')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('smtp_driver')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_email')->nullable();
            $table->string('sms_url')->nullable();
            $table->string('sms_to')->nullable();
            $table->string('sms_message')->nullable();
            $table->string('map_api_key')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('iban')->nullable();
            $table->integer('max_attachment_size')->default(2048); // in KB
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
