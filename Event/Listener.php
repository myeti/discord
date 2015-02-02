<?php

namespace Discord\Event;

interface Listener
{

    /**
     * Listen to subject's events
     *
     * @param Subject $subject
     */
    public function listen(Subject $subject);

} 