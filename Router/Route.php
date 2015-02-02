<?php

namespace Discord\Router;

class Route
{

    /** @var string */
    public $from;

    /** @var array */
    public $params = [];

    /** @var callable */
    public $resource;

    /** @var array */
    public $rules = [];


    /**
     * New route
     * @param string $from
     * @param callable|string $resource
     * @param array $rules
     */
    public function __construct($from, $resource, array $rules = [])
    {
        $this->from = $from;
        $this->resource = $resource;
        $this->rules = $rules;
    }

}