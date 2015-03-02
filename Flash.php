<?php

namespace Discord\Persist;

abstract class Flash extends Session
{

    /**
     * Read value in session
     *
     * @param string $key
     *
     * @return mixed
     */
    public static function get($key)
    {
        $value = static::provider()->get($key);

        if(static::provider()->has($key)) {
            static::provider()->drop($key);
        }

        return $value;
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
            $instance = new Session\Native('__FLASH__');
        }

        return $instance;
    }

}