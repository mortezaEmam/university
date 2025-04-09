<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_code',
        'title',
        'credit',
        'description',
        'department_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'course_teacher')
            ->using(CourseTeacher::class)
            ->withPivot('term', 'year', 'class_time', 'exam_time');
    }

    public function offerings()
    {
        return $this->hasMany(CourseTeacher::class);
    }

    public function grades()
    {
        return $this->hasManyThrough(Grade::class, CourseTeacher::class);
    }
}
