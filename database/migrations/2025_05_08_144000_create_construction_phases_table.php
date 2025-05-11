<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstructionPhasesTable extends Migration
{
    public function up()
    {
        Schema::create('construction_phases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('contractor_id')->constrained('contractors')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 100);
            $table->text('description');
            $table->integer('duration_days');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('estimated_cost', 15, 2);
            $table->integer('phase_approval_status_cd')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->integer('phase_progress_status_cd')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('approval_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('construction_phases');
    }
}