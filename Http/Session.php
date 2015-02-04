<?php

namespace Discord\Http;

abstract class Session
{

    /** @var Session\Provider */
    protected static $provider;


    /**
     * Check value in session
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return static::provider()->has($key);
    }


    /**
     * Read value in session
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return static::provider()->get($key);
    }


    /**
     * Write value in session
     *
     * @param string $key
     * @param $value
     *
     * @return mixed
     */
    public function set($key, $value)
    {
        return static::provider()->set($key, $value);
    }


    /**
     * Write value in session
     *
     * @param string $key
     * @param $value
     *
     * @return mixed
     */
    public function flash($key, $value)
    {
        return static::provider()->flash($key, $value);
    }


    /**
     * Remove value from session
     * @param $key
     *
     * @return mixed
     */
    public function drop($key)
    {
        return static::provider()->drop($key);
    }


    /**
     * Wipe all values
     *
     * @return mixed
     */
    public function wipe()
    {
        return static::provider()->wipe();
    }


    /**
     * Get/Set session provider instance
     *
     * @param Session\Provider $provider
     *
     * @return Session\Provider
     */
    public function provider(Session\Provider $provider = null)
    {
        if($provider) {
            static::$provider = $provider;
        }
        elseif(!static::$provider) {
            static::$provider = new Session\Native('__DATA__');
        }

        return static::$provider;
    }

}