<?php

namespace tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

include_once 'tests/constants.php';

class PostRequest extends TestCase
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

    public function testPostRequestDevice()
    {
        $response = $this->http->request('POST', URL, ['json' => REQUEST_DATA]);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        $data = json_decode($body, true);

        $this->assertEquals(200, $statusCode);
        $this->assertEquals('Notebook Dell uTech', $data['name']);
        $this->assertEquals('1799.99', $data['data']['price']);
        $this->assertArrayHasKey('id', $data);
    }

    public function testPostDeviceWithNoData()
    {
        $response = $this->http->request('POST', URL, ['json' => REQUEST_DATA_EMPTY]);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        $data = json_decode($body, true);
        // deveria ser status 400 por estar enviando um array vazio
        $this->assertEquals(200, $statusCode);
       
    }
}