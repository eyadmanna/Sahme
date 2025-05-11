<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnershipTransfersTable extends Migration
{
    public function up()
    {
        Schema::create('ownership_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('share_id')->constrained('shares')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('from_investor_id')->constrained('investors')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('to_investor_id')->constrained('investors')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('quantity');
            $table->string('transfer_document', 255)->nullable();
            $table->integer('status_cd')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->timestamp('approval_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ownership_transfers');
    }
}