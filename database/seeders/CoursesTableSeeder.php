<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    public function run()
    {
        $courses = [
            [
                'course_code' => 'CS101',
                'title' => 'مبانی برنامه‌نویسی',
                'credit' => 3,
                'department_id' => 1,
                'description' => 'آشنایی با مفاهیم پایه برنامه‌نویسی'
            ],
            [
                'course_code' => 'CS201',
                'title' => 'پایگاه داده',
                'credit' => 3,
                'department_id' => 1,
                'description' => 'مفاهیم پایگاه داده و طراحی آن'
            ],
            [
                'course_code' => 'CS301',
                'title' => 'هوش مصنوعی',
                'credit' => 3,
                'department_id' => 1,
                'description' => 'آشنایی با مفاهیم هوش مصنوعی'
            ],
        ];

        Course::insert($courses);
    }
}
