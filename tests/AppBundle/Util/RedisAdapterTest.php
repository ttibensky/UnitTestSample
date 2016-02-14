<?php

namespace tests\AppBundle\Util;

use AppBundle\Util\RedisAdapter;
use AppBundle\Exception\Util\CantConnectToRedisException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RedisAdapterTest extends WebTestCase
{
    public function testGetRedis()
    {
        /*
         * init redis connection
         */
        $adapter = new RedisAdapter('127.0.0.1', 6379);

        $class = new \ReflectionClass('AppBundle\Util\RedisAdapter');
        $method = $class->getMethod('getRedis');
        $method->setAccessible(true);

        $this->assertInstanceOf(
            'Redis',
            $method->invoke($adapter)
        );

        /*
         * get existing redis connection
         * needed to test line 41
         */
        $this->assertInstanceOf(
            'Redis',
            $method->invoke($adapter)
        );

        /*
         * try to connect to redis on non-existing host/port
         * we are testing that it is going to throw exception
         * needed to test line 47
         */
        $adapter = new RedisAdapter('some-host', 1234);

        $class = new \ReflectionClass('AppBundle\Util\RedisAdapter');
        $method = $class->getMethod('getRedis');
        $method->setAccessible(true);

        try {
            $this->assertInstanceOf(
                'Redis',
                $method->invoke($adapter)
            );
            $this->assertTrue(false);
        } catch (CantConnectToRedisException $e) {
            // do nothing
        }
    }

    public function testInsertSelect()
    {
        $adapter = new RedisAdapter('127.0.0.1', 6379);

        $key = 'test:key';
        $value = 'test value';

        $adapter->insert($key, $value);
        $this->assertEquals(
            $value,
            $adapter->select($key)
        );
    }
}
