<?php


use App\Http\Controllers\auth\StudentAuthController;
use App\Http\Controllers\auth\TeacherAuthController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// Auth routes for students
Route::group([
    'prefix' => 'student'
], function ($router) {
    Route::post('/login', [StudentAuthController::class, 'login'])->name("login");
    Route::post('/register', [StudentAuthController::class, 'register']);
    Route::post('/logout', [StudentAuthController::class, 'logout']);
    Route::post('/refresh', [StudentAuthController::class, 'refresh']);
    Route::get('/user-profile', [StudentAuthController::class, 'userProfile']);
});

// Auth routes for teachers.
Route::group([
    'prefix' => 'teacher'
], function ($router) {
    Route::post('/login', [TeacherAuthController::class, 'login']);
    Route::post('/register', [TeacherAuthController::class, 'register']);
    Route::post('/logout', [TeacherAuthController::class, 'logout']);
    Route::post('/refresh', [TeacherAuthController::class, 'refresh']);
    Route::get('/user-profile', [TeacherAuthController::class, 'userProfile']);
});


// CRUD for students
Route::middleware('auth:student_api')->group(function () {
   Route::resource('students', StudentController::class);
});

// TODO: add route for adding students from the students model

// CRUD for teachers
Route::middleware('auth:teacher_api')->group(function () {
    Route::resource('teachers', TeacherController::class);
    Route::get('teachers/{teacherId}/periods', [TeacherController::class, 'getAllPeriodsByTeacher']);
    Route::get('teachers/{teacherId}/students', [TeacherController::class, 'getAllStudentsByTeacher']);

});
// CRUD for grades
Route::middleware('auth:teacher_api')->group(function () {
    Route::resource('grades', GradeController::class);
});

// CRUD for periods - teacher permissions
Route::middleware('auth:teacher_api')->group(function () {
    Route::resource('periods', PeriodController::class);

    /*
    it makes more sense to put it here not in the student
    itself as the teacher might be able to assign/remove a student
    */
    Route::post('periods/assign-student',  [PeriodController::class, 'addStudent'] );
    Route::delete('remove-student/{periodId}/{studentId}',  [PeriodController::class, 'removeStudent'] );
    Route::get('periods/{periodId}/students',  [PeriodController::class, 'getAllStudentsByPeriod'] );
});
