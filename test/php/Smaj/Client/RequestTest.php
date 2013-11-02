<?php

use \Smaj;

class RequestTest extends PHPUnit_Framework_TestCase
{
    public function testClassExists() {
        $request = new \Smaj\Client\Request('test');
        $this->assertInstanceOf('\Smaj\Client\Request', $request);     
    }

    public function testSetRequest() {
        $endpoint = 'http://test:4001/v1';
        $request = new \Smaj\Client\Request($endpoint);

        $request
            ->setKey('test')
            ->setValue('test value');

        $uri = $request->getUri();
        $data = $request->getData();

        $this->assertEquals("{$endpoint}/keys/test", $uri);
        $this->assertEquals(array('value' => 'test value'), $data);
        $this->assertEquals('POST', $request->getMethod());
    }

    public function testSetWithTtl()
    {
        $endpoint = 'http://test:4001/v1';
        $request = new \Smaj\Client\Request($endpoint);

        $request
            ->setKey('test')
            ->setValue('test value', 100);

        $uri = $request->getUri();
        $data = $request->getData();

        $this->assertEquals("{$endpoint}/keys/test", $uri);
        $this->assertEquals(array('value' => 'test value', 'ttl' => 100), $data);
        $this->assertEquals('POST', $request->getMethod());
    }

    public function testTestAndSet()
    {
        $endpoint = 'http://test:4001/v1';
        $request = new \Smaj\Client\Request($endpoint);

        $request
            ->setKey('test')
            ->testAndSetValue('test value', 'test prev');

        $uri = $request->getUri();
        $data = $request->getData();

        $this->assertEquals("{$endpoint}/keys/test", $uri);
        $this->assertEquals(array('value' => 'test value', 'prevValue' => 'test prev'), $data);
        $this->assertEquals('POST', $request->getMethod());
    }


    public function testGetLeaderAndMachines()
    {
        $endpoint = 'http://test:4001/v1';
        $request = new \Smaj\Client\Request($endpoint);

        $this->assertEquals("{$endpoint}/leader", $request->getLeader());
        $this->assertEquals("{$endpoint}/keys/_etcd/machines", $request->getMachines());
        $this->assertEquals('GET', $request->getMethod());
    }

    public function testWatch()
    {
        $endpoint = 'http://test:4001/v1';
        $request = new \Smaj\Client\Request($endpoint);

        $request->watch('test');

        $uri = $request->getUri();

        $this->assertEquals("{$endpoint}/watch/test", $uri);
        $this->assertEquals('GET', $request->getMethod());
    }

    public function testWatchWithIndex()
    {
        $endpoint = 'http://test:4001/v1';
        $request = new \Smaj\Client\Request($endpoint);

        $request->watch('test', 10);

        $uri = $request->getUri();
        $data = $request->getData();

        $this->assertEquals("{$endpoint}/watch/test", $uri);
        $this->assertEquals(array('index' => 10), $data);
        $this->assertEquals('GET', $request->getMethod());
    }

    public function testGetRequest() {
        $endpoint = 'http://test:4001/v1';
        $request = new \Smaj\Client\Request($endpoint);

        $request->setKey('test');
        $data = $request->getData();

        $uri = $request->getUri();

        $this->assertEquals("{$endpoint}/keys/test", $uri);
        $this->assertEmpty($data);
        $this->assertEquals('GET', $request->getMethod());
    }

    public function testDeleteRequest() {
        $endpoint = 'http://test:4001/v1';
        $request = new \Smaj\Client\Request($endpoint);

        $request->delete('test');
        $data = $request->getData();

        $uri = $request->getUri();

        $this->assertEquals("{$endpoint}/keys/test", $uri);
        $this->assertEmpty($data);
        $this->assertEquals('DELETE', $request->getMethod());
    }

}
