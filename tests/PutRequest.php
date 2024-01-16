<?php

namespace tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

include_once 'tests/constants.php';

class RequestHttpApiTest extends TestCase
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

    public function getIdFromPostRequest()
    {
        $response = $this->http->request('POST', URL, ['json' => REQUEST_DATA]);
        $body = $response->getBody();
        $data = json_decode($body, true);

        return $data['id'];
    }

    public function testPutRequestDevice()
    {   
        $idDevice = $this->getIdFromPostRequest();
        $response = $this->http->request('PUT', URL_POST.$idDevice, ['json' => REQUEST_DATA_EDITED]);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        $data = json_decode($body, true);

        $this->assertEquals(200, $statusCode);
        $this->assertEquals('2799.99', $data['data']['price']);
        $this->assertEquals('Gray', $data['data']['color']);
    }

   
}
