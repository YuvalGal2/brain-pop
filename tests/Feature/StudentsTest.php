<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWT;
use Tests\TestCase;

class StudentsTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    const NAME = "User";
    const USER = "USERNAME1";

    const PASSWORD = "password999999";
    /**
     * Test retrieving all students.
     *
     * @return void
     */
    public function testRetrieveAllStudents()
    {
        $this->seedUser();
        $user = Student::first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->get('/api/students');

        $response->assertStatus(200)
            ->assertJsonStructure(['data']); // Adjust based on your actual response structure

        $responseData = $response->json('data');
        $this->assertIsArray($responseData);
        $this->assertCount(1, $responseData);
    }

    /**
     * A basic feature test example.
     */

    public function canRegister(): void
    {

        $userData = [
            'full_name' => self::NAME,
            'username' => self::USER,
            'password' => Hash::make(self::PASSWORD)
        ];
        $response = $this->json('POST', '/api/students', $userData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('students', ['full_name' => self::NAME, 'username' => self::USER]);

    }
    protected function seedUser(): void
    {
        $userData = [
            'full_name' => self::NAME,
            'username' => self::USER,
            'password' => Hash::make(self::PASSWORD)
        ];
        Student::create($userData);
    }
}
