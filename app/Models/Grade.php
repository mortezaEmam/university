<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'course_teacher_id',
        'grade',
        'status',
        'comments'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function courseOffering()
    {
        return $this->belongsTo(CourseTeacher::class, 'course_teacher_id');
    }

    public function course()
    {
        return $this->hasOneThrough(
            Course::class,
            CourseTeacher::class,
            'id',
            'id',
            'course_teacher_id',
            'course_id'
        );
    }

    public function teacher()
    {
        return $this->hasOneThrough(
            Teacher::class,
            CourseTeacher::class,
            'id',
            'id',
            'course_teacher_id',
            'teacher_id'
        );
    }
}
