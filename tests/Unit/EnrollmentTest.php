<?php

namespace Tests\Unit;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class EnrollmentTest extends TestCase
{
    /**
     * Test list enrollment via API.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testEnrollmentApi()
    {
        $url = 'http://localhost:8000/api/enrollments?course_name=&user_name=&status=&sort_by=updated_at&sort_order=asc&page=1';

        $client = new Client();
        $response = $client->request('GET', $url);

        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaderLine('content-type');
        $body = $response->getBody()->getContents();
        $expectedKeys = ['current_page', 'data'];

        $this->assertEquals(200, $statusCode);

        $this->assertEquals('application/json', $contentType);

        // Assert the response body has the expected keys
        $this->assertArrayHasKey($expectedKeys[0], json_decode($body, true));
        $this->assertArrayHasKey($expectedKeys[1], json_decode($body, true));
    }
}
