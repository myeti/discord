<?php

namespace Discord\Reflector\Annotations;

interface Parser
{


    /**
     * Parse annotations
     *
     * @param $string string
     * @return mixed
     */
    public function parse($string);

} 