<?php

namespace Discord\Web\Service;

use Discord\Http;
use Discord\Reflector;

class Injection
{

    /**
     * Inject dependencies in event
     *
     * @event *
     *
     * @param string $event
     * @param callable $callable
     * @param $params
     */
    public function injectInEvent($event, callable $callable, &...$params)
    {
        if(!$callable instanceof Reflector\Resource) {
            $callable = Reflector\Resolver::resolve($callable);
        }

        $params = $this->injectIn($callable->reflector, $params);
    }


    /**
     * Handle request resolution
     *
     * @event kernel.request
     *
     * @param Http\Request $request
     * @return Http\Response
     * @throws Http\Exception
     */
    public function injectInRequest(Http\Request &$request)
    {
        // set request as valid factory
        Reflector\Injector::store(Http\request::class, $request);

        // inject
        $resource = $request->resource;
        if($resource instanceof Reflector\Resource and $resource->reflector instanceof \Reflector) {
            $request->resource->params = $this->injectIn($resource->reflector, $resource->params);
        }
    }


    /**
     * Parse and inject in params
     *
     * @param \ReflectionFunctionAbstract $reflector
     * @param array $params
     *
     * @return array
     *
     * @throws Reflector\Injector\DependencyNotFound
     */
    protected function injectIn(\ReflectionFunctionAbstract $reflector, array $params)
    {
        // init ordered params
        $ordered = [];

        // reflect on params
        foreach($reflector->getParameters() as $parameter) {

            // set value
            $key = $parameter->getName();
            $ordered[$key] = isset($params[$key]) ? $params[$key] : null;

            // inject dependencies
            if($class = $parameter->getClass() and Reflector\Injector::has($class)) {
                $ordered[$key] = Reflector\Injector::get($class, $ordered[$key]);
            }
        }

        return $ordered;
    }

} 