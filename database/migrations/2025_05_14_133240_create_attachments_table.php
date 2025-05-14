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
            $table->unsignedBigInteger('land_id')->nullable()->index(); // رابط الأرض
            $table->string('file_path'); // مسار الملف
            $table->string('type')->nullable(); // نوع المرفق (مثلاً ownership_certification, legal_document)
            $table->string('original_name')->nullable(); // الاسم الأصلي للملف عند الرفع
            $table->unsignedBigInteger('uploaded_by')->nullable()->index(); // المستخدم الذي رفع الملف
            $table->timestamps();

            // علاقات مفتاحية (اختياري)
            $table->foreign('land_id')->references('id')->on('lands')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
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
