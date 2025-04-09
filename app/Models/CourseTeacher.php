<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTeacher extends Model
{
    protected $table = 'course_teacher';

    protected $fillable = [
        'course_id',
        'teacher_id',
        'term',
        'year',
        'class_time',
        'exam_time'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'grades')
            ->withPivot('grade', 'status');
    }
}
