<?php

use GuzzleHttp\Client;

use PHPUnit\Framework\TestCase;

class GetUsersTest extends TestCase
{
    /**
     * Test user list via API.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testEnrollmentApi()
    {
        $url = 'http://localhost:8000/api/users';

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
