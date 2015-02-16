<?php

namespace Discord\Web\Plugin;

use Discord\Web;
use Discord\Http;
use Discord\Router;
use Discord\Persist;
use Discord\Reflector;

/**
 * Route, resolve, grant (or not) and inject dependencies.
 * Can also make some tea.
 * Yes, really.
 */
class Resolving
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
     * Set kernel as dependency
     *
     * @event kernel.setup
     *
     * @param Web\Kernel $kernel
     */
    public function setup(Web\Kernel $kernel)
    {
        Reflector\Injector::store(Web\Kernel::class, $kernel);
    }


    /**
     * Inject dependencies in event
     *
     * @event *
     *
     * @param string $event
     * @param callable $callable
     * @param $params
     */
    public function fire($event, callable $callable, &...$params)
    {
        if(!$callable instanceof Reflector\Resource) {
            $callable = Reflector\Resolver::resolve($callable);
        }

        $params = Reflector\Injector::inject($callable)->params;
    }


    /**
     * Handle request resolution
     *
     * @event kernel.respond
     *
     * @param Http\Request $request
     *
     * @return Http\Response
     * @throws Http\Exception
     */
    public function resolve(Http\Request &$request)
    {
        // routing needed
        if(!$request->resource) {

            // find route
            $route = $this->router->find($request->url->query);

            // 404
            if(!$route) {
                throw new Http\Exception(404);
            }

            // resolve resource
            $request->resource = Reflector\Resolver::resolve($route->resource);
            $request->resource->params = $route->params;

            // keep route
            $request->set('route', $route);
        }
        // resource needs resolving
        elseif(!$request->resource instanceof Reflector\Resource) {
            $request->resource = Reflector\Resolver::resolve($request->resource);
        }

        // firewall : is resource allowed ?
        if(!isset($request->resource->context['auth'])) {
            $request->resource->context['auth'] = 0;
        }
        // 403
        elseif(Persist\Auth::rank() < $request->resource->context['auth']) {
            throw new Http\Exception(403);
        }

        // inject dependencies
        $request->resource = Reflector\Injector::inject($request->resource);
    }

} 