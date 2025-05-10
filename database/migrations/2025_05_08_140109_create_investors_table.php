<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestorsTable extends Migration
{
    public function up()
    {
        Schema::create('investors', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 100);
            $table->string('phone', 20)->nullable();
            $table->string('mobile', 20);
            $table->integer('governerate_cd');
            $table->integer('city_cd');
            $table->integer('district_cd')->nullable();
            $table->text('address')->nullable();
            $table->integer('status_cd');
            $table->string('email', 100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('investors');
    }
}