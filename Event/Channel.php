<?php

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
     * @param string|callable $expectation
     *
     * @return mixed
     */
    public function expect($event, $expectation)
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

        $this->expectations[$event] = $expectation;

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
        // event has listeners ?
        if(isset($this->events[$event])) {
            foreach($this->events[$event] as $callable) {

                // execute listener
                $value = call_user_func_array($callable, $params);

                // has expectations : stop propagation
                if(isset($this->expectations[$event])) {
                    $expectation = $this->expectations[$event];
                    if($expectation($value)) {
                        return $value;
                    }
                }

                // reset value
                unset($value);
            }
        }
    }

}