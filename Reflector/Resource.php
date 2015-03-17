<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
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