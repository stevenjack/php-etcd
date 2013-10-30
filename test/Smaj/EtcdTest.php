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

}
