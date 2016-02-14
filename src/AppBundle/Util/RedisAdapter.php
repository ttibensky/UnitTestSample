<?php

namespace AppBundle\Util;

use AppBundle\Exception\Util\CantConnectToRedisException;

class RedisAdapter
{
    /**
     * @var \Redis
     */
    protected $redis;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $port;

    /**
     * @param string $host
     * @param int    $port
     */
    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @return \Redis
     * @throws CantConnectToRedisException
     */
    protected function getRedis()
    {
        if ($this->redis instanceof \Redis) {
            return $this->redis;
        }

        $this->redis = new \Redis();

        if (!@$this->redis->pconnect($this->host, $this->port)) {
            throw new CantConnectToRedisException($this->host, $this->port);
        }

        return $this->redis;
    }

    /**
     * @param string $key
     * @param string $data
     *
     * @return bool
     * @throws CantConnectToRedisException
     */
    public function insert($key, $data)
    {
        return $this->getRedis()->set($key, $data);
    }

    /**
     * @param string $key
     *
     * @return bool|string
     * @throws CantConnectToRedisException
     */
    public function select($key)
    {
        return $this->getRedis()->get($key);
    }
}
