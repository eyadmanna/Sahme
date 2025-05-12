<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectSpecificationsTable extends Migration
{
    public function up()
    {
        Schema::create('project_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->text('design_specs');
            $table->text('material_specs');
            $table->text('technical_requirements');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_specifications');
    }
}