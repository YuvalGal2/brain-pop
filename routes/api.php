<?php


use App\Http\Controllers\auth\StudentAuthController;
use App\Http\Controllers\auth\TeacherAuthController;
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

Route::group([
    'prefix' => 'student'
], function ($router) {
    Route::post('/login', [StudentAuthController::class, 'login'])->name("login");
    Route::post('/register', [StudentAuthController::class, 'register']);
    Route::post('/logout', [StudentAuthController::class, 'logout']);
    Route::post('/refresh', [StudentAuthController::class, 'refresh']);
    Route::get('/user-profile', [StudentAuthController::class, 'userProfile']);
});
Route::group([
    'prefix' => 'teacher'
], function ($router) {
    Route::post('/login', [TeacherAuthController::class, 'login']);
    Route::post('/register', [TeacherAuthController::class, 'register']);
    Route::post('/logout', [TeacherAuthController::class, 'logout']);
    Route::post('/refresh', [TeacherAuthController::class, 'refresh']);
    Route::get('/user-profile', [TeacherAuthController::class, 'userProfile']);
});
