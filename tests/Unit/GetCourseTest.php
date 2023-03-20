<?php

use GuzzleHttp\Client;

use PHPUnit\Framework\TestCase;

class GetCourseTest extends TestCase
{
    /**
     * Test course list via API.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testEnrollmentApi()
    {
        $url = 'http://localhost:8000/api/courses';

        $client = new Client();
        $response = $client->request('GET', $url);

        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaderLine('content-type');
        $body = $response->getBody()->getContents();
        $this->assertNotEmpty($body);

        $this->assertEquals(200, $statusCode);

        $this->assertEquals('application/json', $contentType);

    }
}
