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
class Response implements \IteratorAggregate, \Countable, \ArrayAccess
{
    /**
     * @var string
     */
    protected $responseData;

    /**
     * @var array
     */
    protected $results; 

    /**
     * @var boolean
     */
    protected $successful;

    public function __construct($jsonData)
    {
        $this->setup($jsonData);        
    }

    protected function setup($jsonData)
    {
        $this->successful = false;

        $this->responseData = $jsonData;
        if (! is_object($jsonData)) {
            $jsonData = $this->decodeJson($jsonData);
        }
        
        if (! is_array($jsonData)) {
            $jsonData = array($jsonData);
        }

        foreach ($jsonData as $result) {
            $this->results[] = new \Smaj\Client\ResponseResult($result);
        }
        $this->successful = true;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->results);
    }

    public function count()
    {
        return count($this->results);
    } 

    public function offsetExists($offset)
    {
        if (is_numeric($offset) && isset($this->results[$offset])) {
            return true;
        }
        return false;
    }

    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset) && $offset < $this->count()) {
            return $this->results[$offset];
        }
        return null;
    }

    public function offsetSet($offset, $value)
    {
        throw new \Exception('Not implemented');
    }

    public function offsetUnset($offset)
    {
        throw new \Exception('Not implemented');
    }

    public function getResult()
    {
        return $this->results[0];
    }

    protected function decodeJson($jsonData)
    {
        $decodedObject = json_decode($jsonData, false);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("There was an error processing the JSON: " . json_last_error());
        }
        return $decodedObject;
    }
}

