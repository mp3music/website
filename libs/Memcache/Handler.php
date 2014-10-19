<?php
namespace Memcache;

/**
 * Class Handler
 *
 * @package Memcache
 */
class Handler extends \Memcache
{
    /**
     * @const Cache expire
     */
    const MINUTE = 60;
    const HOUR = 3600;
    const DAY = 86400;
    const WEEK = 604800;
    const MONTH = 18144000;

    /**
     * @var null
     */
    private static $handler = null;
    /**
     * @var bool
     */
    private $isConnect = false;

    /**
     * @param string $host
     * @param int $port
     * @param int $timeout
     * @return Handler
     */
    public static function factory($host = '127.0.0.1', $port = 11211, $timeout = 1)
    {
        if (self::$handler === null) {
            self::$handler = new self;

            self::$handler->connect($host, $port, $timeout);
        }

        return self::$handler;
    }

    /**
     * @param string $host
     * @param int $port
     * @param int $timeout
     * @return bool
     */
    public function connect($host, $port, $timeout)
    {
        $this->isConnect = true;
        return parent::connect($host, $port, $timeout);
    }

    /**
     * @return bool
     */
    public function isConnected()
    {
        return $this->isConnect;
    }

    /**
     * @param $key
     * @param $expire
     * @param \Closure $callable
     * @return mixed
     */
    public function cache($key, $expire, \Closure $callable)
    {
        $result = $this->get($key);

        if ($result === false) {
            $result = call_user_func($callable);
            $this->set($key, $result, 0, $expire);
        }

        return $result;
    }
} 