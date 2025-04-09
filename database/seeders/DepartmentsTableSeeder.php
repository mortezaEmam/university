<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            // دانشکده مهندسی
            [
                'faculty_id' => 1,
                'code' => 'CE',
                'name' => 'مهندسی کامپیوتر',
                'head' => 'دکتر حسینی',
                'description' => 'گروه مهندسی کامپیوتر با گرایش‌های نرم‌افزار و سخت‌افزار'
            ],
            [
                'faculty_id' => 1,
                'code' => 'EE',
                'name' => 'مهندسی برق',
                'head' => 'دکتر کریمی',
                'description' => 'گروه مهندسی برق با گرایش‌های مختلف'
            ],

            // دانشکده علوم پایه
            [
                'faculty_id' => 2,
                'code' => 'MATH',
                'name' => 'ریاضیات',
                'head' => 'دکتر فلانی',
                'description' => 'گروه ریاضیات محض و کاربردی'
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
