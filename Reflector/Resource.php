<?php

namespace Discord\Reflector;

class Resource
{

    /** @var callable */
    public $origin;

    /** @var callable */
    public $callable;

    /** @var \ReflectionFunctionAbstract */
    public $reflector;

    /** @var array */
    public $annotations = [];

    /** @var array */
    public $params = [];


    /**
     * New callable resource
     *
     * @param callable $callable
     * @param array $params
     * @param array $annotations
     */
    public function __construct(callable $callable, array $params = [], array $annotations = [])
    {
        $this->callable = $callable;
        $this->annotations = $annotations;
        $this->params = $params;
    }


    /**
     * Execute callable
     *
     * @param $params
     *
     * @return mixed
     */
    public function __invoke(...$params)
    {
        $params = array_merge($this->params, $params);
        return call_user_func_array($this->callable, $params);
    }

} 