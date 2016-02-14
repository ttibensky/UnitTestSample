<?php

namespace AppBundle\Exception\Util;

use AppBundle\Exception\BaseException;

class CantConnectToRedisException extends BaseException
{
    /**
     * @param string $host
     * @param string $port
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($host, $port, $code = 0, \Exception $previous = null)
    {
        parent::__construct(
            sprintf('Can\'t connect to redis on %s:%s', $host, $port),
            $code,
            $previous
        );
    }
}
