<?php

namespace Discord\Reflector;

abstract class Resolver
{

    /** @var callable[] */
    protected static $types = [];


    /**
     * Add type resolver
     *
     * @param callable $resolver
     */
    public static function register(callable $resolver)
    {
        static::$types[] = $resolver;
    }


    /**
     * Resolve input callable
     *
     * @param $input
     *
     * @throws Resolver\ResourceNotValid
     * @return Resource
     */
    public static function resolve($input)
    {
        $types = [
            'static::resolveStaticMethod',
            'static::resolveClassMethod',
            'static::resolveInvokeMethod',
            'static::resolveFunction',
        ];

        $types = array_merge($types, static::$types);
        foreach($types as $type) {
            $resource = $type($input);
            if($resource instanceof Resource) {
                return $resource;
            }
        }

        throw new Resolver\ResourceNotValid;
    }


    /**
     * Resolve input callable as static method
     *
     * @param $input
     *
     * @return Resource
     */
    public static function resolveStaticMethod($input)
    {
        // parse class::method to [class, method]
        $action = $input;
        if(is_string($input) and strpos($input, '::') !== false) {
            $action = explode('::', $input);
        }

        // resolve [class, method]
        if(is_array($action) and count($action) === 2) {

            // read method
            $method = new \ReflectionMethod($action[0], $action[1]);

            // static method
            if($method->isPublic() and $method->isStatic()) {

                // read annotations
                $annotations = array_merge(
                    Annotations::ofClass($action[0]),
                    Annotations::ofMethod($action[0], $action[1])
                );

                // create resource
                $resource = new Resource($action, [], $annotations);
                $resource->origin = $input;
                $resource->reflector = $method;

                return $resource;
            }
        }
    }


    /**
     * Resolve input callable as class method
     *
     * @param $input
     *
     * @return Resource
     */
    public static function resolveClassMethod($input)
    {
        // parse class::method to [class, method]
        $action = $input;
        if(is_string($input) and strpos($input, '::') !== false) {
            $action = explode('::', $input);
        }

        // resolve [class, method]
        if(is_array($action) and count($action) === 2) {

            // read method
            $method = new \ReflectionMethod($action[0], $action[1]);

            // normal method
            if($method->isPublic() and !$method->isStatic() and !$method->isAbstract()) {

                // read annotations
                $annotations = array_merge(
                    Annotations::ofClass($action[0]),
                    Annotations::ofMethod($action[0], $action[1])
                );

                // create object
                if(!is_object($action[0])) {
                    $action[0] = Injector::make($action[0]);
                }

                // create resource
                $resource = new Resource($action, [], $annotations);
                $resource->origin = $input;
                $resource->reflector = $method;

                return $resource;
            }
        }
    }


    /**
     * Resolve input callable as invoke method
     *
     * @param $input
     *
     * @return Resource
     */
    public static function resolveInvokeMethod($input)
    {
        if((is_object($input) or class_exists($input)) and method_exists($input, '__invoke')) {
            return static::resolveClassMethod([$input, '__invoke']);
        }
    }


    /**
     * Resolve input callable as function
     *
     * @param $input
     *
     * @return Resource
     */
    public static function resolveFunction($input)
    {
        if($input instanceof \Closure or (is_string($input) and function_exists($input))) {

            // read annotations
            $annotations = Annotations::ofFunction($input);

            // create resource
            $resource = new Resource($input, [], $annotations);
            $resource->origin = $input;
            $resource->reflector = new \ReflectionFunction($input);

            return $resource;
        }
    }

}