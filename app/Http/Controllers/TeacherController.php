<?php

namespace App\Http\Controllers;
use App\Http\Controllers\auth\TeacherAuthController;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Display a listing of teachers
        $teachers = Teacher::all();
        return response()->json($teachers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
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
        return app(TeacherAuthController::class)->register($request);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $teacher = Teacher::find($id);
        if ($teacher) {
            return response()->json($teacher);
        }
        return response()->json(['error' => 'Resource not found'], 404);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  string  $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $user = $request->user();
        if (strval($user->id) !== $id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $rules = TeacherAuthController::getValidation();
        // same rules for reg / login but only refer to full_name
        $rules = array_filter($rules, fn ($key) => in_array($key, ['full_name','email']), ARRAY_FILTER_USE_KEY);
        $request->validate($rules);
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
        $teacher->update($request->only(['full_name']));
        return response()->json(['message' => 'Resource updated successfully', 'data' => $teacher]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function destroy(string $id, Request $request): JsonResponse
    {
        $user = $request->user();
        if (strval($user->id) !== $id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        // Remove the specified teacher from the database
        $teacher = Teacher::find($id);
        if ($teacher) {
            $teacher->delete();
            return response()->json(null, 204);
        }
        return response()->json(['error' => 'Resource not found'], 404);
    }
}
