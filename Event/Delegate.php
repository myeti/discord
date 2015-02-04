<?php

namespace Discord\Event;

abstract class Delegate implements Subject
{

    /** @var Subject */
    protected $channel;


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
        return $this->channel->expect($event, $expectation);
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
        return $this->channel->on($event, $listener);
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
        return $this->channel->attach($listener);
    }


    /**
     * Fire event
     *
     * @param string $event
     * @param $params
     *
     * @return int
     */
    public function fire($event, &...$params)
    {
        return $this->channel->fire($event, ...$params);
    }

} 