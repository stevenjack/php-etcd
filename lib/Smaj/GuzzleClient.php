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
class GuzzleClient implements \Smaj\ClientAdapterInterface
{
    /**
     * Guzzle\Http\Client $clien
     */
    protected $client;

    protected $allowedMethods = array('GET', 'POST');

    public function __construct(\Guzzle\Http\Client $client) 
    {
        $this->setClient($client);
    }

    public function setClient(\Guzzle\Http\CLient $client)
    {
        $this->client = $client;
    }

    public function getClient() 
    {
        return $this->client;
    }

    /**
     * @inheritdoc
     */
    public function performRequest($uri, $method = 'GET', $data = null)
    {
        $request = null;

        if( $this->checkMethod($method)) {
            switch($method) {
                case 'GET':
                    $request = $this->client->get($uri);
                    break;
                case 'POST':
                    $request->$this->client->post($uri, null, $data);
                    break;
            }
            
            $response = $request->send();
            return $response->json();
        }
        throw new \Exception("Invalid method: {$method}, method can only be: " . implode(', ', $this->allowedMethods));

    }

    private function checkMethod($method)
    {
        return in_array($method, $this->allowedMethods);
    }

}

