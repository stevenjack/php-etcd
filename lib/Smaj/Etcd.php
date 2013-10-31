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

    const SET = '';
    const GET = 'get';

    /**
     * @var string
     */
    protected $server;

    /**
     * @var integer
     */
    protected $port;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var \Smaj\ClientAdapterInterface
     */
    protected $client;


    public function __construct($server = '127.0.0.1', $port = 4001, $version = 'v1') {
        $this->setServer($server);
        $this->setPort($port);
        $this->setVersion($version);
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
     * @param string $version
     */
    public function setVersion($version) {
        $this->version = $version;
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

    /**
     * @return string
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * Sets the client to use for connecting the the daemon
     */
    public function setClient(\Smaj\ClientAdapterInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param \Smaj\Client\Request $request
     * @return \Smaj\Client\Response
     */
    public function send(\Smaj\Client\Request $request)
    {
        $this->client->performRequest($request->getUri(), $request->getMethod(), $request->getData());
    }

}

