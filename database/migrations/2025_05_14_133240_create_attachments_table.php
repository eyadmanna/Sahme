<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->enum('reference_type', ['land','land_images']);
            $table->unsignedBigInteger('reference_id_fk')->index();
            $table->unsignedBigInteger('referenced_id_fk')->nullable()->index();
            $table->string('file_type')->nullable();
            $table->string('file_path'); // مسار الملف
            $table->string('file_title')->nullable();
            $table->string('file_description')->nullable();
            $table->integer('attachment_type_cd')->nullable()->index();
            $table->text('original_name')->nullable(); // الاسم الأصلي للملف عند الرفع
            $table->unsignedBigInteger('created_by')->nullable()->index(); // المستخدم الذي رفع الملف
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
