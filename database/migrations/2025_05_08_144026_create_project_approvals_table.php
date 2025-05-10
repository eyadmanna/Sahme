<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectApprovalsTable extends Migration
{
    public function up()
    {
        Schema::create('project_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('approval_type', ['design', 'financial', 'execution']);
            $table->foreignId('approved_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_approvals');
    }
}