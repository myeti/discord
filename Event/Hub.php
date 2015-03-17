<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Event;

abstract class Hub
{

    /** @var Subject */
    protected static $subject;


    /**
     * Define value expectation
     *
     * @param string $event
     * @param mixed $expectation
     *
     * @param bool $continue
     *
     * @return mixed
     */
    public static function expect($event, $expectation, $continue = false)
    {
        return static::subject()->expect($event, $expectation, $continue);
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