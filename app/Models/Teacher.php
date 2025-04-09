<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'teacher_code',
        'degree',
        'field',
        'rank',
        'bio'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_teacher')
            ->using(CourseTeacher::class)
            ->withPivot('term', 'year', 'class_time', 'exam_time');
    }

    public function teachingCourses()
    {
        return $this->hasMany(CourseTeacher::class);
    }
}
