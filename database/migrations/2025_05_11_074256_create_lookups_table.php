<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLookupsTable extends Migration
{
    public function up()
    {
        Schema::create('lookups', function (Blueprint $table) {
            $table->id();
            $table->integer('is_managed')->default(0);
            $table->integer('parent_id')->nullable();
            $table->string('master_key', 255);
            $table->string('item_key', 255)->nullable();
            $table->string('name_ar', 255);
            $table->string('name_en', 255)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('extra_1', 255)->nullable();
            $table->string('extra_2', 255)->nullable();
            $table->string('extra_3', 255)->nullable();
            $table->string('extra_4', 255)->nullable();
            $table->string('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['master_key', 'item_key']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('lookups');
    }
}