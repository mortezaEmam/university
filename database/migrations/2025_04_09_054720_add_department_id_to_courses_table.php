<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('department_id')
                ->after('id')
                ->comment('گروه آموزشی مربوطه')->constrained()
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['courses_department_id_foreign']);
            $table->dropColumn('department_id');
        });
    }
};
