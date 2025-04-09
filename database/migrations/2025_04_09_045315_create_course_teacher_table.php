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
        Schema::create('course_teacher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained();
            $table->foreignId('teacher_id')->constrained();
            $table->integer('term')->comment('ترم ارائه');
            $table->integer('year')->comment('سال ارائه');
            $table->string('class_time')->nullable();
            $table->string('exam_time')->nullable();
            $table->timestamps();

            $table->unique(['course_id', 'teacher_id', 'term', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_teacher');
    }
};
