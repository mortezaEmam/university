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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('course_teacher_id')->constrained('course_teacher'); // مشخص کردن نام جدول
            $table->float('grade')->nullable()->comment('نمره نهایی');
            $table->enum('status', ['passed', 'failed', 'incomplete'])->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'course_teacher_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
