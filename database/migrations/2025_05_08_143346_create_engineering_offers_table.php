<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEngineeringOffersTable extends Migration
{
    public function up()
    {
        Schema::create('engineering_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('engineering_partner_id')->constrained('engineering_partners')->onUpdate('cascade')->onDelete('cascade');
            $table->text('technical_proposal');
            $table->text('financial_proposal');
            $table->decimal('total_price', 15, 2);
            $table->integer('duration');
            $table->longText('offer_notes')->nullable();
            $table->integer('status_cd')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('engineering_offers');
    }
}