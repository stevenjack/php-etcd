<?php

use \Smaj;

class EctdTest extends PHPUnit_Framework_TestCase
{
    public function testClassExists() {
        $ectd = new \Smaj\Etcd();
        $this->assertInstanceOf('\Smaj\Etcd', $ectd);     
    }

    public function testSetServer() {
        $ectd = new \Smaj\Etcd('127.0.0.1', 4001);
        $this->assertEquals('127.0.0.1', $ectd->getServer());
        $this->assertEquals(4001, $ectd->getPort());
    }

    public function testSetAction() {
        $jsonResponse = '{"action":"SET","key":"/testkey","value":"test","newKey":true,"index":8}';
        
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
            ->shouldReceive('post')
            ->once()
            ->andReturn($mockRequest);

        $guzzleRequest = new \Smaj\GuzzleRequest($mockClient);

        $ectd = new \Smaj\Etcd('127.0.0.1', 4001);
        $etcd->setClient($guzzleClient);

        $response = $etcd->set('testkey', 'test');

        $this->assertInstanceOf('\Smaj\Response', $response);
        $this->assertEquals('testkey', $response->getKey());
        $this->assertEquals('test', $response->getValue());

    }

}
