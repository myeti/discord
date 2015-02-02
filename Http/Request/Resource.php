<?php

namespace Discord\Http\Request;

class Resource
{

    /** @var callable */
    public $callable;

    /** @var array */
    public $params = [];

    /** @var array */
    public $context = [];


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
     * Execute resource
     *
     * @return mixed
     */
    public function __invoke()
    {
        return call_user_func_array($this->callable, $this->params);
    }

}