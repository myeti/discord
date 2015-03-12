<?php

namespace Discord\Web;

use Discord\View;
use Discord\Http;
use Discord\Router;

class App extends Kernel
{

    /** @var Router\Urls */
    public $router;

    /** @var View\Html */
    public $html;


    /**
     * Construct with built-in services
     *
     * @param array $routes
     */
    public function __construct($views, array $routes = [])
    {
        $this->router = new Router\Urls($routes);
        $this->html = new View\Html($views, Http\Mog::url()->base);

        $routing = new Plugin\Resolving($this->router);
        $rendering = new Plugin\Rendering($this->html);

        parent::__construct($routing, $rendering);
    }

}