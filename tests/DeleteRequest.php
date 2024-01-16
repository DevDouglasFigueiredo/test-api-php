<?php

namespace tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

include_once 'tests/constants.php';

class DeleteRequest extends TestCase
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

    public function testDeleteRequestDevice()
    {   
        $idDevice = $this->getIdFromPostRequest();
        $deleteURL = URL_POST.$idDevice;

        $deleteResponse = $this->http->request('DELETE', $deleteURL, ['json' => REQUEST_DATA_EDITED]);
        $body = $deleteResponse->getBody();
        $data = json_decode($body, true);
        $deleteStatusCode = $deleteResponse->getStatusCode();

        $getResponse = $this->http->request('GET', $deleteURL, ['json' => REQUEST_DATA_EDITED]);
        $getStatusCode = $getResponse->getStatusCode();

        $this->assertEquals(200, $deleteStatusCode);
        $this->assertEquals("Object with id = ". $idDevice . " has been deleted.",$data['message']);
        $this->assertEquals(404, $getStatusCode);
    }

    public function testDeleteUnknowId()
    {   
        $idDevice = '23';
        $deleteURL = URL_POST.$idDevice;

        $deleteResponse = $this->http->request('DELETE', $deleteURL, ['json' => REQUEST_DATA_EDITED]);
        $body = $deleteResponse->getBody();
        $data = json_decode($body, true);
        $getStatusCode = $deleteResponse->getStatusCode();

        $this->assertEquals(404, $getStatusCode);
        $this->assertEquals("Object with id = ". $idDevice . " doesn't exist.",$data['error']);
    }
}