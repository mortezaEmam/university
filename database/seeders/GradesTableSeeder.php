<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradesTableSeeder extends Seeder
{
    public function run()
    {
        $grades = [
            [
                'student_id' => 1,
                'course_teacher_id' => 1,
                'grade' => 18.5,
                'status' => Grade::STATUS_FINALIZED,
                'comments' => 'پروژه نهایی خوبی ارائه داد'
            ],
            [
                'student_id' => 2,
                'course_teacher_id' => 1,
                'grade' => 16,
                'status' => Grade::STATUS_REVIEWING,
                'comments' => 'نیاز به تلاش بیشتر دارد'
            ],
            [
                'student_id' => 1,
                'course_teacher_id' => 2,
                'grade' => 19,
                'status' => Grade::STATUS_PENDING,
                'comments' => 'عالی عملکرد'
            ],
        ];

        Grade::insert($grades);
    }
}
