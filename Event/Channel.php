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

use Discord\Reflector;

class Channel implements Subject
{

    /** @var array */
    protected $events = [];

    /** @var array */
    protected $expectations = [];


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
    public function expect($event, $expectation, $continue = false)
    {
        // expect class instance
        if(!$expectation instanceof \Closure) {

            // expect class
            $data = $expectation;
            if(is_string($expectation) and class_exists($expectation)) {
                $expectation = function($value) use($data)
                {
                    return ($value instanceof $data);
                };
            }
            // expect strict value
            else {
                $expectation = function($value) use($data)
                {
                    return ($value == $data);
                };
            }
        }

        $this->expectations[$event] = [$expectation, $continue];

        return $this;
    }


    /**
     * Listen event
     *
     * @param string $event
     * @param callable $listener
     *
     * @return $this
     */
    public function on($event, callable $listener)
    {
        if(!isset($this->events[$event])) {
            $this->events[$event] = [];
        }

        $this->events[$event][] = $listener;

        return $this;
    }


    /**
     * Attach listener instance
     *
     * @param object $listener
     *
     * @return $this
     */
    public function attach($listener)
    {
        // not an object
        if(!is_object($listener)) {
            throw new \InvalidArgumentException('$listener param must be a valid object instance');
        }

        // scan all methods, seek for @event
        foreach(get_class_methods($listener) as $method) {
            if($event = Reflector\Annotations::ofMethod($listener, $method, 'event')) {
                $this->on($event, [$listener, $method]);
            }
        }

        return $this;
    }


    /**
     * Fire event
     *
     * @param string $event
     * @param $params
     *
     * @return mixed
     */
    public function fire($event, &...$params)
    {
        // init return value
        $value = null;

        // event has listeners ?
        if(isset($this->events[$event])) {
            foreach($this->events[$event] as $callable) {

                // execute before filter
                if($event != '*') {
                    $this->fire('*', $event, $callable, ...$params);
                }

                // execute listener
                $return = call_user_func_array($callable, $params);

                // has expectations ?
                if(isset($this->expectations[$event])) {
                    list($expectation, $continue) = $this->expectations[$event];
                    if($expectation($return)) {

                        // stop propagation
                        if(!$continue) {
                            return $return;
                        }

                        // continue
                        $value = $return;
                    }
                }
            }
        }

        return $value;
    }

}