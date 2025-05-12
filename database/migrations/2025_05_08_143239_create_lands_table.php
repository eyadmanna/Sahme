<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandsTable extends Migration
{
    public function up()
    {
        Schema::create('lands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investor_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('governerate_cd');
            $table->integer('city_cd')->nullable();
            $table->integer('district_cd')->nullable();
            $table->text('address')->nullable();
            $table->decimal('area', 10, 2);
            $table->string('plot_number', 50)->nullable();
            $table->string('parcel_number', 50)->nullable();
            $table->integer('ownership_type_cd')->nullable();
            $table->text('borders')->nullable();
            $table->text('services')->nullable();
            $table->decimal('price', 15, 2);
            $table->foreignId('valuator_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->integer('valuation_status_cd')->nullable();
            $table->decimal('valuation_price', 15, 2)->nullable();
            $table->text('valuation_notes')->nullable();
            $table->foreignId('legal_partner_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->integer('legal_status_cd')->nullable();
            $table->text('legal_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lands');
    }
}