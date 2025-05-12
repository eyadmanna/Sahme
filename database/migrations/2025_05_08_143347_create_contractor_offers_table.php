<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorOffersTable extends Migration
{
    public function up()
    {
        Schema::create('contractor_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('contractor_id')->constrained('contractors')->onUpdate('cascade')->onDelete('cascade');
            $table->text('technical_proposal')->nullable();
            $table->text('financial_proposal')->nullable();
            $table->decimal('total_price', 15, 2);
            $table->integer('duration');
            $table->longText('offer_notes')->nullable();
            $table->integer('status_cd')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contractor_offers');
    }
}