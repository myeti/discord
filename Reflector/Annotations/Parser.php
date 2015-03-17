<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
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