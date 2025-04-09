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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('student_number')->unique()->comment('شماره دانشجویی');
            $table->string('father_name');
            $table->date('birth_date');
            $table->string('address');
            $table->string('major')->comment('رشته تحصیلی');
            $table->integer('entry_year')->comment('سال ورود');
            $table->enum('level', ['bachelor', 'master', 'phd'])->default('bachelor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
