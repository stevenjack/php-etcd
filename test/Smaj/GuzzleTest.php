<?php

use \Smaj;
use \Guzzle\Http\Client;

class GuzzleTest extends PHPUnit_Framework_TestCase
{
    public function testShouldThrowExceptionWithInvalidMethod() {
        $mockClient = \Mockery::mock('\Guzzle\Http\Client');
        $guzzleRequest = new \Smaj\GuzzleRequest($mockClient);

        try {
            $guzzleRequest->performRequest('test', 'PUT');
        } catch(Exception $e) {
            return;
        }

        $this->fail('Exception should be thrown when curl_version function does not exist');
    }

    public function testShouldPerformGetRequest() {
        $jsonResponse = '{json:true}';
        $mockResponse = \Mockery::mock('\Guzzle\Http\Message\Response');
        $mockResponse
            ->shouldReceive('json')
            ->once()
            ->andReturn($jsonResponse);

        $mockRequest = \Mockery::mock('\Guzzle\Http\Message\Request');
        $mockRequest
            ->shouldReceive('send')
            ->once()
            ->andReturn($mockResponse);

        $mockClient = \Mockery::mock('\Guzzle\Http\Client');
        $mockClient
            ->shouldReceive('get')
            ->once()
            ->andReturn($mockRequest);

        $guzzleRequest = new \Smaj\GuzzleRequest($mockClient);
        $response = $guzzleRequest->performRequest('http://www.example.com/test');
        $this->assertEquals($jsonResponse, $response);
    }

}
