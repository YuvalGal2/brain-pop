<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Student extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'full_name',
        'grade'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    //put these methods at the bottom of your class body

    public function updateGrade($newGrade,$periodId): JsonResponse {
        $period = Period::with('students')->find($periodId);
        if (!$period) {
            return response()->json(['error' => 'Resource not found'], 404);
        }
        //$period->students->updateExistingPivot($this->id, ['grade' => $newGrade]);
        $period->students()->updateExistingPivot($this->id, ['grade' => $newGrade]);
        $this->grade = $newGrade;
        $this->save();
        return response()->json(['message' => 'Resource updated successfully', 'data' => $period]);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'username' => $this->username,
            'full_name' => $this->full_name
        ];
    }
}
