<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeachersTableSeeder extends Seeder
{
    public function run()
    {
        $teachers = [
            [
                'user_id' => 2, // مطابق با ID کاربر استاد اول
                'teacher_code' => 'T1001',
                'degree' => 'دکتری',
                'field' => 'هوش مصنوعی',
                'rank' => 'استادیار',
                'department_id' => 1, // مهندسی کامپیوتر
                'bio' => 'استاد دانشگاه با تخصص در هوش مصنوعی و یادگیری ماشین'
            ],
            [
                'user_id' => 3, // مطابق با ID کاربر استاد دوم
                'teacher_code' => 'T1002',
                'degree' => 'دکتری',
                'field' => 'شبکه‌های کامپیوتری',
                'rank' => 'استاد',
                'department_id' => 1, // مهندسی کامپیوتر
                'bio' => 'استاد دانشگاه با تخصص در شبکه‌های کامپیوتری و امنیت'
            ],
        ];

        Teacher::insert($teachers);
    }
}
