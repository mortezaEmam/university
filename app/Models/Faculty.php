<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = ['code', 'name', 'dean', 'description'];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function students()
    {
        return $this->hasManyThrough(Student::class, Department::class);
    }

    public function teachers()
    {
        return $this->hasManyThrough(Teacher::class, Department::class);
    }
}
