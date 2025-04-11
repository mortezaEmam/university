<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // کاربر ادمین
        User::create([
            'national_code' => '1234567890',
            'first_name' => 'مدیر',
            'last_name' => 'سیستم',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'type' => 'admin'
        ]);

        // کاربران اساتید
        $teachers = [
            [
                'national_code' => '1111111111',
                'first_name' => 'علی',
                'last_name' => 'محمدی',
                'email' => 'ali.mohammadi@university.ac.ir',
                'password' => Hash::make('password'),
                'type' => 'teacher'
            ],
            [
                'national_code' => '2222222222',
                'first_name' => 'مریم',
                'last_name' => 'رضایی',
                'email' => 'maryam.rezaei@university.ac.ir',
                'password' => Hash::make('password'),
                'type' => 'teacher'
            ],
        ];

        // کاربران دانشجویان
        $students = [
            [
                'national_code' => '3333333333',
                'first_name' => 'احمد',
                'last_name' => 'اکبری',
                'email' => 'ahmad.akbari@university.ac.ir',
                'password' => Hash::make('password'),
                'type' => 'student'
            ],
            [
                'national_code' => '4444444444',
                'first_name' => 'زهرا',
                'last_name' => 'حسینی',
                'email' => 'zahra.hosseini@university.ac.ir',
                'password' => Hash::make('password'),
                'type' => 'student'
            ],
        ];

        User::insert($teachers);
        User::insert($students);
    }
}
