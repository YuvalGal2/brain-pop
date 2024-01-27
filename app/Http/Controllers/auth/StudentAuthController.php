<?php

namespace App\Http\Controllers\auth;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends AuthController
{
    public function __construct() {
        $this->middleware('auth:student_api', ['except' => ['login', 'register']]);
            $this->guard = 'student_api';
    }
    public static function getValidation(): array {
        return [
            'username' => 'required|string|max:255|unique:students',
            'full_name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ];
    }
    public function register(Request $request){
        $request->validate(self::getValidation());
        $student = Student::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'full_name' => $request->full_name
        ]);

        $token = Auth::guard('student_api')->login($student);
        return response()->json([
            'status' => 'success',
            'message' => 'Student created successfully',
            'user' => $student,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ],201);
    }
}
