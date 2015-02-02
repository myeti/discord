<?php

namespace Discord\Event;

interface Subject
{

    /**
     * Attach callable to a specific event
     *
     * @param string $event
     * @param callable $listener
     *
     * @return mixed
     */
    public function on($event, callable $listener);


    /**
     * Attach listener to subject
     *
     * @param Listener $listener
     *
     * @return mixed
     */
    public function attach(Listener $listener);


    /**
     * Trigger event
     *
     * @param string $event
     * @param $params
     *
     * @return mixed
     */
    public function fire($event, &...$params);

} 