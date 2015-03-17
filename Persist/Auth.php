<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Persist;

abstract class Auth
{

    /**
     * Log user in
     *
     * @param int $rank
     * @param mixed $user
     */
    public static function login($rank = 1, $user = null)
    {
        static::provider()->set('logged', true);
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
    public static function logged()
    {
        return static::provider()->get('logged') ?: false;
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
        static $instance;

        if($provider) {
            $instance = $provider;
        }
        elseif(!$instance) {
            $instance = new Session\Native('__AUTH__');
        }

        return $instance;
    }

}