<?php

namespace Discord\Reflector;

abstract class Injector
{

    /** @var callable[] */
    protected static $factories = [];


    /**
     * Store instance
     *
     * @param string $key
     * @param object $instance
     */
    public static function store($key, $instance)
    {
        static::factory($key, function() use($instance)
        {
            static $singleton;
            if(!$singleton) {
                $singleton = $instance;
            }

            return $singleton;
        });
    }


    /**
     * Store singleton constructor
     *
     * @param string $key
     * @param callable $constructor
     */
    public static function lazy($key, callable $constructor)
    {
        static::factory($key, function(...$params) use($constructor)
        {
            static $singleton;
            if(!$singleton) {
                $singleton = $constructor(...$params);
            }

            return $singleton;
        });
    }


    /**
     * Store factory
     *
     * @param string $key
     * @param callable $factory
     */
    public static function factory($key, callable $factory)
    {
        static::$factories[$key] = $factory;
    }


    /**
     * Get instance
     *
     * @param string $key
     * @param $params
     *
     * @throws Injector\DependencyNotFound
     *
     * @return mixed
     */
    public static function get($key, ...$params)
    {
        if(isset(static::$factories[$key])) {
            $factory = static::$factories[$key];
            return call_user_func_array($factory, $params);
        }

        throw new Injector\DependencyNotFound;
    }

}