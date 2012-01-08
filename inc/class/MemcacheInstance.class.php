<?php

/**
 * Memcache instance.
 *
 * @author  Thomas Van Horde
 * @author  Fabien Nouaillat
 * @package self-engine
 */
class MemcacheInstance extends Memcache
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::pconnect('localhost', 11211);
    }

    /**
     * @return ?
     */
    public function getServerStatus()
    {
        return parent::getServerStatus('localhost', 11211);
    }

    /**
     * @param  $key
     * @param  $value
     *
     * @return bool
     */
    public function set($key, $value)
    {
        if (parent::set($key, $value, MEMCACHE_COMPRESSED, 0)) {
            FB('ok');
            $isSuccessful = true;
        } else {
            FB('error');
            $isSuccessful = false;
        }

        return $isSuccessful;
    }

    /**
     * @param  $key
     *
     * @return bool
     */
    public function get($key)
    {
        return parent::get($key);
    }
}