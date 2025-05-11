<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEngineeringPartnersTable extends Migration
{
    public function up()
    {
        Schema::create('engineering_partners', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 100);
            $table->string('phone', 20)->nullable();
            $table->string('mobile', 20);
            $table->integer('province_cd');
            $table->integer('city_cd');
            $table->integer('district_cd')->nullable();
            $table->string('address', 200)->nullable();
            $table->integer('experience_years')->nullable();
            $table->string('commercial_registration_number', 50)->nullable();
            $table->string('tax_number', 50)->nullable();
            $table->text('specializations')->nullable();
            $table->text('company_profile')->nullable();
            $table->text('commercial_registration')->nullable();
            $table->text('liecence')->nullable();
            $table->text('tax_record')->nullable();
            $table->text('previous_projects')->nullable();
            $table->integer('status_cd');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->timestamp('approval_date')->nullable();
            $table->string('email', 50)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('password', 255)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('otp_code')->nullable();
            $table->timestamp('otp_code_expires_at')->nullable();
            $table->tinyInteger('is_authapp_enabled')->default(0)->comment('Use Authenticator App: 0 Disabled, 1 Enabled');
            $table->string('authapp_secret')->nullable()->comment('Secret of Authenticator App');
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('engineering_partners');
    }
}