<?php

namespace Discord\Web\Service;

use Discord\Http;
use Discord\Router;
use Discord\Reflector;

class Routing
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
     * @event kernel.request
     *
     * @param Http\Request $request
     *
     * @return Http\Response
     * @throws Http\Exception
     */
    public function kernelRequest(Http\Request &$request)
    {
        // init instances
        $resource = $request->resource;
        $route = null;

        // routing needed
        if(!$resource) {

            // find route
            $route = $this->router->find($request->url->query);

            // 404
            if(!$route) {
                throw new Http\Exception(404);
            }
        }

        // resource needs resolving
        if(!$resource instanceof Reflector\Resource) {
            $resource = Reflector\Resolver::resolve($route->resource);
            $resource->params = $route->params;
        }

        // resource allowed ?
        if(!isset($resource->annotations['auth'])) {
            $resource->annotations['auth'] = 0;
        }
        // 403
        elseif(Http\Auth::rank() < $resource->annotations['auth']) {
            throw new Http\Exception(403);
        }

        // @todo inject dependencies

        // update request
        $request->resource = $resource;
        $request->set('route', $route);
    }

}