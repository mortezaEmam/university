<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function index()
    {
        $students = User::query()->whereHas("student")->get();
        return response()->json($students);
    }

    public function show($id)
    {
        $student = Student::query()->find($id);
        return response()->json($student);
    }

    public function grades($userId)
    {
        $student = Student::with(['grades.course', 'faculty', 'department', 'grades.teacher', 'user'])
            ->where('user_id', $userId)
            ->first();
        return response()->json($student);
    }

    public function updateGrade(Request $request, $studentId, $gradeId)
    {
        Grade::query()
            ->where('id' ,$gradeId)
            ->update([
                'status' => $request->status,
                'grade' => $request->grade,
                'comments' => $request->description
            ]);

        return response()->json(['message' => 'نمره بروزرسانی شد']);
    }

    public function destroyGrade($studentId, $gradeId)
    {
        $student = Student::findOrFail($studentId);
        $grade = $student->grades()->where('id', $gradeId)->firstOrFail();

        $grade->delete();

        return response()->json(['message' => 'نمره حذف شد']);
    }


}
