<?php

namespace Database\Seeders;

use App\Models\CourseTeacher;
use Illuminate\Database\Seeder;

class CourseTeacherTableSeeder extends Seeder
{
    public function run()
    {
        $courseTeachers = [
            [
                'course_id' => 1,
                'teacher_id' => 1,
                'term' => 1,
                'year' => 1401,
                'class_time' => 'شنبه و سه‌شنبه 8-10'
            ],
            [
                'course_id' => 2,
                'teacher_id' => 2,
                'term' => 1,
                'year' => 1401,
                'class_time' => 'یکشنبه و چهارشنبه 10-12'
            ],
            [
                'course_id' => 3,
                'teacher_id' => 1,
                'term' => 2,
                'year' => 1401,
                'class_time' => 'دوشنبه و پنجشنبه 14-16'
            ],
        ];

        CourseTeacher::insert($courseTeachers);
    }
}
