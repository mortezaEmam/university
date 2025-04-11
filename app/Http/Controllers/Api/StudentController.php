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

    public function show($userId)
    {
        $user = User::query()->with('student.faculty','student.department')->find($userId);
        return response()->json(['user' => $user]);
    }

    public function grades($userId)
    {
        $grades = Grade::query()->whereHas('student.user',function ($query) use ($userId){
            $query->where('id',$userId);
        })
            ->with(['student.faculty', 'student.department', 'teacher', 'student.user','course'])
            ->paginate(1); // صفحه‌بندی درست
        return response()->json([
            'data' => $grades->items(), // فقط نمرات این صفحه
            'meta' => [
                'current_page' => $grades->currentPage(),
                'last_page' => $grades->lastPage(),
                'per_page' => $grades->perPage(),
                'total' => $grades->total(),
            ],
        ]);
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
