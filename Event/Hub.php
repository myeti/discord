<?php

namespace Discord\Event;

abstract class Hub
{

    /** @var Subject */
    protected static $subject;


    /**
     * Define value expectation
     *
     * @param string $event
     * @param string|callable $expectation
     *
     * @return mixed
     */
    public static function expect($event, $expectation)
    {
        return static::subject()->expect($event, $expectation);
    }


    /**
     * Attach callable to a specific event
     *
     * @param string $event
     * @param callable $listener
     *
     * @return mixed
     */
    public static function on($event, callable $listener)
    {
        return static::subject()->on($event, $listener);
    }


    /**
     * Attach listener to subject
     *
     * @param object $listener
     *
     * @return mixed
     */
    public static function attach($listener)
    {
        return static::subject()->attach($listener);
    }


    /**
     * Trigger event
     *
     * @param string $event
     * @param $params
     *
     * @return mixed
     */
    public static function fire($event, &...$params)
    {
        return static::subject()->fire($event, ...$params);
    }


    /**
     * Get subject instance
     *
     * @return Subject
     */
    protected static function subject()
    {
        if(!static::$subject) {
            static::$subject = new Channel;
        }

        return static::$subject;
    }

}