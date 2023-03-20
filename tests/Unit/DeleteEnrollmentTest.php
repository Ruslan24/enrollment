<?php


use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class DeleteEnrollmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test delete a new enrollment via API.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
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

        $url = 'http://localhost:8000/api/enrollment?id='. $enrollment->id;

        $client = new Client();
        $response = $client->request('DELETE', $url);
        $statusCode = $response->getStatusCode();
        $this->assertEquals(200, $statusCode);
    }
}
