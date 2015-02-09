<?php

namespace Discord\Persist;

abstract class Session
{


    /**
     * Check value in session
     *
     * @param string $key
     *
     * @return bool
     */
    public static function has($key)
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
    public static function get($key)
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
    public static function set($key, $value)
    {
        return static::provider()->set($key, $value);
    }


    /**
     * Remove value from session
     * @param $key
     *
     * @return mixed
     */
    public static function drop($key)
    {
        return static::provider()->drop($key);
    }


    /**
     * Wipe all values
     *
     * @return mixed
     */
    public static function wipe()
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
    public static function provider(Session\Provider $provider = null)
    {
        static $instance;

        if($provider) {
            $instance = $provider;
        }
        elseif(!$instance) {
            $instance = new Session\Native('__DATA__');
        }

        return $instance;
    }

}