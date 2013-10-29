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
interface RequestAdapterInterface
{
    public function performRequest($uri, $method = 'GET', $data = null);
}

