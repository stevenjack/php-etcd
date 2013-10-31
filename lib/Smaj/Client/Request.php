<?php

namespace Smaj\Client;

/**
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 *
 * @author Steven Jack <stevenmajack@gmail.com>
 * @link http://www.github.com/stevenjack/php-etcd
 *
 * This library is used to interact with the etcd library.
 *
 */
class Request
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    const GET_SET_URI = '%s/keys/%s';

    const WATCH_URI = '%s/watch/%s';

    const LEADER_URI = '%s/leader';

    const MACHINES_URI = '%s/keys/_etcd/machines';

    public function __construct($endpoint = null)
    {
        $this->reset();
        $this->setEndpoint($endpoint);
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint = null)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->isValidKey($key);

        $this->key = $key;
        $this->setUri($key);

        return $this;
    }

    /**
     * @param string $key
     */ 
    public function setUri($key)
    {
        $this->uri = sprintf(self::GET_SET_URI, $this->endpoint, $key);
    }

    /**
     * @param string $value
     */
    public function setValue($value, $ttl = null)
    {
        if (! $this->isJson($value)) {
            $value = $this->getSerialized($value);
            if ($value === false) {
                throw new \Exception('Value must either be a JSON object or an object that can be serialized');
            }
        }

        $this->data['value'] = $value;


        if ($ttl && is_numeric($ttl)) {
            $this->data['ttl'] = $ttl;
        }

        $this->method = 'POST';

        return $this;
    }

    /**
     * @param string $value
     * @param string $previousValue
     */
    public function testAndSetValue($value, $previousValue)
    {
        $this->setValue($value);

        $this->isValidKey($previousValue);
        $this->data['prevValue'] = $previousValue;

        return $this;
    }

    /**
     * @param string $key
     * @param integer $index
     */
    public function watch($key, $index = null)
    {
        $this->isValidKey($key);
        $this->uri = sprintf(self::WATCH_URI, $this->endpoint, $key);        
        if ($index && is_numeric($index)) {
            $this->data['index'] = $index;
        }
    }

    /**
     * @return $string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function isValidKey($key)
    {
        if (! is_string($key)) {
            throw new \Exception('Key must be a string');
        }
    }

    /**
     * @return string
     */
    public function getLeader()
    {
        return sprintf(self::LEADER_URI, $this->endpoint);
    }

    /**
     * @return string
     */
    public function getMachines()
    {
        return sprintf(self::MACHINES_URI, $this->endpoint);
    }

    /**
     * @var string $key
     */
    public function delete($key)
    {
        $this->setKey($key);
        $this->method = 'DELETE';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return void
     */
    public function reset()
    {
        $this->data = array();
        $this->method = 'GET';
        $this->uri = null;
        $this->endpoint = null;
        $this->key = null;

    }

    /**
     * @var string $string
     * @return boolean
     */
    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * @var mixed $data
     * @return string|false
     */
    private function getSerialized($data)
    {
        try {
            return ! is_string($data) && ! is_numeric($data) ? serialize($data) : $data;
        } catch(Exception $e) {
            return false;
        }
    }




}

