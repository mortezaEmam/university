<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        $students = [
            [
                'user_id' => 4, // مطابق با ID کاربر دانشجوی اول
                'student_number' => '96012345',
                'father_name' => 'محمد',
                'birth_date' => '1998-05-15',
                'address' => 'تهران، خیابان آزادی',
                'major' => 'مهندسی نرم‌افزار',
                'department_id' => 1, // مهندسی کامپیوتر
                'entry_year' => 1396,
                'level' => 'bachelor'
            ],
            [
                'user_id' => 5, // مطابق با ID کاربر دانشجوی دوم
                'student_number' => '96012346',
                'father_name' => 'رضا',
                'birth_date' => '1999-03-22',
                'address' => 'تهران، خیابان انقلاب',
                'major' => 'مهندسی سخت‌افزار',
                'department_id' => 1, // مهندسی کامپیوتر
                'entry_year' => 1396,
                'level' => 'bachelor'
            ],
        ];

        Student::insert($students);
    }
}
