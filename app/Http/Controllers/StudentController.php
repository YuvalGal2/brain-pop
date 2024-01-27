<?php

namespace App\Http\Controllers;

use App\Http\Controllers\auth\StudentAuthController;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        // Display a listing of students
        $students = Student::all();
        return response()->json($students);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        return app(StudentAuthController::class)->register($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $student = Student::find($id);
        if ($student) {
            return response()->json($student);
        }
        return response()->json(['error' => 'Resource not found'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        if (strval($user->id) !== $id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $rules = StudentAuthController::getValidation();
        // same rules for reg / login but only refer to full_name
        $rules = array_filter($rules, fn ($key) => in_array($key, ['full_name']), ARRAY_FILTER_USE_KEY);
        $request->validate($rules);
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
        $student->update($request->only(['full_name']));
        return response()->json(['message' => 'Resource updated successfully', 'data' => $student]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id, Request $request)
    {
        // TODO: also need to think about who can delete users .. maybe teachers as well ?
        $student = Student::find($id);
        if ($student) {
            $student->delete();
            return response()->json(null, 204);
        }
        return response()->json(['error' => 'Resource not found'], 404);
    }
}
