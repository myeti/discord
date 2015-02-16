<?php

namespace Discord\Http\Response;

use Discord\Http\Response;

class Forward extends Response
{

    /**
     * New Forward Response
     *
     * @param callable $resource
     * @param array $params
     */
    public function __construct(callable $resource, array $params = [])
    {

    }

} 