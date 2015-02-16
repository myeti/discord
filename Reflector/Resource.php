<?php

namespace Discord\Reflector;

class Resource
{

    /** @var callable */
    public $callable;

    /** @var array */
    public $params = [];

    /** @var array */
    public $context = [];

    /** @var \ReflectionFunctionAbstract */
    public $reflector;


    /**
     * New callable resource
     *
     * @param callable $callable
     * @param array $params
     * @param array $context
     */
    public function __construct(callable $callable, array $params = [], array $context = [])
    {
        $this->callable = $callable;
        $this->params = $params;
        $this->context = $context;
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