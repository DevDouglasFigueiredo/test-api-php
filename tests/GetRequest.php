<?php

namespace tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

include_once 'tests/constants.php';

class GetRequest extends TestCase
{
    private $http;

    public function setUp(): void
    {
        $this->http = new Client(['http_errors' => false]);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

     public function testGetRequestDevice()
    {
        $response = $this->http->request('GET', URL_POST.ID_5);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        $data = json_decode($body, true);
   
        $this->assertNotEmpty($body);
        $this->assertEquals(200, $statusCode);
        $this->assertEquals('5', $data['id']);
        $this->assertEquals('Samsung Galaxy Z Fold2', $data['name']);
        $this->assertEquals('5', $data['id']);
        $this->assertEquals('689.99', $data['data']['price']);
        $this->assertEquals('Brown', $data['data']['color']);
    }
}