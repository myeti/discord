<?php

namespace Discord\Web;

use Discord\View;
use Discord\Router;

class App extends Kernel
{

    /**
     * Construct with built-in services
     *
     * @param array $routes
     */
    public function __construct($views, array $routes)
    {
        $routing = new Service\Routing(new Router\Urls($routes));
        $injection = new Service\Injection;
        $rendering = new Service\Rendering(new View\Html($views));

        parent::__construct($routing, $injection, $rendering);
    }


}