<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
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
    public function store(Request $request)
    {
        $teacher = Teacher::create($request->all());
        return response()->json($teacher, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $teacher = Teacher::findOrFail($id);
        return response()->json($teacher);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->update($request->all());
        return response()->json($teacher, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        // Remove the specified teacher from the database
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();
        return response()->json(null, 204);
    }
}
