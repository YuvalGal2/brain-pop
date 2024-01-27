<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PeriodController extends Controller
{


    private static function validatePeriodData(Request $request, $required = true ) {
        // same rule set but for update it's not required to fill all fields, and for store it does.
        $rules = [
            "name" => "string|max:255|unique:periods" . ($required ? "|required" : ""),
            "teacher_id" => "int" . ($required ? "|required" : "")
        ];
        $request->validate($rules);
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $periods = Period::all();
        return response()->json($periods);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        self::validatePeriodData($request);
        $period = Period::create($request->only(['name','teacher_id']));
        return response()->json($period, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $period = Period::find($id);
        if ($period) {
            return response()->json($period);
        }
        return response()->json(['error' => 'Resource not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        self::validatePeriodData($request,false);
        $period = Period::find($id);
        // because it's a foreign key, lets validate this teacher exists.
        $teacher = Teacher::find($request->teacher_id);
        if ($period && $teacher) {
            $period->update($request->all());
            return response()->json($period, 200);
        }
        return response()->json(['error' => 'Resource not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $period = Period::find($id);
        if ($period) {
            $period->delete();
            return response()->json(null, 204);
        }
        return response()->json(['error' => 'Resource not found'], 404);
    }

    /**
     * Assign student to a period
     *
     * @param string $periodId
     * @param string $studentId
     * @return JsonResponse
     */
    public function addStudent(Request $request): JsonResponse
    {
        $request->validate([
            "periodId" => "int|required",
            // this validation is to make sure there is no duplicates in the student to periods table.
            // every student can get register to each period, BUT ONLY ONCE.
            "studentId" => "int|required|unique:period_student,student_id,NULL,id,period_id,{$request->periodId}"
        ]);
        $period = Period::find($request->periodId);
        $student = Student::find($request->studentId);
        if ($period && $student) {
            $period->students()->attach($request->studentId);
            return response()->json($period, 200);
        }
        return response()->json(['error' => 'Resource not found'], 404);

    }
    /**
     * Remove student from a period
     *
     * @param string $periodId
     * @param string $studentId
     * @return JsonResponse
     */
    public function removeStudent(string $periodId, string $studentId): JsonResponse
    {
        $period = Period::find($periodId);
        if ($period) {
            $detachedCount = $period->students()->detach($studentId);
            if ($detachedCount === 0) {
                return response()->json(['error' => 'Resource not found'], 404);
            }
            return response()->json(['message' => "{$detachedCount} student(s) removed successfully"], 200);
        }
        return response()->json(['error' => 'Resource not found'], 404);
    }


    public function getAllStudentsByPeriod(int $periodId): JsonResponse
    {
        return Period::getAllStudents($periodId);
    }
}
