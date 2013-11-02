<?php

use \Smaj;

class EctdTest extends PHPUnit_Framework_TestCase
{
    public function testClassExists() {
        $etcd = new \Smaj\Etcd();
        $this->assertInstanceOf('\Smaj\Etcd', $etcd);
    }

    public function testSetServer() {
        $etcd = new \Smaj\Etcd('127.0.0.1', 4001);
        $this->assertEquals('127.0.0.1', $etcd->getServer());
        $this->assertEquals(4001, $etcd->getPort());
    }

    public function testSetAction() {
        $jsonResponse = '{"action":"SET","key":"/testkey","value":"test","newKey":true,"index":8}';

        $mockResponse = \Mockery::mock('\Smaj\Client\Response');
        $mockResponse
            ->shouldReceive('getKey')
            ->once()
            ->andReturn('testkey');

        $mockResponse
            ->shouldReceive('getValue')
            ->once()
            ->andReturn('test');

        $guzzleClient = \Mockery::mock('\Smaj\GuzzleClient');
        $guzzleClient
            ->shouldReceive('performRequest')
            ->once()
            ->andReturn($mockResponse);

        $etcd = new \Smaj\Etcd('127.0.0.1', 4001);
        $etcd->setClient($guzzleClient);

        $mockRequest = \Mockery::mock('\Smaj\Client\Request');

        $mockRequest
            ->shouldReceive('setKey')
            ->once();

        $mockRequest
            ->shouldReceive('setValue')
            ->once();

        $mockRequest
            ->shouldReceive('getUri')
            ->once();

        $mockRequest
            ->shouldReceive('getMethod')
            ->once();

        $mockRequest
            ->shouldReceive('getData')
            ->once();

        $mockRequest
            ->shouldReceive('setEndpoint')
            ->with('http://127.0.0.1:4001/v1')
            ->once();

        $mockRequest
            ->shouldReceive('reset')
            ->once();

        $response = $etcd->send($mockRequest);

        $this->assertInstanceOf('\Smaj\Client\Response', $response);
        $this->assertEquals('testkey', $response->getKey());
        $this->assertEquals('test', $response->getValue());

    }

}
