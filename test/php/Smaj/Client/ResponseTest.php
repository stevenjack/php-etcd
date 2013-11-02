<?php

use \Smaj;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    public function testResponseObjectCreatedFromJson()
    {
        $json = <<<JSON
{"action":"SET","key":"/foo","value":"bar","newKey":true,"expiration":"2013-07-11T20:31:12.156146039-07:00","ttl":4,"index":6}
JSON;

        $response = new \Smaj\Client\Response($json);
        $result = $response->getResult();

        $this->assertEquals('set', $result->getAction());
        $this->assertEquals('foo', $result->getKey());
        $this->assertEquals('bar', $result->getValue());
        $this->assertTrue($result->isNewKey());
        $this->assertInstanceOf('DateTime', $result->getExpiration());
        $this->assertEquals(4, $result->getTtl());
        $this->assertEquals(6, $result->getIndex());
    }

    public function testResponseObjectCreatedFromJsonArray()
    {
        $json = <<<JSON
[{"action":"GET","key":"/foo/foo","value":"barbar","index":10},{"action":"GET","key":"/foo/foo_dir","dir":true,"index":10}]
JSON;

        $response = new \Smaj\Client\Response($json);

        $this->assertEquals(2, count($response));

        $this->assertInstanceOf('\Smaj\Client\ResponseResult', $response[0]);
        $this->assertEquals('get', $response[0]->getAction());
        $this->assertEquals('foo/foo', $response[0]->getKey());
        $this->assertEquals('barbar', $response[0]->getValue());
        $this->assertEquals(10, $response[0]->getIndex());

        $this->assertInstanceOf('\Smaj\Client\ResponseResult', $response[1]);
        $this->assertEquals('get', $response[1]->getAction());
        $this->assertEquals('foo/foo_dir', $response[1]->getKey());
        $this->assertTrue($response[1]->isDir());
        $this->assertEquals(10, $response[1]->getIndex());

    }
}
