<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectUnitsTable extends Migration
{
    public function up()
    {
        Schema::create('project_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('parent_id')->comment('0: item is Floor, else: item is unit related to floor in parent_id');
            $table->integer('description')->nullable();
            $table->integer('unit_type_cd')->nullable();
            $table->decimal('area', 10, 2)->nullable();
            $table->integer('rooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->text('finishing_details')->nullable();
            $table->decimal('valuation_price', 15, 2)->nullable();
            $table->foreignId('valuator_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->integer('total_shares')->nullable();
            $table->decimal('share_price', 15, 2)->default(1000.00);
            $table->decimal('estimated_construction_cost', 15, 2)->nullable();
            $table->decimal('estimated_profit', 15, 2)->nullable();
            $table->decimal('sale_price', 15, 2)->nullable();
            $table->foreignId('sale_approved_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('unit_status_cd')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_units');
    }
}