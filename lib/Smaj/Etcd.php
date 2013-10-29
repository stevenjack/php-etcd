<?php

namespace Smaj;

/**
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 *
 * @author Steven Jack <stevenmajack@gmail.com>
 * @link http://www.github.com/stevenjack/php-etcd
 *
 * This library is used to interact with the etcd library.
 *
 */
class Etcd
{
    
    /**
     * @var string
     */
    protected $server;

    /**
     * @var integer
     */
    protected $port;

    public function __construct($server = '127.0.0.1', $port = 4001) {
        $this->setServer($server);
        $this->setPort($port);
    }

    /**
     * @param string $server
     */
    public function setServer($server) {
        $this->server = $server;
    }

    /**
     * @param integer $port
     */
    public function setPort($port) {
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getServer() {
        return $this->server;
    }

    /**
     * @return integer
     */
    public function getPort() {
        return $this->port;
    }

    
}
