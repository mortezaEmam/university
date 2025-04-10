<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function index()
    {
        $students = User::query()->whereHas( "student")->get();
        return response()->json($students);
    }

    public function show($id)
    {
        $student = Student::query()->find($id);
        return response()->json($student);
    }

    public function grades($id)
    {
        $student = Student::with(['grades.course', 'faculty', 'department', 'grades.teacher', 'user'])
            ->where('user_id', $id)
            ->first();
        return response()->json($student);
    }
    public function editGrade($user,$courseTeacherId)
    {
        $student = Student::with(['grades' => function ($query) use ($courseTeacherId) {
            $query->where('course_teacher_id', $courseTeacherId)
                ->select('grade', 'course_teacher_id', 'student_id'); // فقط فیلدهای نمره و مورد نیاز
        }, 'grades.course', 'grades.teacher', 'faculty', 'department', 'user'])
            ->where('user_id', $user)
            ->first();
        $data = [
            'student' => $student,
            'grades' => $student->grades->first()
        ];
        return response()->json($data);
    }
}
