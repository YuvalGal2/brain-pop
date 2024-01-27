<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class Period extends Model {
    protected $fillable = [
        'name',
        'teacher_id',

    ];

    public static function getAllStudents(int $periodId): JsonResponse {
        $period = self::find($periodId);
        if ($period) {
            return response()->json(['students' => $period->students]);
        }
        return response()->json(['error' => 'Resource not found'], 404);
    }

    public static function getAllByTeacher(int $teacherId): JsonResponse {
        $periods = self::where('teacher_id', $teacherId)->get();
        if ($periods) {
            return response()->json(['periods' => $periods]);
        }
        return response()->json(['error' => 'Resource not found'], 404);
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function students() {
        return $this->belongsToMany(Student::class);
    }
}
