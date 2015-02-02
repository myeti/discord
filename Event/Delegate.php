<?php

namespace Discord\Event;

abstract class Delegate implements Subject
{

    /** @var Subject */
    protected $channel;


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
     * @param Listener $listener
     *
     * @return $this
     */
    public function attach(Listener $listener)
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