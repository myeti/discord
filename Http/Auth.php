<?php

namespace Discord\Http;

abstract class Auth
{

    /** @var Session\Provider */
    protected static $provider;


    /**
     * Log user in
     *
     * @param int $rank
     * @param mixed $user
     */
    public static function login($rank = 1, $user = null)
    {
        static::provider()->set('rank', $rank);
        static::provider()->set('user', $user);
    }


    /**
     * Log user out
     */
    public static function logout()
    {
        static::provider()->wipe();
    }


    /**
     * Log user out
     *
     * @return int
     */
    public static function rank()
    {
        return static::provider()->get('rank') ?: 0;
    }


    /**
     * Log user out
     *
     * @return mixed
     */
    public static function user()
    {
        return static::provider()->get('user');
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
        if($provider) {
            static::$provider = $provider;
        }
        elseif(!static::$provider) {
            static::$provider = new Session\Native('__AUTH__');
        }

        return static::$provider;
    }

}