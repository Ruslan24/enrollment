<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class UpdateEnrollmentTest extends TestCase
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
        $enrollment = Enrollment::create([
            'course_id' => $course->id,
            'user_id' => $user->id,
            'status' => 1,
        ]);

        $data = [
            'course_id' => $course->id,
            'user_id' => $user->id,
            'status' => 2,
            'id' => $enrollment->id,
        ];

        $response = $this->putJson('/api/enrollment', $data);
        $response->assertStatus(Response::HTTP_OK);
    }
}
