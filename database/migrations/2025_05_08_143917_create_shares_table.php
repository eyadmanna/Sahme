<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharesTable extends Migration
{
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('project_units')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('investor_id')->constrained('investors')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price_per_share', 15, 2);
            $table->decimal('total_amount', 15, 2);
            $table->string('payment_receipt', 255)->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->timestamp('approval_date')->nullable();
            $table->boolean('unit_sale_approval')->default(false);
            $table->foreignId('unit_sale_approved_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->dateTime('unit_sale_approval_date')->nullable();
            $table->integer('status_cd');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shares');
    }
}