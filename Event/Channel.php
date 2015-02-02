<?php

namespace Discord\Event;

class Channel implements Subject
{

    /** @var array */
    protected $events = [];


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
     * @param Listener $listener
     *
     * @return $this
     */
    public function attach(Listener $listener)
    {
        $listener->listen($this);

        return $this;
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
        $count = 0;

        // event has listeners ?
        if(isset($this->events[$event])) {

            // execute them
            foreach($this->events[$event] as $callable) {

                // increase counter
                $stop = call_user_func_array($callable, $params);
                $count++;

                // stop propagation ?
                if($stop === false) {
                    break;
                }
            }
        }

        return $count;
    }

}