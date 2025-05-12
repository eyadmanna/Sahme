<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investor_id')->nullable()->constrained('investors')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->integer('type_cd');
            $table->foreignId('unit_id')->nullable()->constrained('project_units')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('reference_id')->nullable();
            $table->integer('status')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}