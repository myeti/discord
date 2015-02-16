<?php

namespace Discord\Web;

use Discord\Router;

class Api extends Kernel
{

    /** @var Router\Urls */
    public $router;


    /**
     * Construct with built-in services
     *
     * @param array $routes
     */
    public function __construct($views, array $routes = [])
    {
        $this->router = new Router\Urls($routes);

        $routing = new Plugin\Resolving($this->router);
        $jsoning = new Plugin\Jsoning;

        parent::__construct($routing, $jsoning);
    }

}