<?php

namespace Discord\Web;

use Discord\Router;
use Discord\Reflector;

class Api extends Kernel
{

    /** @var Router\Urls */
    public $router;


    /**
     * Construct with built-in services
     *
     * @param array $routes
     */
    public function __construct(array $routes = [])
    {
        $this->router = new Router\Urls($routes);
        Reflector\Injector::store(Router\Urls::class, $this->router);

        $routing = new Plugin\Resolving($this->router);
        $jsoning = new Plugin\Jsoning;

        parent::__construct($routing, $jsoning);
    }

}