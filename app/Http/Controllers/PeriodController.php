<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PeriodController extends Controller
{
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
    public function store(Request $request)
    {
        $period = Period::create($request->all());
        return response()->json($period, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $period = Period::findOrFail($id);
        return response()->json($period);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $period = Period::findOrFail($id);
        $period->update($request->all());
        return response()->json($period, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        // Remove the specified period from the database
        $period = Period::findOrFail($id);
        $period->delete();
        return response()->json(null, 204);
    }

    public function addStudent(int $period_id, int $student_id)
    {
        $period = Period::findOrFail($period_id);
        $period->students()->attach($student_id);
        return response()->json($period, 200);
    }

    public function removeStudent(int $period_id, int $student_id)
    {
        $period = Period::findOrFail($period_id);
        $period->students()->detach($student_id);
        return response()->json($period, 200);
    }
}
