<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;

class FacultiesTableSeeder extends Seeder
{
    public function run()
    {
        $faculties = [
            [
                'code' => 'ENG',
                'name' => 'دانشکده مهندسی',
                'dean' => 'دکتر احمدی',
                'description' => 'دانشکده مهندسی با گرایش‌های مختلف'
            ],
            [
                'code' => 'SCI',
                'name' => 'دانشکده علوم پایه',
                'dean' => 'دکتر محمدی',
                'description' => 'دانشکده علوم پایه شامل ریاضی، فیزیک و شیمی'
            ],
            [
                'code' => 'HUM',
                'name' => 'دانشکده علوم انسانی',
                'dean' => 'دکتر رضایی',
                'description' => 'دانشکده علوم انسانی با گرایش‌های مختلف'
            ],
        ];

        foreach ($faculties as $faculty) {
            Faculty::create($faculty);
        }
    }
}
