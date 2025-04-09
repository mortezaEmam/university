<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Student extends Model
{
    protected $fillable = [
        'user_id',
        'student_number',
        'father_name',
        'birth_date',
        'address',
        'major',
        'entry_year',
        'level'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'grades')
            ->using(CourseTeacher::class)
            ->withPivot('grade', 'status');
    }
}
