<?php

namespace Discord\Web\Service;

use Discord\Web;
use Discord\Http;
use Discord\Router;
use Discord\Reflector;

class Routing extends Web\Service
{

    /** @var Router\Routable */
    protected $router;


    /**
     * Routing service
     *
     * @param Router\Routable $router
     */
    public function __construct(Router\Routable $router)
    {
        $this->router = $router;
    }


    /**
     * Handle request resolution
     *
     * @param Http\Request $request
     *
     * @return Http\Response|null
     * @throws Http\Exception
     */
    public function before(Http\Request &$request)
    {
        // init instances
        $resource = $request->resource;
        $route = null;

        // resource already specified
        if(!$resource or !$resource->callable) {

            // find route
            $route = $this->router->find($request->url->query);

            // 404
            if(!$route) {
                throw new Http\Exception(404);
            }

            // resolve resource
            $resource = Reflector\Resolver::resolve($route->resource);
            $resource->params = $route->params;
        }

        // inject dependencies
        // @todo

        // update request
        $request->resource = $resource;
        $request->set('route', $route);
    }

}