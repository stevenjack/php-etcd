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
class ResponseResult
{
    /**
     * @var string
     */
    protected $responseData;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var mixed
     */
    protected $prevValue;

    /**
     * @var boolean
     */
    protected $isNewKey;

    /**
     * @var DateTime
     */
    protected $expiration;

    /**
     * @var integer
     */
    protected $ttl;

    /**
     * @var integer
     */
    protected $index;

    /**
     * @var boolean
     */
    protected $isDir;

    public function __construct($jsonData)
    {
        $this->processJson($jsonData);
    }

    /**
     * @param stdClass
     */
    protected function processJson($jsonData)
    {
        $this->responseData = $jsonData;

        if (! empty($jsonData->action)) {
            $this->action = strtolower($jsonData->action);
        }

        if (! empty($jsonData->key)) {
            $this->key = ltrim($jsonData->key, '/');
        }

        if (! empty($jsonData->value)) {
            $this->value = $jsonData->value;
        }

        if (! empty($jsonData->prevValue)) {
            $this->prevValue = $jsonData->prevValue;
        }

        if (! empty($jsonData->newKey)) {
            $this->isNewKey = $jsonData->newKey;
        }

        if (! empty($jsonData->expiration)) {

            $this->expiration = $this->parseExpiration($jsonData->expiration);
        }

        if (! empty($jsonData->ttl)) {
            $this->ttl = $jsonData->ttl;
        }

        if (! empty($jsonData->index)) {
            $this->index = $jsonData->index;
        }

        if (! empty($jsonData->dir)) {
            $this->dir = $jsonData->dir;
        }
    }

    /**
     * @param string $timestamp
     * @return DateTime|null
     */
    public function parseExpiration($timestamp)
    {
        preg_match('/(\d{4}-\d{2}-.+)\.\d+(-.*)/', $timestamp, $matches);
        if (count($matches) === 3) {
            return new \DateTime($matches[1] . $matches[2]);
        }
        return null;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return boolean
     */
    public function isNewKey()
    {
        return $this->isNewKey;
    }

    /**
     * @return DateTime
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @return integer
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * @return integer
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return boolean
     */
    public function isDir()
    {
        return $this->dir;
    }

}

