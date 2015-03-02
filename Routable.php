<?php

namespace Discord\Router;

interface Routable
{

    /**
     * Find route from input
     *
     * @param string $from
     * @param array $rules
     *
     * @return mixed
     */
    public function find($from, array $rules = []);

}