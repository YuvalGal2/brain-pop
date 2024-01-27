<?php

namespace App\Http\Controllers\auth;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherAuthController extends AuthController
{
    public function __construct() {
        $this->middleware('auth:teacher_api', ['except' => ['login', 'register']]);
        $this->guard = 'teacher_api';
    }
    public static function getValidation(): array {
        return [
            'username' => 'required|string|max:255|unique:teachers',
            'email' => 'required|string|email|unique:teachers',
            'full_name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ];
    }
    public function register(Request $request): JsonResponse{
        $request->validate(self::getValidation());
        $teacher = Teacher::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'full_name' => $request->full_name
        ]);

        $token = Auth::guard('teacher_api')->login($teacher);
        return response()->json([
            'status' => 'success',
            'message' => 'Teacher created successfully',
            'user' => $teacher,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }
}
