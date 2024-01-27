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

class TeachersTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    const NAME = "User2";
    const USER = "USERNAME2";
    const EMAIL ="email@email.com";
    const PASSWORD = "password000000";
    /**
     * Test retrieving all students.
     *
     * @return void
     */
    public function testRetrieveAllTeachers()
    {
        $this->seedUser();
        $user = Teacher::first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->get('/api/teachers');

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
            'password' => Hash::make(self::PASSWORD),
            'email' => self::EMAIL
        ];
        $response = $this->json('POST', '/api/teachers', $userData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('teachers', ['full_name' => self::NAME, 'username' => self::USER, 'email' => self::EMAIL]);

    }
    protected function seedUser(): void
    {
        $userData = [
            'full_name' => self::NAME,
            'username' => self::USER,
            'password' => Hash::make(self::PASSWORD),
            'email' => self::EMAIL
        ];
        Teacher::create($userData);
    }
}
