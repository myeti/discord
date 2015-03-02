<?php

namespace Discord\Event;

interface Subject
{

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
    public function expect($event, $expectation, $continue = false);

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
     * @param object $listener
     *
     * @return mixed
     */
    public function attach($listener);


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