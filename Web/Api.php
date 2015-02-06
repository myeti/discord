<?php

namespace Discord\Web;

use Discord\Router;

class Api extends Kernel
{

    /**
     * Construct with built-in services
     *
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $routing = new Service\Routing(new Router\Urls($routes));
        $injection = new Service\Injection;
        $jsoning = new Service\Jsoning;

        parent::__construct($routing, $injection, $jsoning);
    }


}