<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class CreateEnrollmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating a new enrollment via API.
     *
     * @return void
     */
    public function testCreateEnrollment()
    {
        $user = User::create(['name' => 'test', 'email' => 'test@test.com',]);
        $course = Course::create(['title' => 'test course']);

        $data = [
            'course_id' => $course->id,
            'user_id' => $user->id,
            'status' => 1,
        ];

        $response = $this->postJson('/api/enrollment', $data);
        $response->assertStatus(Response::HTTP_OK);
    }
}
