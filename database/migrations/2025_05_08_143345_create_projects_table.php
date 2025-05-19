<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('land_id')->constrained('lands')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('creator_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->integer('project_type_cd');
            $table->decimal('area', 10, 2);
            $table->decimal('project_cost', 15, 2);
            $table->foreignId('engineering_consultant_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->integer('engineering_consultant_evaluation_status_cd')->nullable();
            $table->text('engineering_consultant_evaluation_notes')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->integer('approval_status_cd')->nullable();
            $table->text('decline_reasons')->nullable();
            $table->integer('project_status_cd')->nullable();
            $table->date('offers_start_date');
            $table->date('offers_end_date');
            //$table->foreignId('awarded_engineering_offer_id')->nullable()->constrained('engineering_offers')->onUpdate('cascade')->onDelete('set null');
            $table->integer('awarded_engineering_offer_id')->nullable();
            $table->foreignId('awarded_engineering_added_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->timestamp('awarded_engineering_date')->nullable();
            $table->text('awarded_engineering_reasons')->nullable();
            $table->integer('awarded_engineering_creator_approval_cd')->nullable();
            $table->timestamp('awarded_engineering_creator_approval_date')->nullable();
            //$table->foreignId('awarded_contractor_offer_id')->nullable()->constrained('contractor_offers')->onUpdate('cascade')->onDelete('set null');
            $table->integer('awarded_contractor_offer_id')->nullable();
            $table->foreignId('awarded_contractor_added_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->timestamp('awarded_contractor_date')->nullable();
            $table->text('awarded_contractor_reasons')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
}