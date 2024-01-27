<?php

namespace App\Http\Controllers;
use App\Http\Controllers\auth\TeacherAuthController;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Update the specified grade in storage.
     *
     * @param Request $request
     * @param string $studentId
     * @return JsonResponse
     */
    public function update(Request $request, string $studentId): JsonResponse
    {
        $request->validate([
            'grade' => 'required|integer|between:0,12',
            'period_id' => 'required|int'
        ]);
        $student = Student::find($studentId);
        if (!$student) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
        return $student->updateGrade($request->grade,$request->period_id);
    }
}
